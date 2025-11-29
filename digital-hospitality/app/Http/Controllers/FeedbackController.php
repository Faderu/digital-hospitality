<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Appointment;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function create(Appointment $appointment = null)
    {
        if ($appointment && ($appointment->patient_id != auth()->id() || $appointment->status != 'completed')) abort(403);
        return view('patient.feedback.create', compact('appointment'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'appointment_id' => 'nullable|exists:appointments,id',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
        ]);

        if ($validated['appointment_id'] ?? false) {
            $appointment = Appointment::find($validated['appointment_id']);
            if ($appointment->patient_id != auth()->id() || $appointment->status != 'completed') abort(403);
        }

        $validated['patient_id'] = auth()->id();
        Feedback::create($validated);
        return redirect()->route('dashboard')->with('success', 'Feedback submitted successfully');
    }

    public function index()
    {
        if (!auth()->user()->isAdmin()) abort(403);
        $feedbacks = Feedback::with('patient', 'appointment')->get();
        return view('admin.feedback.index', compact('feedbacks'));
    }
}