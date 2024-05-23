<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function employee()
    {
        $employee = Employee::orderBy('id')->get();
        return view('employee.index', ['employees' => $employee]);
    }

    public function pdf()
    {
        $employees = Employee::orderBy('id')->get();

        // Generate QR codes for each product
        foreach ($employees as $employee) {
            $employee->qrCode = QrCode::size(100)->generate($employee->id);
        }

        $pdf = Pdf::loadView('employee.employee_pdf', compact('employees'));

        return $pdf->download('list of employees.pdf');
    }

    public function create()
    {
        return view('employee.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'firstName'    => 'required',
            'lastName'     => 'required',
            'position'     => 'required|string',
            'dateOfBirth'  => 'required|date',
            'hireDate'     => 'required|date',
        ]);

        Employee::create([
            'firstName'   => $request->firstName,
            'lastName'    => $request->lastName,
            'position'    => $request->position,
            'dateOfBirth' => $request->dateOfBirth,
            'hireDate'    => $request->hireDate,
        ]);

        return redirect('/employees')->with('message', 'An employee has been added');
    }

    public function edit(Employee $employee)
    {
        return view('employee.edit', compact('employee'));
    }

    public function update(Employee $employee, Request $request)
    {
        $request->validate([
            'firstName'    => 'required',
            'lastName'     => 'required',
            'position'     => 'required|string',
            'dateOfBirth'  => 'required|date',
            'hireDate'     => 'required|date',
        ]);

        $employee->update($request->all());
        return redirect('/employees')->with('message', "$employee->firstName $employee->lastName has been updated successfully. YEHEYYYYYYYYYYYY!!!");
    }

    public function delete(Employee $employee)
    {
        $employee->delete();

        return redirect('/employees')->with('message', "$employee->firstName $employee->lastName has been deleted successfully. BYEEEEEEEEEEEEEEE!!!");

    }


}
