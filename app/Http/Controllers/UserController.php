<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\{UserUpdateRequest, UserAddRequest};
use Spatie\Permission\Models\Role;
use App;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->can('create-users')) {
            return abort(403);
        }

        $users = new User;
        if ($request->q) {
            $users = $users->orWhere('name', 'like', '%' . $request->q . '%')->orWhere('surname', 'like', '%' . $request->q . '%')->orWhere('email', 'like', '%' . $request->q . '%');
        }
        $users = $users->orderBy('id', 'desc')->paginate(20)->appends(['q' => $request->q]);
        //return response()->json($users);

        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->can('create-users')) {
            return abort(403);
        }
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserAddRequest $request)
    {
        if (!Auth::user()->can('create-users')) {
            return abort(403);
        }
        $user = User::create($request->all());
        $user->password = Hash::make($user->password);
        $role = Role::find($request->role);
        if ($role) {
            $user->assignRole($role);
        }
        $user->save();
        return redirect()->back()->with('result_post', json_encode([
            'status' => 'success',
            'message' => 'Kullanıcı ekleme işlemi başarılı.'
        ]));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if ($user->id !== Auth::user()->id && !Auth::user()->hasRole('Admin')) {
            return abort(403);
        }
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        if ($user->id !== Auth::user()->id && !Auth::user()->hasRole('Admin')) {
            return abort(403);
        }
        if ($request->role && $request->user()->can('edit-users') && !$user->isme) {
            $updatedUser = $user->update($request->only([
                'name', 'email', 'surname', 'status', 'username', 'balance'
            ]));
        } else {
            $updatedUser = $user->update($request->only([
                'name', 'surname', 'username'
            ]));
        }

        if ($request->password) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        if ($request->role && $request->user()->can('edit-users') && !$user->isme) {
            $role = Role::find($request->role);
            if ($role) {
                $user->syncRoles([$role]);
            }
        }

        return redirect()->back()->with('result_post', json_encode([
            'status' => 'success',
            'message' => __('Transaction Successful!')
        ]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        return abort(403);
        if (!Auth::user()->can('create-users')) {
            return abort(403);
        }
        if (!App::environment('demo') && !$user->isme) {
            $user->delete();
            return redirect()->back()->with('result_post', json_encode([
                'status' => 'success',
                'message' => 'Kullanıcı silme işlemi başarılı.'
            ]));
        } else {
            return response()->json(['message' => 'User accounts cannot be deleted in demo mode.'], 400);
        }
    }

    public function roles()
    {
        return response()->json(Role::get());
    }
}
