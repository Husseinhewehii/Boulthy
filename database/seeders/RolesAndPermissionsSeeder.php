<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SystemRole as Role;
use App\Models\SystemPermission as Permission;
use Illuminate\Support\Facades\DB;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $tables = [
            'users',
            'roles',
            'categories',
            'products',
            'tags',
            'discounts',
            'addresses',
            'promos',
            'order_items',
            'blogs',
            'vacancies',
            'partners',
            'faqs',
            'sliders',
            'cities',
            'districts',
            // ... // List all your Models you want to have Permissions for.
        ];

        $view_tables = [
            'permissions',
            'activity_log',
            'wallets',
            'transactions',
            'commissions',
            'orders',
            'job_applications',
            'settings',
            "page_headers",
            'partitions',
        ];

        $update_tables = [
            'static_content',
            'orders',
            'settings',
            "page_headers",
            'partitions',
        ];

        $comments = [
            'blogs_comments',
        ];

        $this->reset_tables();
        $this->create_permissions($tables, $view_tables, $update_tables, $comments);
        $this->give_permissions_to_role();
    }

    public function create_permissions($tables, $view_tables, $update_tables, $comments)
    {
        foreach ($tables as $table) {
            Permission::create(['name' => 'viewAny ' . $table, "guard_name" => "api"]);
            Permission::create(['name' => 'view ' . $table, "guard_name" => "api"]);
            Permission::create(['name' => 'create ' . $table, "guard_name" => "api"]);
            Permission::create(['name' => 'update ' . $table, "guard_name" => "api"]);
            Permission::create(['name' => 'delete ' . $table, "guard_name" => "api"]);
            Permission::create(['name' => 'restore ' . $table, "guard_name" => "api"]);
            Permission::create(['name' => 'forceDelete ' . $table, "guard_name" => "api"]);
        }

        foreach ($view_tables as $table) {
            Permission::create(['name' => 'viewAny ' . $table, "guard_name" => "api"]);
            Permission::create(['name' => 'view ' . $table, "guard_name" => "api"]);
        }

        foreach ($update_tables as $table) {
            Permission::create(['name' => 'update ' . $table, "guard_name" => "api"]);
        }

        foreach ($comments as $table) {
            Permission::create(['name' => 'update ' . $table, "guard_name" => "api"]);
            Permission::create(['name' => 'delete ' . $table, "guard_name" => "api"]);
            Permission::create(['name' => 'delete client ' . $table, "guard_name" => "api"]);
            Permission::create(['name' => 'delete admin ' . $table, "guard_name" => "api"]);
            Permission::create(['name' => 'delete super-admin ' . $table, "guard_name" => "api"]);
        }
    }

    public function give_permissions_to_role()
    {
        // Create a Super-Admin Role and assign all Permissions
       $role = Role::firstOrCreate(['name' => 'super-admin', "guard_name" => "api"]);
       $role->givePermissionTo(Permission::all());
    }

    public function reset_tables()
    {
        DB::statement("SET foreign_key_checks=0");
        DB::table('permissions')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::statement("SET foreign_key_checks=1");
    }
}
