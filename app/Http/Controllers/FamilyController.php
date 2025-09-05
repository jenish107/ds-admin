<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employ;
use App\Models\Family;
use Illuminate\Http\Request;

class FamilyController extends Controller
{
    public function allFamily(Request $request, $employId)
    {
        $length = $request->input('length');
        $start  = $request->input('start');
        $search = $request->input('search.value');

        $query = Family::where('employee_id', $employId)
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });

        $recordsFiltered = $query->count();

        $families = $query->offset($start)->limit($length)->get();

        $recordsTotal = Family::where('employee_id', $employId)->count();

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $families,
        ]);
    }

    public function showFamily($employId)
    {
        $obj = Employ::with('department')->find($employId);

        return view('family.family', ['employId' => $employId, 'companyId' => $obj->department->company_id, 'departmentId' => $obj->department_id]);
    }

    public function showFamilyForm($employId)
    {
        return view('family.form', ["employId" => $employId]);
    }

    public function showUpdateFamilyForm($id, $employId)
    {
        $family = Family::find($id);
        return view('family.form', compact('family', 'employId'));
    }

    public function updateFamily(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);

        Family::where('id',  $request->input('id'))->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);
        return redirect()->route('showAllFamily', $request->input('parentId'));
    }

    public function createFamily(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);

        Family::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'employee_id' => $request->input('parentId')
        ]);

        return redirect()->route('showAllFamily', $request->input('parentId'));
    }

    public function deleteFamily($id)
    {
        return Family::where('id', $id)->delete();
    }
}
