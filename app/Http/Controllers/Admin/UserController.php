<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
class UserController extends Controller
{
    public function index(): \Inertia\Response
    {
        return Inertia::render('Admin/UserManager', [
            'users' => User::all(),
            'roles' => Role::all(),
            'state' => (object) [
                'selectedKeys' => ['user-list'],
                'openKeys'=> ['user-manager'],
            ],
            'title' => 'User Manager',
        ]);
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt('123456789'),
        ]);

        $role = Role::find($request->input('role_id'));
        $user->assignRole($role);

        // store profile info
        $user->profile()->create([
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
        ]);

       return back();
    }
    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $user = User::find($id);
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);
        $user->profile()->update([
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
        ]);
        $user->removeRole($user->roles->first());
        $role = Role::find($request->input('role_id'));
        $user->assignRole($role);

        return back();
    }

    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $user = User::find($id);
        $user->profile()->delete();
        $user->delete();
        return back();
    }

}
