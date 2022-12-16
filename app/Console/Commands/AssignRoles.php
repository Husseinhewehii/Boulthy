<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\SystemRole as Role;

class AssignRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assign:super-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'assign super admin role for super admin';

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
        $role = Role::where('name', 'super-admin')->first();
        $user = User::whereEmail('super@admin.com')->first();
        $user->assignRole($role);
        $this->info("$user->name has been assigned as $role->name successfully");
    }
}
