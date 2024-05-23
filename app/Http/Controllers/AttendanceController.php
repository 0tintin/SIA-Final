<?php

namespace App\Http\Controllers;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Shift;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AttendanceController extends Controller
{
    public function attendance()
    {
        $attendance = Attendance::orderBy('id')->get();
        return view('attendance.index', ['attendances' => $attendance]);
    }

    public function pdf()
    {
        $attendances = Shift::orderBy('id')->get();

        // Generate QR codes for each product
        foreach ($attendances as $attendance) {
            $attendance->qrCode = QrCode::size(100)->generate($attendance->id);
        }

        $pdf = Pdf::loadView('attendance.attendance_pdf', compact('attendances'));

        return $pdf->download('list of attendances.pdf');
    }

    public function scan()
    {
        return view('scanner');
    }

    public function create()
    {
        $employees = Employee::list();
        $shifts = Shift::list();

        return view('attendance.create', ['employees' => $employees, 'shifts' => $shifts]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id'      => 'required',
            'shift_id'         => 'required',
            'attendanceStatus' => 'required',
            'attendanceDate'   => 'required|date',
            'notes'            => 'required',
        ]);

        Attendance::create([
            'employee_id'      => $request->employee_id,
            'shift_id'         => $request->shift_id,
            'attendanceStatus' => $request->attendanceStatus,
            'attendanceDate'   => $request->attendanceDate,
            'notes'            => $request->notes,
        ]);

        return redirect('/attendances')->with('message', 'An attendance has been added');
    }

    public function edit(Attendance $attendance)
    {
        return view('attendance.edit', compact('attendance'));
    }

    public function update(Attendance $attendance, Request $request)
    {
        $request->validate([
            // 'employee_id'      => 'required',
            // 'shift_id'         => 'required',
            'attendanceStatus' => 'required',
            'attendanceDate'   => 'required|date',
            'notes'            => 'required',
        ]);

        $attendance->update($request->all());
        return redirect('/attendances')->with('message', "Attendance ID No. $attendance->id has been updated successfully. YEHEYYYYYYYYYYYY!!!");
    }

    public function delete(Attendance $attendance)
    {
        $attendance->delete();

        return redirect('/attendances')->with('message', "Attendance ID No. $attendance->id has been deleted successfully. BYEEEEEEEEEEEEEEE!!!");

    }
}
