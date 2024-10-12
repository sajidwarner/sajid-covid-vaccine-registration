<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\User;
use App\Models\VaccineCenter;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{

    public function index(){
        $data['title'] = 'Registration';
        $data['vaccineCenters'] = VaccineCenter::get();
        return view('registration', $data);
  }


  public function store(Request $request)
  {
    $request->validate([
        'name' => 'required|min:4|max:100',
        'email' => 'required|email|max:191',
        'nid' => 'required|unique:users|min:4|max:20',
        'vaccine_center_id' => 'required|exists:vaccine_centers,id',
    ], [
        'nid.required' => 'The National ID (NID) field is required.',
        'nid.unique' => 'The provided National ID (NID) is already taken.',
        'vaccine_center_id.required' => 'The selected vaccine center field is required.',
        'vaccine_center_id.exists' => 'The selected vaccine center is invalid.',
    ]);


      $user = User::create($request->only('name', 'email', 'nid'));

        Registration::create([
          'user_id' => $user->id,
          'vaccine_center_id' => $request->vaccine_center_id,
      ]);

      return back()->with('success', 'You have successfully registered for the vaccine.');
  }


  public function search(){

    $data['title'] = 'Search Schedule';
    return view('search_schedule', $data);

  }


}
