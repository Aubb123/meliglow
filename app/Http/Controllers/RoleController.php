<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class RoleController extends Controller
{
    public function backend_roles_index(): View
    {  
        $roles = Role::all(); 
        return view('backend/pages/roles/index', compact('roles'));
    }

    public function backend_roles_show($token): View
    {  
        $role = Role::where('token', $token)->firstOrFail();
        
        return view('backend/pages/roles/show', compact('role'));
    }

    public function backend_roles_edit($token): View
    {  
        $role = Role::where('token', $token)->firstOrFail();
        return view('backend/pages/roles/edit', compact('role'));
    }

    public function backend_roles_update(Request $request, $token): RedirectResponse
    {  
        $role = Role::where('token', $token)->firstOrFail();
        
        $validatedData = $request->validate([
            'label' => ['required', 'string', 'min:5', 'max:25', 'unique:roles,label,' . $role->id],
            'description' => ['nullable', 'string', 'min:5'],
        ]);

        Role::where('id', $role->id)->where('token', $token)->update([
            'label' => $validatedData['label'],
            'description' => $validatedData['description'],
            'updated_at' => getDateTime(), 
        ]);

        return redirect()->route('backend.roles.show', $role->token)->with('success', 'Role mise à jour avec succès.');
    }

    // 

    public function backend_roles_users($token): View
    {  
        $role = Role::where('token', $token)->firstOrFail();
        $users = $role->users;
        
        return view('backend/pages/roles/others/users', compact('role', 'users'));
    }
}
