<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // إنشاء الصلاحيات
        $permissions = [
            'manage users',
            'manage clients',
            'manage units',
            'manage taxes',
            'manage invoices',
            'manage expenses',
            'manage crossovers',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // إنشاء الأدوار وربطها بالصلاحيات
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions($permissions); // ربط كافة الصلاحيات بدور admin

        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
        $userRole->syncPermissions(['manage clients', 'manage invoices']); // صلاحيات محددة لدور user

        // إنشاء مستخدم افتراضي وربطه بدور admin
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'), // تأكد من تغيير كلمة المرور لاحقًا
            ]
        );
        $adminUser->assignRole($adminRole);

        // إنشاء مستخدم افتراضي وربطه بدور user
        $normalUser = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Normal User',
                'password' => bcrypt('password'), // تأكد من تغيير كلمة المرور لاحقًا
            ]
        );
        $normalUser->assignRole($userRole);
    }
}
