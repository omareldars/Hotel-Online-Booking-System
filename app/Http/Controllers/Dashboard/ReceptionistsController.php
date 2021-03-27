<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\ReceptionistsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ReceptionistsController extends Controller
{
    public function index(ReceptionistsDataTable $dataTable)
    {
        $count = Admin::whereDoesntHaveRole()->orWhereRoleIs(['receptionist'])->latest()->count();
        return $dataTable->render('dashboard.receptionists.index', compact('count'));
    }

    public function create()
    {
        return view('dashboard.receptionists.create');
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
            'image'                  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:8080',
        ]); // This For Validation The Inputs

        $request_data = $request->except(['password', 'password_confirmation', 'image']);
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

        $admin = Admin::create($request_data);
        $admin->attachRole('receptionist');
        session()->flash('success', 'Receptionist Successfuly Created');
        return redirect()->route('dashboard.receptionists.index');
    }

    public function show(Admin $receptionist)
    {
        return view('dashboard.receptionists.show', compact('receptionist'));
    }

    public function edit(Admin $receptionist)
    {
        return view('dashboard.receptionists.edit', compact('receptionist'));
    }

    public function update(Request $request, Admin $receptionist)
    {
        $request->validate([
            'name'                   => 'required|string|min:4|max:25|unique:admins,name,' . $receptionist->id,
            'phone'                  => 'required|string|min:11|max:25|unique:admins,phone,' . $receptionist->id,
            'national_id'            => 'required|numeric|digits:14|unique:admins,national_id,' . $receptionist->id,
            'email'                  => 'required|email|unique:admins,email,' . $receptionist->id,
            'password'               => 'nullable|min:3|max:25|confirmed',
            'password_confirmation'  => 'nullable|same:password',
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

            if($receptionist->image != 'default.jpg' && file_exists(public_path('uploads/images/admins/' . $receptionist->image))) {
                unlink(public_path('uploads/images/receptionists/' . $receptionist->image));
            }
            $request_data['image'] = $request->image->hashName();
        } // Upload Images To Uploads Folder

        $receptionist->update($request_data);
        session()->flash('success', 'Receptionist Successfuly Updated');
        return redirect()->route('dashboard.receptionists.index');
    }

    public function destroy(Admin $receptionist)
    {
        if($receptionist->delete()) {
            if($receptionist->image != 'default.jpg' && file_exists(public_path('uploads/images/admins/' . $receptionist->image))) {
                unlink(public_path('uploads/images/admins/' . $receptionist->image));
            }
        }

        session()->flash('success', 'Receptionist Successfuly Deleted');
        return redirect()->route('dashboard.receptionists.index');
    }

    public function banned(Admin $admin)
    {
        $admin->update(['banned' => 1,]);

        session()->flash('success', 'Receptionist Successfuly Bannded');
        return redirect()->route('dashboard.receptionists.index');
    }

    public function unbanned(Admin $admin)
    {
        $admin->update(['banned' => 0]);

        session()->flash('success', 'Receptionist Successfuly Unbannded');
        return redirect()->route('dashboard.receptionists.index');
    }
}
