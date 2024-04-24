<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class MakeCRMUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crm-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make CRM user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        while (true) {
            $username = $this->ask('Enter your username');
            if (User::where('username', $username)->first()) {
                $this->error('username already exists');
            } else {
                break;
            }
        }

        do {
            $password = $this->secret('Enter your password');
            $confirmPassword = $this->secret('Confirm your password');
            if ($password !== $confirmPassword) {
                $this->error("Passwords doesn't match");
            }
        } while ($password !== $confirmPassword);
        User::create([
            'username' => $username,
            'password' => Hash::make($password),
        ]);
    }
}
