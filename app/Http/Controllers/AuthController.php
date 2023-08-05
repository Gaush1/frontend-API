<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Patient;
 use Auth;
use Validator;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Exception;

class AuthController extends Controller
{
    public function registerDoctor(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:doctors',
            'password' => 'required|string|min:6',
            'c_password'=>'required|same:password',
            'address' => 'required',
            'specialization' => 'required',
       ]);

       try { 
        $doctor = Doctor::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'specialization' => $request->specialization,
        ]);

        $token = $doctor->createToken('doctor-reg-token')->plainTextToken;

        return response()->json(['message' => 'Doctor registered successfully', 'token' => $token, 'doctor' => $doctor], 201);
          } 
    catch (Exception $e)
     {
        return response()->json(['message' => 'Failed to register doctor', 'error' => $e->getMessage()], 500);
     }

    }

    public function loginDoctor(Request $request)
    {
         $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);
          
        $doctor = Doctor::where('email', $request->email)->first();

        if (!$doctor || !Hash::check($request->password, $doctor->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    
        $token = $doctor->createToken('doctor-login-token')->plainTextToken;

         return response()->json([
        'message' => 'Doctor Logged in successfully!',
        'token' => $token,
        'doctor' => $doctor,
          ], 200);

    }

    public function registerPatient(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:patients',
            'password' => 'required|string|min:6',
          //  'confirm'=>'required|same:password',
            'phone' => 'required|string|min:10'
        ]);

        try {  $patient = Patient::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
        ]);

        $token = $patient->createToken('patient-reg-token')->plainTextToken;

        return response()->json(['message' => 'Patient registered successfully!', 'token' => $token, 'patient' => $patient], 201);
    } 
    catch (Exception $e) {
        return response()->json(['message' => 'Failed to register Patient', 'error' => $e->getMessage()], 500);
    }

    }

    public function loginPatient(Request $request)
    {
         $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
           ]);

           $patient = Patient::where('email', $request->email)->first();

           if (!$patient || !Hash::check($request->password, $patient->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $patient->createToken('patient-login-token')->plainTextToken;

        return response()->json([
            'message' => 'Patient Logged in successfully!',
            'token' => $token,
            'patient' => $patient,
        ], 200);
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user instanceof Doctor || is_subclass_of($user, Doctor::class)) {
            // Revoke all tokens for the authenticated doctor
            $user->tokens()->delete();
        } elseif ($user instanceof Patient || is_subclass_of($user, Patient::class)) {
            // Revoke all tokens for the authenticated patient
            $user->tokens()->delete();
        } else {
            // Handle the case if the user is neither a doctor nor a patient
            return response()->json(['message' => 'Invalid user type'], 401);
        }

        return response()->json(['message' => 'Logged out successfully']);
    }
}
