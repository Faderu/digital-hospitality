<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = auth()->user()->schedules;
        return view('doctor.schedules.index', compact('schedules'));
    }

    public function create()
    {
        return view('doctor.schedules.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'day' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'start_time' => 'required|date_format:H:i',
            'duration_minutes' => 'required|integer|min:30',
        ]);

        // Check for overlap
        $overlapping = Schedule::where('doctor_id', auth()->id())
            ->where('day', $validated['day'])
            ->where(function ($query) use ($validated) {
                $start = $validated['start_time'];
                $end = date('H:i', strtotime($start) + $validated['duration_minutes'] * 60);
                $query->whereBetween('start_time', [$start, $end])
                      ->orWhereRaw("ADDTIME(start_time, SEC_TO_TIME(duration_minutes * 60)) BETWEEN ? AND ?", [$start, $end]);
            })
            ->exists();

        if ($overlapping) {
            return back()->withErrors(['start_time' => 'Jadwal tumpang tindih dengan jadwal existing.']);
        }

        auth()->user()->schedules()->create($validated);
        return redirect()->route('schedules.index')->with('success', 'Schedule created successfully');
    }

    public function show(Schedule $schedule)
    {
        if ($schedule->doctor_id !== auth()->id()) abort(403);
        return view('doctor.schedules.show', compact('schedule'));
    }

    public function edit(Schedule $schedule)
    {
        if ($schedule->doctor_id !== auth()->id()) abort(403);
        return view('doctor.schedules.edit', compact('schedule'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        if ($schedule->doctor_id !== auth()->id()) abort(403);

        $validated = $request->validate([
            'day' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'start_time' => 'required|date_format:H:i',
            'duration_minutes' => 'required|integer|min:30',
        ]);

        $overlapping = Schedule::where('doctor_id', auth()->id())
            ->where('id', '!=', $schedule->id)
            ->where('day', $validated['day'])
            ->where(function ($query) use ($validated) {
                $start = $validated['start_time'];
                $end = date('H:i', strtotime($start) + $validated['duration_minutes'] * 60);
                $query->whereBetween('start_time', [$start, $end])
                      ->orWhereRaw("ADDTIME(start_time, SEC_TO_TIME(duration_minutes * 60)) BETWEEN ? AND ?", [$start, $end]);
            })
            ->exists();

        if ($overlapping) {
            return back()->withErrors(['start_time' => 'Jadwal tumpang tindih dengan jadwal existing.']);
        }

        $schedule->update($validated);
        return redirect()->route('schedules.index')->with('success', 'Schedule updated successfully');
    }

    public function destroy(Schedule $schedule)
    {
        if ($schedule->doctor_id !== auth()->id()) abort(403);
        $schedule->delete();
        return redirect()->route('schedules.index')->with('success', 'Schedule deleted successfully');
    }
}