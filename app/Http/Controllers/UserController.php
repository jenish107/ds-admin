<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = User::with(['country', 'state', 'city'])->find(Auth::id());

        return view('editProfile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = User::find(Auth::id());

        $fields = ['first_name', 'last_name', 'number', 'country', 'state', 'city', 'zipcode'];

        foreach ($fields as $field) {
            if (!empty($request->input($field)) && $request->input($field) != 'Select') {
                if ($field === 'country') {
                    $user->country_id = $request->input($field);
                } elseif ($field === 'state') {
                    $user->state_id = $request->input($field);
                } elseif ($field === 'city') {
                    $user->city_id = $request->input($field);
                } else {
                    $user->$field = $request->input($field);
                }
            }
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName);

            $user->image = $fileName;
        }

        $user->save();

        return redirect()->route('editProfilePage')->with('message', 'Profile updated');
    }

    public function fetchCountry()
    {
        return Country::select('id', 'name')->get();
    }

    public function fetchState($id)
    {
        $country = Country::select('id', 'name')->where('id', $id)->with('states')->get();

        return $country[0]->states;
    }

    public function fetchCity($id)
    {
        $state = State::select('id', 'name')->where('id', $id)->with('cities')->get();

        return $state[0]->cities;
    }
}
