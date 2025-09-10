<?php

namespace App\Http\Controllers;

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
                $query->where('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });

        $recordsFiltered = $query->count();

        $families = $query->offset($start)->limit($length)->get();


        $recordsTotal = Family::where('employee_id', $employId)->count();

        $data = $families->map(function ($family) use ($employId) {
            return [
                'id'         => $family->id,
                'first_name' => $family->fullNameParts['first_name'],
                'last_name'  => $family->fullNameParts['last_name'],
                'email'      => $family->email,
                'action'     => '
                    <a href="' . route('showUpdateFamilyForm', [$family->id, $employId]) . '" 
                       class="btn btn-success btn-sm text-white">Edit</a>
                    <button type="button" data-id="' . $family->id . '" 
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

    public function showFamily($employId)
    {
        $employ = Employ::with('department.company')->select('name', 'id', "department_id")->find($employId);

        return view('family.family', ['employ' => $employ]);
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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
        ]);

        Family::where('id',  $request->input('id'))->update([
            'full_name' => [
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
            ],
            'email' => $request->input('email'),
        ]);
        return redirect()->route('showAllFamily', $request->input('parentId'));
    }

    public function createFamily(Request $request)
    {
        $validate = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
        ]);

        Family::create([
            'full_name' => [
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
            ],
            'email' => $request->input('email'),
            'employee_id' => $request->input('parentId')
        ]);

        return redirect()->route('showAllFamily', $request->input('parentId'));
    }

    public function deleteFamily($id)
    {
        return Family::where('id', $id)->delete();
    }

    public function test()
    {
        return Family::get();
    }
}
