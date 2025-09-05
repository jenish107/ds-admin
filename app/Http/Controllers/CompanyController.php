<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function allCompanies(Request $request)
    {
        $length = $request->input('length');
        $start  = $request->input('start');
        $search = $request->input('search.value');

        $query = Company::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        });

        $recordsFiltered = $query->count();

        $families = $query->offset($start)->limit($length)->get();

        $recordsTotal = Company::count();

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $families,
        ]);
    }
    public function showCompanies()
    {
        return view('companies.companies');
    }
    public function showCompaniesForm()
    {
        return view('companies.form');
    }
    public function showUpdateCompaniesForm($id)
    {
        $companies = Company::find($id);
        return view('companies.form', compact('companies'));
    }

    public function updateCompanies(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);

        Company::where('id',  $request->input('id'))->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);
        return redirect()->route('showAllCompanies');
    }

    public function createCompanies(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);

        Company::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);
        return redirect()->route('showAllCompanies');
    }

    public function deleteCompanies($id)
    {
        return Company::where('id', $id)->delete();
    }
}
