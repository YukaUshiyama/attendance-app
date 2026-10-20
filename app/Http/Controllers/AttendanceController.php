<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

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
}
