<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function allCompanies($rowNumber, $name = null)
    {
        if ($name == null) {
            return Company::simplePaginate($rowNumber);
        }
        return Company::where('name', 'like', "%$name%")->simplePaginate($rowNumber);
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

    public function searchCompanies($name)
    {
        return Company::where('name', 'like', "%$name%")->get();
    }
    public function deleteCompanies($id)
    {
        return Company::where('id', $id)->delete();
    }
}
