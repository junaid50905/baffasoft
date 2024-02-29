<?php

namespace Vanguard\Http\Controllers;

use Illuminate\Http\Request;
use Vanguard\Department;

class DepartmentController extends Controller
{
    /**
     * index
     */
    public function index()
    {
        $departments = Department::all();
        return view('user.department.index', compact('departments'));
    }
    /**
     * create
     */
    public function create()
    {
        return view('user.department.create');
    }
    /**
     * store
     */
    public function store(Request $request)
    {
        Department::insert([
            'name' => $request->name
        ]);

        return redirect()->route('department.index');
    }
    /**
     * delete
     */
    public function destroy($id)
    {
        Department::destroy($id);

        return redirect()->route('department.index');
    }
    /**
     * edit
     */
    public function edit($id)
    {
        $department = Department::where('id', $id)->first();
        return view('user.department.edit', compact('department'));
    }
    /**
     * update
     */
    public function update(Request $request, $id)
    {
        Department::where('id', $id)->update([
            'name' => $request->name
        ]);

        return redirect()->route('department.index');
    }
}
