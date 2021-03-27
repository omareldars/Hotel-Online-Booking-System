<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class UsersController extends Controller
{
    public function index(UsersDataTable $dataTable, Request $request)
    {
        $count = User::count();
        return $dataTable->render('dashboard.users.index', compact('count'));
    }

    public function create()
    {
        return view('dashboard.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'                   => 'required|string|min:5|max:25|unique:users,name',
            'phone'                  => 'required|string|min:11|max:25|unique:users,phone',
            'email'                  => 'required|email|unique:users,email',
            'password'               => 'required|min:3|max:25|confirmed',
            'password_confirmation'  => 'same:password',
            'image'                  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:8080',
        ]); // This For Validation The Inputs

        $request_data = $request->except(['password', 'password_confirmation', 'permissions', 'image']);
        $request_data['password'] = bcrypt($request->password);

        if (auth()->user()) {
            $request_data['approve']     = 1;
            $request_data['approved_by'] = auth()->user()->id;
        }

        if ($request->image) {
            Image::make($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('uploads/images/users/' . $request->image->hashName()));

            $request_data['image'] = $request->image->hashName();
        } // Upload Images To Uploads Folder

        $user = User::create($request_data);

        session()->flash('success', 'User Successfuly Created');
        return redirect()->route('dashboard.users.index');
    }

    public function show(User $user)
    {
        return view('dashboard.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('dashboard.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'                   => 'required|string|min:5|max:25|unique:admins,name,' . $user->id,
            'phone'                  => 'required|string|min:11|max:25|unique:admins,phone,' . $user->id,
            'email'                  => 'required|email|unique:admins,email,' . $user->id,
            'password'               => 'nullable|min:3|max:25|confirmed',
            'password_confirmation'  => 'nullable|same:password',
            'image'                  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:8080',
        ]); // This For Validation The Inputs

        $request_data = $request->except(['password', 'password_confirmation', 'permissions', 'image']);
        if ($request->password != null ) {
            $request_data['password'] = bcrypt($request->password);
        }

        if ($request->image) {
            Image::make($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('uploads/images/users/' . $request->image->hashName()));

            if($user->image != 'default.jpg' && file_exists(public_path('uploads/images/users/' . $user->image))) {
                unlink(public_path('uploads/images/users/' . $user->image));
            }
            $request_data['image'] = $request->image->hashName();
        } // Upload Images To Uploads Folder

        if (auth()->user() && $user->approve == 0 && $user->approved_by == null) {
            $request_data['approve']     = 1;
            $request_data['approved_by'] = auth()->user()->id;
        }

        $user->update($request_data);

        session()->flash('success', 'User Successfuly Updated');
        return redirect()->route('dashboard.users.index');
    }

    public function destroy(User $user)
    {
        if($user->delete()) {
            if($user->image != 'default.jpg' && file_exists(public_path('uploads/images/users/' . $user->image))) {
                unlink(public_path('uploads/images/users/' . $user->image));
            }
        }

        session()->flash('success', 'User Successfuly Deleted');
        return redirect()->route('dashboard.users.index');
    }

    public function approve(int $id)
    {
        $user = User::findOrFail($id);
        if($user) {
            $user->update([
                'approve'     => 1,
                'approved_by' => auth()->user()->id,
            ]);

            session()->flash('success', 'The user is approved Successfuly');
            return redirect()->route('dashboard.users.index');
        }

        session()->flash('error', 'This user not exists...');
        return redirect()->route('dashboard.users.index');
    }
}
