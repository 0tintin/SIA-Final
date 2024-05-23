<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use App\Models\Shift;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ShiftController extends Controller
{
    public function shift()
    {
        $shift = Shift::orderBy('id')->get();
        return view('shift.index', ['shifts' => $shift]);
    }

    public function pdf()
    {
        $shifts = Shift::orderBy('id')->get();

        // Generate QR codes for each product
        foreach ($shifts as $shift) {
            $shift->qrCode = QrCode::size(100)->generate($shift->id);
        }

        $pdf = Pdf::loadView('shift.shift_pdf', compact('shifts'));

        return $pdf->download('list of shifts.pdf');
    }

    public function create()
    {
        $employees = Employee::list();
        return view('shift.create', ['employees' => $employees]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id'  => 'required',
            'startTime'    => 'required',
            'endTime'      => 'required',
            'date'         => 'required|date',
            'breaksTaken'  => 'required',
        ]);

        Shift::create([
            'employee_id' => $request->employee_id,
            'startTime'   => $request->startTime,
            'endTime'     => $request->endTime,
            'date'        => $request->date,
            'breaksTaken' => $request->breaksTaken,
        ]);

        return redirect('/shifts')->with('message', 'A shift has been added');
    }

    public function edit(Shift $shift)
    {
        return view('shift.edit', compact('shift'));
    }

    public function update(Shift $shift, Request $request)
    {
        $request->validate([
            'startTime'    => 'required',
            'endTime'      => 'required',
            'date'         => 'required|date',
            'breaksTaken'  => 'required',
        ]);

        $shift->update($request->all());
        return redirect('/shifts')->with('message', "Shift ID No. $shift->id has been updated successfully. YEHEYYYYYYYYYYYY!!!");
    }

    public function delete(Shift $shift)
    {
        $shift->delete();

        return redirect('/shifts')->with('message', "Shift ID No. $shift->id has been deleted successfully. BYEEEEEEEEEEEEEEE!!!");

    }

    public function exportCsv()
    {
        $shifts = Shift::all();
        $filename = 'shifts.csv';
        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['ID', 'Employee Full Name', 'Start Time', 'End Time', 'Date', 'Breaks Taken']);

        foreach ($shifts as $shift) {
            fputcsv($handle, [
                $shift->id,
                $shift->employee->firstName . ' ' . $shift->employee->lastName,
                $shift->startTime,
                $shift->endTime,
                $shift->date,
                $shift->breaksTaken
            ]);
        }

        fclose($handle);

        $headers = [
            'Content-Type' => 'text/csv',
        ];

        return response()->download($filename, $filename, $headers)->deleteFileAfterSend(true);
    }

    public function importCsv()
    {
        // Return a view with a form to upload a CSV file
        return view('shift.import');
    }

    public function processImportCsv(Request $request)
    {
        $file = $request->file('csv_file');

        if ($file) {
            $csvData = file_get_contents($file);
            $rows = array_map('str_getcsv', explode("\n", $csvData));
            $header = array_shift($rows);

            foreach ($rows as $row) {
                if (count($row) == count($header)) {
                    $row = array_combine($header, $row);

                    // Assuming Employee model exists and relationships are set up
                    $employee = Employee::firstOrCreate([
                        'firstName' => explode(' ', $row['Employee Full Name'])[0],
                        'lastName' => explode(' ', $row['Employee Full Name'])[1],
                    ]);

                    Shift::create([
                        'employee_id' => $employee->id,
                        'startTime' => $row['Start Time'],
                        'endTime' => $row['End Time'],
                        'date' => $row['Date'],
                        'breaksTaken' => $row['Breaks Taken'],
                    ]);
                }
            }
        }

        return redirect('shifts')->with('message', 'CSV file imported successfully!');
    }


}
