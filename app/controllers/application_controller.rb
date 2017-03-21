class ApplicationController < ActionController::Base
  protect_from_forgery with: :exception

  helper_method :saasler_secure_token, :saasler_tenant_id

  private

  def saasler_keys
    {
      'SAASLER_JWT_SECRET': ENV['SAASLER_JWT_SECRET'],
      'SAASLER_PUBLIC_NACL': ENV['SAASLER_PUBLIC_NACL'],
      'MY_NACL_PRIVATE_KEY': ENV['MY_NACL_PRIVATE_KEY'],
      'MY_NACL_PUBLIC_KEY': ENV['MY_NACL_PUBLIC_KEY'],
      'SAASLER_TENANT_ID': ENV['SAASLER_TENANT_ID']
    }
  end

  def saasler_jwt
    iat = Time.zone.now.to_i
    exp = iat + 2.minutes.to_i
    payload = {
      iat: iat,
      exp: exp,
      id: '2',
      email: 'user2@geckoboard.com',
      token: 'random_token_2'
    }
    # Remember to not leave keys on your code, this is the secret you grabed last step
    JWT.encode payload, saasler_keys[:SAASLER_JWT_SECRET], 'HS256'
  end

  def saasler_secure_token
    # Remember to not leave keys on your code
    saasler_public_key = RbNaCl::Util.hex2bin(saasler_keys[:SAASLER_PUBLIC_NACL])
    # Substitute 'YOUR_NACL_PRIVATE_KEY' with your actual key,
    your_private_key = RbNaCl::Util.hex2bin(saasler_keys[:MY_NACL_PRIVATE_KEY])
    box = RbNaCl::SimpleBox.from_keypair(saasler_public_key, your_private_key)
    encrypted_message = box.encrypt(saasler_jwt)
    # share it on hex
    RbNaCl::Util.bin2hex(encrypted_message)
  end

  def saasler_tenant_id
    saasler_keys[:SAASLER_TENANT_ID]
  end
end
