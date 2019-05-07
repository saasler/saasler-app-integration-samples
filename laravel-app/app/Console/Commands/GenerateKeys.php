<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateKeys extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sodium:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate public and private keys with Sodium';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $key_pair = sodium_crypto_box_keypair();
        $sign_key_pair = sodium_crypto_sign_keypair();

        $secret = sodium_crypto_box_secretkey($key_pair);
        $public = sodium_crypto_box_publickey($key_pair);
        
        $this->info('Secret key: ' . sodium_bin2hex($secret));
        $this->info('Public key: ' . sodium_bin2hex($public));
    }
}
