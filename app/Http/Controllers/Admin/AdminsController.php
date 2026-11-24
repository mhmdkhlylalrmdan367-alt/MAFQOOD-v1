<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Melbedran\RolePermession\Models\Role;
use Illuminate\Support\Facades\Gate;

class AdminsController extends Controller
{
    //
    public function index()
    {
        Gate::authorize('admins.view');
        return view('admin.admins.index', [
            'admins' =>  Admin::latest()->paginate(10),
        ]);
    }
    protected function roles()
    {
        return Role::query()->orderBy('name')->get();
    }
    public function create()
    {
        Gate::authorize('admins.create');
        return view('admin.admins.create', [
            'roles' => $this->roles(),
            'admin' => new Admin,

        ]);
    }
    protected function validated(Request $request, ?Admin $admin = null)
    {
        $rolesTable = Config::get('role-permession.tables.roles', 'roles');
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'roles' => ['required', 'array'],
            'roles.*' => ['required', 'exists:' . $rolesTable . ',id']
        ]);
    }

    public function store(Request $request)
    {
        Gate::authorize('admins.create');
        $data = $this->validated($request);
        $roleIds = $data['roles'];
        $data['super_admin'] = $request->boolean('super_admin');
        if ($data['password']) {
            $data['password'] = Hash::make($data['password']);
        }
        $admin = Admin::create($data);
        $admin->roles()->sync($roleIds);
        return redirect()->route('admin.admins.index')->with('success', 'تمت الاضافة بنجاح');
    }
    public function edit(Admin $admin)
    {
        Gate::authorize('admins.update');
        return view('admin.admins.edit', [
            'admin' => $admin,
            'roles' => $this->roles(),
        ]);
    }
    public function update(Request $request, Admin $admin)
    {
        Gate::authorize('admins.update');
        $data = $this->validated($request, $admin);
        $rolesIds = $data['roles'];
        $data['super_admin'] = $request->boolean('super_admin');
        if (empty($data['password'])) {
            unset($data['password']);
        }
        $admin->update($data);
        $admin->roles()->sync($rolesIds);
        return redirect()->route('admin.admins.index')->with('success', 'تم التعديل بنجاح');
    }
    public function destroy(Admin $admin)
    {
        Gate::authorize('admins.delete');
        if ($admin->id === Auth::guard('admin')->user()->id) {
            return redirect()->route('admin.admins.index')->with('error', 'لا يمكنك حذف نفسك');
        }
        $admin->delete();
        return redirect()->route('admin.admins.index')->with('success', 'تم الحذف بنجاح');
    }

}
