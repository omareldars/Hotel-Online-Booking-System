<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\AdminsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ManagersController extends Controller
{
    public function index(AdminsDataTable $dataTable)
    {
        $count = Admin::whereDoesntHaveRole()->orWhereRoleIs(['manager'])->latest()->count();
        return $dataTable->render('dashboard.managers.index', compact('count'));
    }

    public function create()
    {
        return view('dashboard.managers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'                   => 'required|string|min:5|max:25|unique:admins,name',
            'phone'                  => 'required|string|min:11|max:25|unique:admins,phone',
            'national_id'            => 'required|numeric|digits:14|unique:admins,national_id',
            'email'                  => 'required|email|unique:admins,email',
            'password'               => 'required|min:3|max:25|confirmed',
            'password_confirmation'  => 'same:password',
            'role'                   => 'in:receptionist,manager',
            'image'                  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:8080',
        ]); // This For Validation The Inputs

        $request_data = $request->except(['password', 'password_confirmation', 'permissions', 'image', 'role']);
        $request_data['password'] = bcrypt($request->password);
        $request_data['created_by'] = auth()->user()->id;

        if ($request->image) {
            Image::make($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('uploads/images/admins/' . $request->image->hashName()));

            $request_data['image'] = $request->image->hashName();
        } // Upload Images To Uploads Folder

        $manager = Admin::create($request_data);
        $manager->attachRole('manager');
        session()->flash('success', 'Manager Successfuly Created');
        return redirect()->route('dashboard.managers.index');
    }

    // public function show(Admin $admin)
    // {
    //     return view('dashboard.managers.show', compact('admin'));
    // }

    public function show(Admin $manager)
    {
        return view('dashboard.managers.show', compact('manager'));
    }

    public function edit(Admin $manager)
    {
        return view('dashboard.managers.edit-2', compact('manager'));
    }

    public function update(Request $request, Admin $manager)
    {
        $request->validate([
            'name'                   => 'required|string|min:4|max:25|unique:admins,name,' . $manager->id,
            'phone'                  => 'required|string|min:11|max:25|unique:admins,phone,' . $manager->id,
            'national_id'            => 'required|numeric|digits:14|unique:admins,national_id,' . $manager->id,
            'email'                  => 'required|email|unique:admins,email,' . $manager->id,
            'password'               => 'nullable|min:3|max:25|confirmed',
            'password_confirmation'  => 'nullable|same:password',
            'role'                   => 'in:receptionist,manager',
            'image'                  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:8080',
        ]); // This For Validation The Inputs

        $request_data = $request->except(['password', 'password_confirmation', 'permissions', 'image', 'role']);
        if ($request->password != null ) {
            $request_data['password'] = bcrypt($request->password);
        }
        $request_data['created_by'] = auth()->user()->id;

        if ($request->image) {
            Image::make($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('uploads/images/admins/' . $request->image->hashName()));

            if($manager->image != 'default.jpg' && file_exists(public_path('uploads/images/admins/' . $manager->image))) {
                unlink(public_path('uploads/images/admins/' . $manager->image));
            }
            $request_data['image'] = $request->image->hashName();
        } // Upload Images To Uploads Folder

        $manager->update($request_data);
        session()->flash('success', 'Manger Successfuly Updated');
        return redirect()->route('dashboard.managers.index');
    }

    public function destroy(Admin $manager)
    {
        if ($manager->floors->count() == 0) {
            if ($manager->delete()) {
                if ($manager->image != 'default.jpg' && file_exists(public_path('uploads/images/admins/' . $manager->image))) {
                    unlink(public_path('uploads/images/admins/' . $manager->image));
                }
            }

            session()->flash('success', 'Manger Successfuly Deleted');
            return redirect()->route('dashboard.managers.index');
        }
        session()->flash('error', 'cann\'t Deleted Manager');
        return redirect()->route('dashboard.managers.index');
    }

    public function banned(Admin $manager)
    {
        $manager->update(['banned' => 1,]);

        session()->flash('success', 'Manger Successfuly Bannded');
        return redirect()->route('dashboard.managers.index');
    }

    public function unbanned(Admin $manager)
    {
        $manager->update(['banned' => 0]);

        session()->flash('success', 'Manger Successfuly Unbannded');
        return redirect()->route('dashboard.managers.index');
    }
}