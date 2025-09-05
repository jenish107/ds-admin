<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employ;
use Illuminate\Http\Request;

class EmployController extends Controller
{
    public function allEmploy(Request $request, $departmentId)
    {
        $length = $request->input('length');
        $start  = $request->input('start');
        $search = $request->input('search.value');

        $query = Employ::where('department_id', $departmentId)
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });

        $recordsFiltered = $query->count();

        $families = $query->offset($start)->limit($length)->get();

        $recordsTotal = Employ::where('department_id', $departmentId)->count();

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $families,
        ]);
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

    public function deleteEmploy($id)
    {
        return Employ::where('id', $id)->delete();
    }
}
