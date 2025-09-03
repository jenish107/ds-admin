<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function allDepartment($companyId)
    {
        return Department::with('company')->get();
    }
    public function showDepartment($companyId)
    {
        return view('department.department', ['companyId' => $companyId]);
    }
    public function showDepartmentForm($companyId)
    {
        return view('department.form', ['companyId' => $companyId]);
    }
    public function showUpdateDepartmentForm($id)
    {
        $department = Department::find($id);
        return view('department.form', compact('department'));
    }

    public function updateDepartment(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);

        Department::where('id',  $request->input('id'))->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);
        return redirect()->route('showAllDepartment');
    }

    public function createDepartment(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);

        Department::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            // 'company_id'=>
        ]);
        return redirect()->route('showAllDepartment');
    }

    public function searchDepartment($name)
    {
        return Department::where('name', 'like', "%$name%")->get();
    }
    public function deleteDepartment($id)
    {
        return Department::where('id', $id)->delete();
    }
}
