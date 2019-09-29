# SAASLER INTEGRATION DEMO APP

## Steps to run the project

- Setup the app by running `composer install` 
- Create an `.env` file, duplicating the `.env.sample`.
- Add your keys to `.env` file. Visit [doc.saasler.com](http://doc.saasler.com/#/how-to-setup-my-app) to more information.
- Add the Intent ID (It should be published) to the `.env` file
- Run the application: `php artisan serve`
- Open [http://localhost:8000/](http://localhost:8000/)


## Notes:

### In file `WelcomeController.php`

Funcion `saasler_secure_token()`: 

Use your private key and saasler public key to generate the encrypted box.  
The `sodium_crypto_box` function doesn't return the encrypted message with nonce.  
Remember to add the nonce to the encrypted message before send it to Saasler.  
`$msg_with_nonce = $nonce . $encrypted_msg;`

