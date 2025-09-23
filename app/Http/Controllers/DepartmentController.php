<?php

namespace App\Http\Controllers;

use App\Models\Company;
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

        $departments = $query->offset($start)->limit($length)->get();

        $recordsTotal = Department::where('company_id', $companyId)->count();

        $data = $departments->map(function ($department) use ($companyId) {
            return [
                'id' => $department->id,
                'name' => $department->name,
                'email' => $department->email,
                'action' => '
                    <a href="' . route('showAllEmploy', $department->id) . '">
                        <i class="mdi mdi-account-multiple btn btn-info btn-sm"></i>
                    </a>
                    <a href="' . route('showDepartmentForm', [$companyId, $department->id]) . '" 
                       class="btn btn-success btn-sm text-white">Edit</a>
                    <button type="button" data-id="' . $department->id . '" 
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
    public function showDepartment($companyId)
    {
        $company = Company::where('id', $companyId)->with('department')->get()->first();
        return view('department.department', ['company' => $company]);
    }
    public function showDepartmentForm($companyId, $id = null)
    {
        if ($id) {
            $department = Department::find($id);
            return view('department.form', compact('department', 'companyId'));
        } else {
            return view('department.form', ["companyId" => $companyId]);
        }
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

    public function deleteDepartment($id)
    {
        return Department::where('id', $id)->delete();
    }
}
