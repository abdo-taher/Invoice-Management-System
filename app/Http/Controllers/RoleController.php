<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * نموذج الدور
     *
     * @var \Spatie\Permission\Models\Role
     */
    private $model;

    /**
     * إنشاء وحدة تحكم جديدة
     *
     * @param \Spatie\Permission\Models\Role $role
     */
    function __construct(Role $role)
    {
        $this->model = $role;
    }

    /**
     * عرض قائمة الموارد.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        // الحصول على جميع الأدوار بترتيب تنازلي حسب ID
        $roles = $this->model->orderBy('id', 'DESC')->get();
        return view('roles.index', compact('roles'));
    }

    /**
     * عرض النموذج لإنشاء مورد جديد.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * تخزين مورد جديد في قاعدة البيانات.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // التحقق من صحة البيانات
        $validated = $request->validate([
            'name' => 'required|unique:roles,name',
        ]);

        // إنشاء دور جديد باستخدام البيانات الصحيحة
        $this->model->create($validated);
        return redirect()->route('roles.index')->with('success', 'Role created successfully');
    }

    /**
     * عرض النموذج لتعديل المورد المحدد.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function edit($id)
    {
        // العثور على الدور بناءً على ID
        $role = $this->model->findOrFail($id);
        return view('roles.edit', compact('role'));
    }

    /**
     * تحديث المورد المحدد في قاعدة البيانات.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // التحقق من صحة البيانات
        $validated = $request->validate([
            'name' => 'required',
        ]);

        // تحديث الدور بناءً على ID
        if ($this->model->where('id', $id)->update($validated)) {
            return redirect()->route('roles.index')
                ->with('success', 'Role updated successfully');
        }

        return redirect()->route('roles.index')
            ->with('failed', 'Role update failed');
    }

    /**
     * حذف المورد المحدد من قاعدة البيانات.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // حذف الدور بناءً على ID
        $this->model->where('id', $id)->delete();

        // التحقق من حذف الدور بنجاح
        if ($this->model->where('id', $id)->doesntExist()) {
            return redirect()->route('roles.index')
                ->with('success', 'Role deleted successfully');
        }

        return redirect()->route('roles.index')
            ->with('failed', 'Role deletion failed');
    }
}
