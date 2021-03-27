<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\FloorsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Floor;
use Illuminate\Http\Request;

class FloorsController extends Controller
{
    public function index(FloorsDataTable $dataTable)
    {
        $count = Floor::count();
        return $dataTable->render('dashboard.floors.index', compact('count'));
    }

    public function create()
    {
        return view('dashboard.floors.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            // 'name'            => 'required|string|min:5|unique.floors.name',
            'name'            => 'required|string|min:5',
            'number'          => 'required|numeric|min:2',
            // 'number'          => 'required|numeric|min:2|unique.floors.number',
        ]); // This For Validation The Inputs

        $request['admin_id'] = auth()->user()->id;
        Floor::create($request->all());
        session()->flash('success', 'Floor Successfuly Created');
        return redirect()->route('dashboard.floors.index');
    }

    public function show(Floor $floor)
    {
        return view('dashboard.floors.show');
    }

    public function edit(Floor $floor)
    {
        return view('dashboard.floors.edit', compact('floor'));
    }

    public function update(Request $request, Floor $floor)
    {
        $request->validate([
            // 'name'   => 'required|string|min:5|unique.floors.name,' . $floor->id,
            // 'number' => 'required|numeric|min:2|unique.floors.number,' . $floor->id,
            'name'   => 'required|string|min:5',
            'number' => 'required|numeric|min:2',
        ]); // This For Validation The Inputs

        $floor->update($request->all());
        session()->flash('success', 'Floor Successfuly Updated');
        return redirect()->route('dashboard.floors.index');
    }

    public function destroy(Floor $floor)
    {
        $floor->delete();
        session()->flash('success', 'Floor Successfuly Deleted');
        return redirect()->route('dashboard.floors.index');
    }
}
