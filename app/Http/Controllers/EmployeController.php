<?php

namespace App\Http\Controllers;

use App\Models\Employ;
use Illuminate\Http\Request;

class EmployController extends Controller
{
    public function allEmploy($departmentId, $rowNumber)
    {
        return Employ::with('company')->where('company_id', $departmentId)->simplePaginate($rowNumber);
    }
    public function showEmploy($departmentId)
    {
        return view('employ.employ', ['departmentId' => $departmentId]);
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
            'company_id' => $request->input('parentId')
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
