<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ConvertLogoToBase64 extends Command
{
    protected $signature = 'logo:convert';
    protected $description = 'Convert logo to base64';

    public function handle()
    {
        $path = public_path('images/logo.svg');
        if (!file_exists($path)) {
            $this->error('Logo file not found!');
            return 1;
        }

        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = base64_encode($data);
        
        $this->info($base64);
        return 0;
    }
}
