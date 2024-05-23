@extends('pages.base')

@section('content')
@if (session('message'))
    <div class="alert alert-success">{{ session('message') }}</div>
@endif

<div class="d-grid gap-2 d-md-flex justify-content-md-end mb-2">
    <a href="{{ url('employees/create') }}" class="btn btn-primary mcdonalds-button me-md-2" type="button">
        Add New Employee
    </a>
    <a href="employees/pdf" class="btn btn-primary mcdonalds-button me-md-2">Export</a>
</div>


<div class="grid grid-cols-3 gap-6">
    @foreach ($employees as $employee)
        <div class="border p-4 rounded shadow-md gap-2 bg-white">
            {{-- Integrate QR Code generation --}}
            <div style="width: 400px; display: flex; padding: 12px; margin-bottom: 12px">
                {{-- Generate QR code for employee ID and name --}}
                <div>{!! QrCode::size(100)->generate('ID: ' . $employee->id . ' - ' . ' Fullname: ' . $employee->firstName . ' ' . $employee->lastName) !!}</div>
            </div>

            {{-- Employee details --}}
            <div>
                <h2 class="text-xl font-bold">{{ $employee->firstName . ' ' . $employee->lastName }}</h2>
                <p class="text-lg">{{ $employee->position }}</p>
            </div>

            {{-- Link to employee details --}}
            <a href="{{ url('/employees/'.$employee->id) }}" class="text-red-500 hover:underline">
                View Details
            </a>
        </div>
    @endforeach
</div>

<style>
    .mcdonalds-table {
        background-color: #FFD100;
        color: #D10A10;
    }

    .mcdonalds-table th,
    .mcdonalds-table td {
        border-color: #D10A10;
    }

    .mcdonalds-table a {
        color: #D10A10;
    }

    .mcdonalds-table a:hover {
        color: #FF5733;
    }

    .mcdonalds-table .btn-primary {
        background-color: #ffffff;
        border-color: #D10A10;
    }

    .mcdonalds-table .btn-primary:hover {
        background-color: #ff58332a;
        border-color: #ff5833;
    }

    .mcdonalds-button {
        background-color: #FFD100;
        color: #000000;
        border-color: #D10A10;
    }

    .mcdonalds-button:hover {
        background-color: #ff58332a;
        border-color: #000000;
    }

</style>

@endsection
