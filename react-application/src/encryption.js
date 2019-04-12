import nacl_factory from "js-nacl";

// Generate your keys using the included ruby file.
const HEX_PRIVATE_KEY = '';
const HEX_PUBLIC_KEY = '';
const SAASLER_JWT_SECRET = '';
const SAASLER_PUBLIC_HEX_NACL_KEY = '';

const saaslerJWT = (userId, email, token) => {
  let payload = {
    id: userId,
    email: email,
    token: token
  }

  let jwt = require('jsonwebtoken');
  return jwt.sign(payload, SAASLER_JWT_SECRET, {expiresIn: 120});
}

const convertUint8ArrayToBinaryString = (u8Array) => {
  var i, len = u8Array.length, b_str = "";
  for (i=0; i<len; i++) {
    b_str += String.fromCharCode(u8Array[i]);
  }
  return b_str;
}


const encryptJWT = () => {
  let initiated_nacl = "";

  nacl_factory.instantiate(function (nacl) {
    initiated_nacl = nacl;
  });

  let nonce = initiated_nacl.crypto_secretbox_random_nonce();

  let privateKey = initiated_nacl.from_hex(HEX_PRIVATE_KEY);
  let saaslerPublicKey = initiated_nacl.from_hex(SAASLER_PUBLIC_HEX_NACL_KEY);

  let jwt = initiated_nacl.encode_utf8(saaslerJWT('12345', 'test@email.com', 'token_to_access_own_api'));
  
  let encrypted_token = initiated_nacl.crypto_box(jwt, nonce, saaslerPublicKey, privateKey);
  
  // Join the Nonce and Message. This is so the server knows how to decrypt the
  // message
  return initiated_nacl.to_hex(nonce) + initiated_nacl.to_hex(encrypted_token);
}

export default encryptJWT();