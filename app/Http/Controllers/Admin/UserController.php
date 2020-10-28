<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role->role == 'admin'){
            $users = User::all();
            return view('admin.users.home', compact('users'));
        } else {
            abort(404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if (Auth::user()->role->role == 'admin'){
            return view('admin.users.show', compact('user'));
        } else {
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if (Auth::user()->role->role == 'admin'){
            $roles = Role::all();
            return view('admin.users.edit', compact('user', 'roles'));
        } else {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if (Auth::user()->role->role == 'admin'){
            $data = $request->all();
            $role_id = DB::select('select * from roles where role = ?', [$data['role_id']]);
            $data['role_id'] = $role_id[0]->id;
            $request->validate([
                'name' => 'required',
                'email' => [
                        'required',
                        Rule::unique('users')->ignore($user->id),
                ]
            ]);
            $user->update($data);
            return redirect()->route('users.index')->with('status', 'Utente'.' '.$user->name.' '.'salvato correttamente');
        } else {
            abort(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('status', 'Utente'.' '.$user->name.' '.'eliminato correttamente');
    }
}
