<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\RoomsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Floor;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomsController extends Controller
{
    public function index(RoomsDataTable $dataTable)
    {
        $count = Room::count();
        return $dataTable->render('dashboard.rooms.index', compact('count'));
    }

    public function create()
    {
        $floors = Floor::select('name', 'id')->get();
        return view('dashboard.rooms.create', compact('floors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|min:5|unique:rooms,name',
            'number'          => 'required|numeric|min:2|unique:rooms,number',
            'size'            => 'required|numeric|min:1',
            'price'           => 'required',
            'floor_id'        => 'required|exists:floors,id',
        ]); // This For Validation The Inputs

        $request['admin_id'] = auth()->user()->id;
        $room = Room::create($request->all());
        session()->flash('success', 'Room Successfuly Created');
        return redirect()->route('dashboard.rooms.index');
    }

    public function show(Room $room)
    {
        return view('dashboard.rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        $floors = Floor::select('name', 'id')->get();
        return view('dashboard.rooms.edit', compact('room', 'floors'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'name'            => 'required|string|min:5|unique:rooms,name,' . $room->id,
            'number'          => 'required|numeric|min:2|unique:rooms,number,' . $room->id,
            'size'            => 'required|numeric|min:1',
            'price'           => 'required',
            'floor_id'        => 'required|exists:floors,id',
        ]); // This For Validation The Inputs

        $room->update($request->all());
        session()->flash('success', 'Room Successfuly Updated');
        return redirect()->route('dashboard.rooms.index');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        session()->flash('success', 'Room Successfuly Deleted');
        return redirect()->route('dashboard.rooms.index');
    }
}
