<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employ;
use Illuminate\Http\Request;

class EmployController extends Controller
{
    public function allEmploy($departmentId, $rowNumber, $name = null)
    {
        if ($name == null) {
            return Employ::with('department')->where('department_id', $departmentId)->simplePaginate($rowNumber);
        }
        return Employ::with('department')->where('department_id', $departmentId)->where('name', 'like', "%$name%")->simplePaginate($rowNumber);
    }
    public function showEmploy($departmentId)
    {
        $id = Department::where('id', $departmentId)->select('company_id')->first();
        return view('employ.employ', ['departmentId' => $departmentId, 'companyId' => $id->company_id ?? null]);
    }
    public function showEmployForm($departmentId)
    {
        return view('employ.form', ["departmentId" => $departmentId]);
    }
    public function showUpdateEmployForm($id, $departmentId)
    {
        $employ = Employ::find($id);
        return view('employ.form', compact('employ', 'departmentId'));
    }

    public function updateEmploy(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);

        Employ::where('id',  $request->input('id'))->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);
        return redirect()->route('showAllEmploy', $request->input('parentId'));
    }

    public function createEmploy(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);
        Employ::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'department_id' => $request->input('parentId')
        ]);
        return redirect()->route('showAllEmploy', $request->input('parentId'));
    }

    public function searchEmploy($name)
    {
        return Employ::where('name', 'like', "%$name%")->get();
    }
    public function deleteEmploy($id)
    {
        return Employ::where('id', $id)->delete();
    }
}
