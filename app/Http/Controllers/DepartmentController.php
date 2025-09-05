<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function allDepartment(Request $request, $companyId)
    {
        $length = $request->input('length');
        $start  = $request->input('start');
        $search = $request->input('search.value');

        $query = Department::where('company_id', $companyId)
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });

        $recordsFiltered = $query->count();

        $families = $query->offset($start)->limit($length)->get();

        $recordsTotal = Department::where('company_id', $companyId)->count();

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $families,
        ]);
    }
    public function showDepartment($companyId)
    {
        return view('department.department', ['companyId' => $companyId]);
    }
    public function showDepartmentForm($companyId)
    {
        return view('department.form', ["companyId" => $companyId]);
    }
    public function showUpdateDepartmentForm($id, $companyId)
    {
        $department = Department::find($id);
        return view('department.form', compact('department', 'companyId'));
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
        return redirect()->route('showAllDepartment', $request->input('parentId'));
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
            'company_id' => $request->input('parentId')
        ]);
        return redirect()->route('showAllDepartment', $request->input('parentId'));
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
