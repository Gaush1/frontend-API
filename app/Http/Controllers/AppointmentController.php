<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Validator;
 use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'patient_id' => 'required|exists:patients,id',
            // 'appointment_date' => 'required|date',
            'appointment_date' => 'required|date|date_format:Y-m-d',
            'appointment_time' => 'required|date_format:H:i',
            // Add any additional validation rules for the appointment booking
        ]);

        // Retrieve the authenticated patient
        $patient = Auth::guard('patient-api')->user();

        // Create a new appointment record
        $appointment = Appointment::create([
            'doctor_id' => $request->doctor_id,
            'patient_id' => $request->patient_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
        
            // Set any additional fields based on your table structure
        ]);

        return response()->json(['message' => 'Appointment created successfully', 'appointment' => $appointment], 201);
    }
    
    public function show($id)
    {
        $appointment = Appointment::findOrFail($id);

        return response()->json(['appointment' => $appointment], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'doctor_id' => 'sometimes|required|exists:doctors,id',
            'patient_id' => 'sometimes|required|exists:patients,id',
            'appointment_date' => 'sometimes|required|date',
            'appointment_time' => 'sometimes|required|date_format:H:i',
        ]);

        $appointment = Appointment::findOrFail($id);

        $appointment->update($request->only(['doctor_id', 'patient_id', 'appointment_date', 'appointment_time']));

        return response()->json(['message' => 'Appointment updated successfully', 'appointment' => $appointment], 200);
    }

    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);

        $appointment->delete();

        return response()->json(['message' => 'Appointment deleted successfully'], 200);
    }
}
