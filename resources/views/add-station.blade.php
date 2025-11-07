@extends('layout')


@section('content')
    <div class="container">
        <h2>Add Station / Table</h2>


        <!-- Form to add station -->
        <form action="{{ route('stations.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Station / Table Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter name" required>
            </div>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>

        <hr>

        <!-- Include the station list Blade -->
    </div>
@endsection
