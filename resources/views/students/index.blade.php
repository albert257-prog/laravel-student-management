@extends('layouts.app')

@section('title', 'Students List')

@section('content')

<div class="container mt-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-white mb-2">Students List</h2>
            <a href="{{ route('students.create') }}" class="btn btn-outline-info">Add Student</a>
        </div>

    <div class="col-md-8"> <form action="{{ route('students.index') }}"     method="GET" class="d-flex align-items-center gap-2">
        
        <input type="text" name="search" class="form-control bg-dark text-white border-secondary" 
               placeholder="Search..." value="{{ request('search') }}" style="height: 38px;">

        <select name="sort" class="form-select bg-dark text-white border-secondary" onchange="this.form.submit()" style="height: 38px;">
            <option value="">Sort By</option>
            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest First</option>
        </select>

        <button type="submit" class="btn btn-primary px-3" style="height: 38px;">Search</button>

        @if(request('search'))
            <a href="{{ route('students.index', request()->except('search')) }}" 
               class="btn btn-outline-warning text-nowrap" style="height: 38px;">
               Clear Search
            </a>
        @endif

        @if(request('sort'))
            <a href="{{ route('students.index', request()->except('sort')) }}" 
               class="btn btn-outline-warning text-nowrap" style="height: 38px;">
               Clear Sort
            </a>
        @endif

        @if(request('search') || request('sort'))
            <a href="{{ route('students.index') }}" 
               class="btn btn-secondary text-nowrap" style="height: 38px;">
               Reset All
            </a>
        @endif
    </form>
    </div>
    </div>

    @session('success')
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success! </strong>{{ $value }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endsession

        <div class="mb-3">
            @if(request('search'))
                <span class="badge bg-info text-dark">Search: "{{ request('search') }}"</span>
            @endif
    
            @if(request('sort'))
                <span class="badge bg-secondary">Sorted by: {{ str_replace('_', ' ', request('sort')) }}</span>
            @endif
        </div>

    <table class="table table-bordered table-dark table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>

            @forelse ($students as $student)
                
            <tr>
                <td>{{ $student->id }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->email }}</td>
                <td>{{ $student->phone }}</td>

                <td>
                    <a href="{{ route('students.show', $student->id) }}" class="btn btn-outline-warning">View</a>
                    <a href="{{ route('students.edit', $student->id) }}" class="btn btn-outline-info">Edit</a>
                    {{--<form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger"
                            onclick="return confirm('This process cannot be reversed for {{ $student->name }}.')"
                        >Delete</button>
                    </form>--}}

                {{--<button type="button" class="btn btn-outline-danger delete-btn"
                        data-bs-toggle="modal"
                        data-bs-target="#deleteStudentModal"
                        data-id="{{ $student->id }}"
                    >Delete
                </button>--}}
                <button type="button" class="btn btn-outline-danger delete-btn"
                        data-bs-toggle="modal"
                        data-bs-target="#deleteStudentModal"
                        data-route="{{ route('students.destroy',$student->id) }}"
                    >Delete
                </button>
                </td>
            </tr>
             @empty
                <tr>
                    <td colspan="5" class="text-center">No student found!</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="d-flex justify-content-end mt-4">
        {{ $students->links('vendor.pagination.bootstrap-5-dark') }}
    </div>
</div>

{{-- Delete Modal --}}
<div class="modal fade" id="deleteStudentModal" tableindex="1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header border-0">
                <h5 class="modal-title">Delete Student?</h5>
                <button
                    type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal"
                    aria-label="Close"    
                ></button>
            </div>
            <div class="modal-body">
                <p>You're about to delete this student.</p>
                <p>This action cannot be reversed.</p>
            </div>
            <div class="modal-footer border-0">
                <button
                    type="button"
                    class="btn btn-outline-light"
                    data-bs-dismiss="modal"
                >
                Cancel
                </button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        Delete Student
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
{{--<script>
    document.addEventListener('DOMContentLoaded', function(){
        const deleteButtons = document.querySelectorAll('.delete-btn');
        const deleteForm = document.getElementById('deleteForm');

        deleteButtons.forEach(button =>{
            button.addEventListener('click', function(){
                const studentId = this.dataset.id;
                deleteForm.action = `/students/${studentId}`;
            });
        });
    });
</script>--}}
<script>
    document.addEventListener('DOMContentLoaded', function(){
        const deleteButtons = document.querySelectorAll('.delete-btn');
        const deleteForm = document.getElementById('deleteForm');

        deleteButtons.forEach(button =>{
            button.addEventListener('click', function(){
                const deleteUrl = this.dataset.route;
                deleteForm.action = deleteUrl;
            });
        });
    });
</script>
@endsection