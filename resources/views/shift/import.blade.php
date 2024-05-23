@extends('pages.base')

@section('content')
@if (session('message'))
    <div class="alert alert-success">{{session('message')}}</div>
@endif
<form action="{{ url('shifts/import-csv') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="csv_file" class="form-label">Upload CSV File</label>
        <input type="file" class="form-control" id="csv_file" name="csv_file" required>
    </div>
    <button type="submit" class="btn btn-primary mcdonalds-button">Import CSV</button>

</form>
<style>
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
