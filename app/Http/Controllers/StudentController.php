<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Inertia\Inertia;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class StudentController extends Controller
{
    /**
     * Helper to generate QR options quickly
     */
    private function getQrOptions($scale = 4)
    {
        return new QROptions([
            'version'      => 5,
            'outputType'   => 'svg',
            'eccLevel'     => 'L',
            'scale'        => $scale,
            'addQuietzone' => true,
            'imageTransparent' => false,
        ]);
    }

    public function index()
    {

        // 1. Prepare the QR Engine
    $qrcode = new QRCode($this->getQrOptions(4));

    // 2. Fetch Students and map them to include the QR code
    $students = Student::latest()->get()->map(function($student) use ($qrcode) {
        return [
            'id'         => $student->id,
            'student_id' => $student->student_id,
            'name'       => $student->name,
            'course'     => $student->course,
            'qr_code'    => $qrcode->render($student->student_id),
        ];
    });

    // 3. Fetch Attendance History with Student details
    $history = Attendance::with('student')
        ->latest()
        ->take(15)
        ->get();

    return Inertia::render('Dashboard', [
        'students' => $students,
        'attendance_history' => Attendance::with('student')->latest()->get()
    ]);
    }

    public function printId(Student $student)
    {
        // Higher scale for printing quality
        $qrcode = new QRCode($this->getQrOptions(20));

        return Inertia::render('PrintID', [
            'student' => [
                'name'       => $student->name,
                'student_id' => $student->student_id,
                'course'     => $student->course,
                'qr_code'    => $qrcode->render($student->student_id),
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|string|max:20|unique:students,student_id',
            'name'       => 'required|string|max:255',
            'course'     => 'required|string',
        ]);

        Student::create($validated);

        return redirect()->back()->with('message', 'Student registered successfully!');
    }

    public function recordAttendance(Request $request)
    {
        // 1. Validate the incoming request
        $request->validate([
            'student_id' => 'required|string'
        ]);

        // 2. Find student by their unique ID string (from QR)
        $student = Student::where('student_id', $request->student_id)->first();

        if (!$student) {
            return response()->json([
                'success' => false, 
                'message' => 'Student ID not recognized.'
            ], 404);
        }

        // 3. Prevent double scans (Optional: e.g., within 5 minutes)
        $lastAttendance = Attendance::where('student_id', $student->id)
            ->where('created_at', '>', now()->subMinutes(5))
            ->first();

        if ($lastAttendance) {
            return response()->json([
                'success' => false,
                'message' => 'Attendance already recorded recently.'
            ], 422);
        }

        // 4. Create the record
        $attendance = Attendance::create([
            'student_id' => $student->id,
            'scanned_at' => now(), // Matches your DB column
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Welcome, ' . $student->name,
            'student' => [
                'name'   => $student->name,
                'course' => $student->course,
                'time'   => $attendance->scanned_at->format('h:i A')
            ]
        ]);
    }
}