require 'rbnacl'
require 'active_support/time'
require 'jwt'
Time.zone = 'Eastern Time (US & Canada)' #=> "Eastern Time (US & Canada)"

# private_key = RbNaCl::PrivateKey.generate
# public_key = private_key.public_key

private_key = RbNaCl::Util.hex2bin('generate them with the lines up and paste them here')
public_key = RbNaCl::Util.hex2bin('generate them with the lines up and paste them here')

def saasler_jwt
  iat = Time.zone.now.to_i
  exp = iat + 2.hours.to_i
  payload = {
    iat: iat,
    exp: exp,
    id: 'your_user_id',
    email: 'your_user_email',
    token: 'your_user_token'
  }

  JWT.encode payload, 'SAASLER JWT TOKEN', 'HS256'
end

saasler_public_key = RbNaCl::Util.hex2bin('THE PUBLIC NACL KEY FROM SAASLER')

box = RbNaCl::SimpleBox.from_keypair(saasler_public_key, private_key)
encrypted_message = box.encrypt(saasler_jwt)

puts ""
puts "private key: #{RbNaCl::Util.bin2hex(private_key)}"
puts ""
puts "public key: #{RbNaCl::Util.bin2hex(public_key)}"
puts ""
puts "Token: #{RbNaCl::Util.bin2hex(encrypted_message)}"
