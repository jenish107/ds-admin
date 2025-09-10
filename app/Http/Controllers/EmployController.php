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

        $employees = $query->offset($start)->limit($length)->get();

        $recordsTotal = Employ::where('department_id', $departmentId)->count();

        $data = $employees->map(function ($employ) use ($departmentId) {
            return [
                'id' => $employ->id,
                'name' => $employ->name,
                'email' => $employ->email,
                'action' => '
                    <a href="' . route('showAllFamily', $employ->id) . '">
                        <i class="mdi mdi-account-multiple btn btn-info btn-sm"></i>
                    </a>
                    <a href="' . route('showUpdateEmployForm', [$employ->id, $departmentId]) . '" 
                       class="btn btn-success btn-sm text-white">Edit</a>
                    <button type="button" data-id="' . $employ->id . '" 
                       class="btn btn-danger btn-sm text-white delete_btn">Delete</button>
                ',
            ];
        });

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }
    public function showEmploy($departmentId)
    {
        $obj = Department::where('id', $departmentId)->with('company')->select('id', 'company_id', 'name')->first();
        return view('employ.employ', ['department' => $obj]);
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
