namespace SodiumClient {
    using System;
    using Microsoft.IdentityModel.Tokens;
    using System.IdentityModel.Tokens.Jwt;
    using System.Security.Claims;
    using static System.Console;
    using static System.Convert;
    using static Sodium.Utilities;
    using System.Text;
    using Newtonsoft.Json;
    using System.Security.Cryptography;
    class Program {
        const string SAASLER_JWT_SECRET =
            "3c66af51a6db4a6e560c417f827c855351e3c8c9";
        static void Main(string[] args) {
            // 1. Gen Keys.
            // This part should be done only once. Then, you would need to store
            // the values in some sort of environment variable.
            // kp.PrivateKey and kp.PublicKey return an array of Bytes.
            // you should use in the environment variable the HEX value of the key
            // It will make it easier to set.
            var kp = Sodium.PublicKeyBox.GenerateKeyPair();
            // helps converting the keys to a format that can be used in text files.
            var myPriKey = BinaryToHex(kp.PrivateKey);
            var myPubKey = BinaryToHex(kp.PublicKey);

            // Then, for regular user we would need to convert the keys to a
            // an array of bytes.
            var my_binary_pri_key = HexToBinary(myPriKey);
            var my_binary_pub_key = HexToBinary(myPubKey);

            // The SAASLER_PUBLIC_NACL key, should be also on an environment variable.
            var saalser_public_nacl = "SAASLER_PUBLIC_NACL";
            // and since we share it in HEX value, we need to convert it to a Byte format.
            var saalser_public_nacl_bin = HexToBinary(saalser_public_nacl);

            // The explanation for this method can be found is below. Basicaly it is a function
            // that returns the JWT TOKEN that we will encrypt using the Sodium library.
            var jwt_message = CreateJWT("your_user_id", "your_user_email","your_user_token");

            // This part is from the sodium documentation, we are generating a nonce that will be used
            // to encrupt a message. Using your private key, and Saasler Public key. This way saasler is able to
            // - validate the message comes from you (becase we have your public key)
            // - and decrypt it because you encrypted it using our public key.
            var nonce_value = Sodium.PublicKeyBox.GenerateNonce();
            var new_message = Sodium.PublicKeyBox.Create(jwt_message, nonce_value, my_binary_pri_key, saalser_public_nacl_bin);

            // this part is weird, because it works different in the ruby library.
            // In order to be able to decrypt a message the library needs the nonce value used. 
            // This library does not include the nonce in the encrypted message
            // so what we do here is make a new array, that has in the first 8 bytes the nonce and 
            // after that it has the encrypted message bits.
            var message_plus_nonce = new byte[nonce_value.Length + new_message.Length];
            nonce_value.CopyTo(message_plus_nonce, 0);
            new_message.CopyTo(message_plus_nonce, nonce_value.Length);

            // We then need the HEX value of the message. And this value is the one that will be
            // either put in the HTML CODE or send via POST request to Saaslers API.
            WriteLine(BinaryToHex(message_plus_nonce));

            // this is just so the program stops here.
            ReadLine();
        }

        // This method helps to create the JWT.
        // I tried using a JWT library, but could not get it to work. That is why
        // this method replicates the funcionality to build a JWT token.
        // The important part to understand here is that the values that are added to the payload
        // will be received by Saasler and stored as properties of the user. Ex: name, plan_id, etc.
        public static string CreateJWT(
            string yourUserId, string yourUserEmail, string yourUserToken) {
            var header = new {
                alg = "HS256",
                //typ = "JWT" <- This is to commented so it generates a JWT similar to the one the Ruby library generates.
            };

            // The header of the JWT token.
            var headerPart = Base64UrlEncoder.Encode(JsonConvert.SerializeObject(header));

            // Defining the JWT token payload
            var iat_ = DateTime.Now;
            var exp_ = iat_.AddMinutes(2);
            var payload = new {
                iat   = Math.Truncate(DateTimeToUnixTimestamp(iat_)),
                exp   = Math.Truncate(DateTimeToUnixTimestamp(exp_)),
                // you can add other attributes here.
                // They will be used in the future to make filters.
                id    = yourUserId,
                email = yourUserEmail,
                token = yourUserToken,
            };

            var payloadPart = Base64UrlEncoder.Encode(JsonConvert.SerializeObject(payload));

            // This MUST be the JWT SECRET generated for your account.
            // This will allow Saasler to decode the JWT TOKEN
            var secret = "SAASLER_JWT_SECRET";
            var sha256 = new HMACSHA256(Encoding.UTF8.GetBytes(secret));
            var hashBytes = sha256.ComputeHash(Encoding.UTF8.GetBytes($"{headerPart}.{payloadPart}"));
            var hash = Base64UrlEncoder.Encode(hashBytes);
            var jwt = $"{headerPart}.{payloadPart}.{hash}";
            return jwt;
        }

        // A halper method to handle dates. 
        public static double DateTimeToUnixTimestamp(DateTime dateTime) {
            return (TimeZoneInfo.ConvertTimeToUtc(dateTime) -
                   new DateTime(1970, 1, 1, 0, 0, 0, 0, 
                   System.DateTimeKind.Utc)).TotalSeconds;
        }
    }
}
