<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // التحقق مما إذا كان المستخدم موجودًا قبل محاولة إنشائه
        $user = User::where('email', 'test@example.com')->first();

        if (!$user) {
            $user = User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'), // تعيين كلمة مرور افتراضية
            ]);
        }

        // إنشاء صلاحيات متعددة
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

        // تعيين الدور إلى المستخدم
        $user->assignRole($adminRole);

        // إنشاء مستخدم آخر بدور user
        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
        $normalUser = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Normal User',
                'password' => bcrypt('password'), // تعيين كلمة مرور افتراضية
            ]
        );
        $normalUser->assignRole($userRole);
    }
}
