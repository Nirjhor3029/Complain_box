<?php

namespace App\Http\Controllers;

use App\Authorizable;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    use Authorizable;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware([
            'web',
            'auth',
            'isActive',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::with('roles')->orderByDesc('updated_at')->orderBy('first_name')->paginate(25);

        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::orderBy('id')->select('id', 'name')->get();

        return view('user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'is_active' => 'boolean',
            'staff_id' => 'required|unique:users|max:60',
            'first_name' => 'present|nullable|max:60',
            'last_name' => 'present|nullable|max:60',
            'email' => 'required|email|unique:users|max:120',
            'cell_number' => 'present|nullable|max:20',
            'designation' => 'present|nullable|max:120',
            'team' => 'present|nullable|max:60',
            'password' => 'required|confirmed|min:8|max:255',
        ]);

        $filters = [
            'is_active' => 'cast:boolean',
            'first_name' => 'trim|escape|capitalize',
            'last_name' => 'trim|escape|capitalize',
            'email' => 'trim|escape|lowercase',
            'designation' => 'trim|escape|capitalize',
            'team' => 'trim|escape|capitalize',
        ];

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::firstOrCreate(formSanitizer($validator->validated(), $filters));

        // Retrieving the Roles field
        $roles = $request->get('roles');
        // Checking if any Role was selected
        if ($roles !== null) {
            foreach ($roles as $role) {
                $assignRole = Role::whereId($role)->firstOrFail();
                // Assigning the Role to the User
                $user->assignRole($assignRole);
            }
        }

        laraflash()->message('User: '.$user->first_name.' was created on '.Carbon::now()->format('F j, Y, g:i A'))->success();

        return redirect()->route('dashboard.user.edit', $user->uuid);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        $roles = Role::orderBy('id')->select('id', 'name')->get();

        return view('user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, User $user): \Illuminate\Http\RedirectResponse
    {
        if ($request->filled('password')) {
            $validator = Validator::make($request->all(), [
                'is_active' => 'boolean',
                'staff_id' => ['required', Rule::unique('users')->ignore($user->id), 'max:60'],
                'first_name' => 'present|nullable|max:60',
                'last_name' => 'present|nullable|max:60',
                'email' => ['required', 'email', Rule::unique('users')->ignore($user->id), 'max:120'],
                'cell_number' => 'present|nullable|max:20',
                'designation' => 'present|nullable|max:120',
                'team' => 'present|nullable|max:60',
                'password' => 'required|confirmed|min:8|max:255',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'is_active' => 'boolean',
                'staff_id' => ['required', Rule::unique('users')->ignore($user->id), 'max:60'],
                'first_name' => 'present|nullable|max:60',
                'last_name' => 'present|nullable|max:60',
                'email' => ['required', 'email', Rule::unique('users')->ignore($user->id), 'max:120'],
                'cell_number' => 'present|nullable|max:20',
                'designation' => 'present|nullable|max:120',
                'team' => 'present|nullable|max:60',
            ]);
        }

        $filters = [
            'is_active' => 'cast:boolean',
            'first_name' => 'trim|escape|capitalize',
            'last_name' => 'trim|escape|capitalize',
            'email' => 'trim|escape|lowercase',
            'designation' => 'trim|escape|capitalize',
            'team' => 'trim|escape|capitalize',
        ];

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user->update(formSanitizer($validator->validated(), $filters));

        // Retrieve All Roles
        $roles = $request->get('roles');

        if ($roles !== null) {
            // If One or More Role is selected associate User to Roles
            $user->roles()->sync($roles);
        } else {
            // If No Role is selected remove existing Role associated to the User
            $user->roles()->detach();
        }

        laraflash()->message($user->first_name.'\'s account was updated on '.Carbon::now()->format('F j, Y, g:i A'))->success();

        return redirect()->route('dashboard.user.edit', $user->uuid);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(User $user): \Illuminate\Http\RedirectResponse
    {
        $user->delete();

        laraflash()->message($user->first_name.'\'s account was deleted on '.Carbon::now()->format('F j, Y, g:i A'))->success();

        return redirect()->route('dashboard.user.index');
    }
}
