<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Firebase\JWT\JWT;

class WelcomeController extends Controller
{
    
    public function index()
    {
        $token = $this->saasler_secure_token();
        $saasler_tenant_id = env('SAASLER_TENANT_ID');
        
        return view(
            'welcome', [
                'saasler_token' => $token, 
                'saasler_tenant_id' => $saasler_tenant_id,
            ]
        );
    }

    private function saasler_secure_token()
    {
        $saasler_public_key = sodium_hex2bin(env('SAASLER_PUBLIC_NACL'));
        $your_private_key = sodium_hex2bin(env('MY_NACL_PRIVATE_KEY'));
        
        $box = sodium_crypto_box_keypair_from_secretkey_and_publickey(
            $your_private_key,
            $saasler_public_key
        );

        $nonce = random_bytes(SODIUM_CRYPTO_BOX_NONCEBYTES);

        $saasler_jwt = $this->saasler_jwt();
        $encrypted_msg = sodium_crypto_box(
            $saasler_jwt,
            $nonce,
            $box
        );
        $msg_with_nonce = $nonce . $encrypted_msg;
        
        return sodium_bin2hex($msg_with_nonce);
    }

    private function saasler_jwt()
    {
        $time = time();
        $key = env('SAASLER_JWT_SECRET');

        $payload = array(
            'iat' => $time,
            'exp' => $time + (60 * 2),
            'id' => 2,
            'email' => 'user2@geckoboard.com'
        );

        return JWT::encode($payload, $key);
    }
}
