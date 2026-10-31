<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $now = now('Asia/Tokyo');

        $todayWorktime = $user->worktimes()
            ->whereDate('clock_in', $now->toDateString())
            ->first();

        if (!$todayWorktime) {
            $attendanceStatus = '勤務外';
        } elseif ($todayWorktime->clock_out) {
            $attendanceStatus = '退勤済';
        } elseif (
            $todayWorktime->breaktimes()
                ->whereNotNull('break_in')
                ->whereNull('break_out')
                ->exists()
        ) {
            $attendanceStatus = '休憩中';
        } else {
            $attendanceStatus = '出勤中';
        }

        $formattedDate = $now->format('Y年m月d日');
        $formattedTime = $now->format('H:i');

        return view('user.attendance-register', [
            'user' => $user,
            'formattedDate' => $formattedDate,
            'formattedTime' => $formattedTime,
            'attendanceStatus' => $attendanceStatus,
        ]);
    }
    public function store(Request $request)
{
    $user = Auth::user();
    $now = now('Asia/Tokyo');

    if ($request->input('action') === 'clock_in') {
        // 出勤
        $user->worktimes()->create([
            'clock_in' => $now,
        ]);

    } elseif ($request->input('action') === 'clock_out') {
        // 退勤
        $todayWorktime = $user->worktimes()
            ->whereNull('clock_out')
            ->latest('clock_in')
            ->first();

        if ($todayWorktime) {
            $todayWorktime->update([
                'clock_out' => $now,
            ]);
        }

    } elseif ($request->input('action') === 'break_in') {
        // 休憩入
        $todayWorktime = $user->worktimes()
            ->whereNull('clock_out')
            ->latest('clock_in')
            ->first();

        if ($todayWorktime) {
            $activeBreak = $todayWorktime->breaktimes()
                ->whereNotNull('break_in')
                ->whereNull('break_out')
                ->exists();

            if (!$activeBreak) {
                $todayWorktime->breaktimes()->create([
                    'break_in' => $now,
                ]);
            }
        }

    } elseif ($request->input('action') === 'break_out') {
        // 休憩戻
        $todayWorktime = $user->worktimes()
            ->whereNull('clock_out')
            ->latest('clock_in')
            ->first();

        if ($todayWorktime) {
            $todayBreaktime = $todayWorktime->breaktimes()
                ->whereNotNull('break_in')
                ->whereNull('break_out')
                ->latest('break_in')
                ->first();

            if ($todayBreaktime) {
                $todayBreaktime->update([
                    'break_out' => $now,
                ]);
            }
        }
    }

    return redirect('/attendance');
}
}