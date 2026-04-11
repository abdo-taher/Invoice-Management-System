<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AddRolesAndPermissions extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // إنشاء الأدوار
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $editorRole = Role::firstOrCreate(['name' => 'editor']);
        $viewerRole = Role::firstOrCreate(['name' => 'viewer']);

        // إنشاء الصلاحيات
        $manageUsersPermission = Permission::firstOrCreate(['name' => 'manage users']);
        $editContentPermission = Permission::firstOrCreate(['name' => 'edit content']);
        $viewContentPermission = Permission::firstOrCreate(['name' => 'view content']);

        // تعيين الصلاحيات إلى الأدوار
        $adminRole->givePermissionTo($manageUsersPermission);
        $adminRole->givePermissionTo($editContentPermission);
        $adminRole->givePermissionTo($viewContentPermission);

        $editorRole->givePermissionTo($editContentPermission);
        $editorRole->givePermissionTo($viewContentPermission);

        $viewerRole->givePermissionTo($viewContentPermission);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // إزالة الصلاحيات
        Permission::where('name', 'manage users')->delete();
        Permission::where('name', 'edit content')->delete();
        Permission::where('name', 'view content')->delete();

        // إزالة الأدوار
        Role::where('name', 'admin')->delete();
        Role::where('name', 'editor')->delete();
        Role::where('name', 'viewer')->delete();
    }
}
