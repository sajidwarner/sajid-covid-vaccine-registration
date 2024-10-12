<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\User;
use App\Models\VaccineCenter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        'name' => 'required|min:4|max:100|regex:/^[\p{L} .\'-]+$/u',
        'email' => 'required|email|max:191',
        'nid' => 'required|integer|digits_between:4,20|unique:users,nid',
        'vaccine_center_id' => 'required|exists:vaccine_centers,id',
    ], [
        'nid.required' => 'The National ID (NID) field is required.',
        'nid.unique' => 'The provided National ID (NID) is already taken.',
        'nid.digits_between' => 'National ID (NID) must be between 4 and 20 digits.',
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


  public function searchSchedule(){

    $data['title'] = 'Search Schedule';
    return view('search_schedule', $data);

  }


  public function search(Request $request)
  {

    if (!$request->ajax()) {
        return response()->json([
            'success' => false,
            'message' => 'Only AJAX requests are allowed.'
        ], 403);
    }

      $validator = Validator::make($request->all(), [
          'nid' => 'required|integer|digits_between:4,20',
      ], [
          'nid.required' => 'The National ID (NID) field is required.',
          'nid.digits_between' => 'National ID (NID) must be between 4 and 20 digits.',
      ]);

      if ($validator->fails()) {
          return response()->json([
              'status' => 'error',
              'errors' => $validator->errors(),
          ], 422);
      }

      $nid = $request->input('nid');

      $user = User::where('nid', $nid)
          ->with(['registration:id,user_id,scheduled_date'])
          ->select('id', 'nid')
          ->first();

      if (!$user || !$user->registration) {
          return response()->json([
              'status' => 'Not registered',
              'message' => 'No registration found for the provided NID.',
              'registration_link' => route('registration.index')
          ]);
      }

      $registration = $user->registration;


      if ($registration->scheduled_date === null) {
        return response()->json([
            'status' => 'Not scheduled',
            'message' => 'You are registered but not scheduled yet.'
        ]);
    }


    $scheduledDate = Carbon::parse($registration->scheduled_date);


        if ($scheduledDate->isFuture()) {
            return response()->json([
                'status' => 'Scheduled',
                'scheduled_date' => $scheduledDate->format('l, F j, Y'),
            ]);
        } else {
            return response()->json([
                'status' => 'Vaccinated',
                'message' => 'You have been vaccinated.',
            ]);
        }

  }


}
