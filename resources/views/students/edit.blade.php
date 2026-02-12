@extends('layouts.app')

@section('title', ' Edit Students')
@section('content')

<div class="container mt-4">
    <div class="row">
        <div class="col-md-6 offset-3">

            <h2 class="text-white m-0">Edit Student</h2>
            <a href="{{ route('students.index') }}" class="btn btn-outline-warning mt-2">Back</a>

            <div class="card bg-dark text-white mt-4"> 
                <div class="card-body border border-light rounded">
                    <form action="{{ route('students.update', $student->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label text-white fw-bold">Student Name</label>
                            <input type="text" 
                                name="name"
                                class="form-control bg-dark text-white border-secondary @error('name') is-invalid @enderror" 
                                value="{{ old('name', $student->name) }}"
                                style="border-color: #444 !important;" placeholder="John Doe">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-white fw-bold">Email Address</label>
                            <input type="email"
                            name="email" 
                            class="form-control bg-dark text-white border-secondary @error('email') is-invalid @enderror" 
                            value="{{ old('email', $student->email) }}"
                            style="border-color: #444 !important;" 
                            placeholder="wxy@zee.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-white fw-bold">Phone Number</label>
                            <input type="text" 
                            name="phone"
                            class="form-control bg-dark text-white border-secondary @error('phone') is-invalid @enderror" 
                            value="{{ old('phone', $student->phone) }}"
                            style="border-color: #444 !important;" 
                            placeholder="+27263..">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>
                        <button type="submit" 
                            class="btn btn-outline-success text-white px-4" 
                            style="border-width: 2px; border-color: #20c997; transition: all 0.3s ease;">
                            Update
                        </button>

                        <style>
                        /* Add this to your CSS for a cool hover effect */
                            .btn-outline-success:hover {
                            background-color: #20c997 !important;
                            box-shadow: 0 0 15px rgba(32, 201, 151, 0.4);
                            transform: translateY(-1px);
                            }
                        </style>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection