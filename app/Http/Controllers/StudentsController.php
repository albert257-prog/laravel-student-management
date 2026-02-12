<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentsController extends Controller
{
    /* public function index()
    {
        // $students = Student::orderBy('created_at', 'desc')->paginate(5);
        // OR
        $students = Student::orderByDesc('created_at')->paginate(5);
        return view('students.index', compact('students'));
    }*/
        public function index(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort');

        $students = Student::query()
            // 1. Handle Search with grouping to prevent logic conflicts
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            // 2. Handle Dynamic Sorting
            ->when($sort, function ($query, $sort) {
                switch ($sort) {
                    case 'name_asc':
                        return $query->orderBy('name', 'asc');
                    case 'name_desc':
                        return $query->orderBy('name', 'desc');
                    default:
                        return $query->orderByDesc('created_at');
                }
            }, function ($query) {
                // Default sorting
                return $query->orderByDesc('created_at');
            })
            ->paginate(5)
            ->withQueryString(); // This keeps ?search=...&sort=... in pagination links

        return view('students.index', compact('students'));
    }
    public function create ()
    {
        return view('students.create');
    }
    public function store(Request $request)
    {
        //validate data
        $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|unique:students,email',
            'phone' => 'required|digits:10|unique:students,phone',
        ]);

        // dd('ok');
        // create student
        Student::create($request->all());
        return redirect()->route('students.index')->with('success',' Student addedd successfully');
    }

    public function show(Student $student)
    {
        // Find student by id
        // $student = Student::findOrFail($id);
        // dd($student);
        return view('students.show', compact('student'));
    }

        public function edit(Student $student)
    {
        // Find student by id
        // $student = Student::findOrFail($id);
        // dd($student);
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        //validate data
        $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('students','email')->ignore($student->id)
                ],
            'phone' => [
                'required',
                'digits:10',
                Rule::unique('students','phone')->ignore($student->id)
                ],
        ]);
        //dd('ok');
        $student->update($request->all());
        return redirect()->route('students.index')->with('success',' Student updated successfully');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success',' Student deleted successfully');
    }
}
