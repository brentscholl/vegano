<?php

namespace App\Console\Commands;

use App\Role;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vegano:create-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates the first admin user';

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
     * @return int
     */
    public function handle()
    {
        // Create the first admin user
        $user = User::create([
            'first_name' => 'Brent',
            'last_name' => 'Scholl',
            'email' => 'admin@vegano.com',
            'password' => Hash::make(env('ADMIN_PASSWORD'))
        ]);

        // Give user the admin role
        $role = Role::find(1);
        $user->assignRole($role);
    }
}
