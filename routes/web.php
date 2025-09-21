<?php

use App\Models\Student;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // // Get the student model where email is john@example.com
    // $student = Student::where('email', 'john@example.com')->first();

    // // Update the 'status' column with the value 'active'
    // $student->status = 'active';

    // // Save the model
    // $student->save();
    // dd($student);

    // Dump the result

    // 1. Using raw SQL queries
    // $users = DB::select('select * from users');
    // dd($users);

    // 2. Using Query Builder
    // $users = DB::table('users')->select(['name', 'email'])->whereNotNull('email')->orderBy('name')->get();
    // dd($users);

    // 3. Using Eloquent ORM
    // $students = Student::all();
    // dd($students);
    // foreach ($students as $student) {
    //     echo $student->name . ' - ' . $student->email . '<br>';
    // }

    // $student = new Student();
    // $student->name = 'John Doe';
    // $student->email = 'jad4@student.le.ac.uk';
    // $student->save();

    // $students = Student::select(['name', 'email'])->whereNotNull('email')->get();
    // dd($students);

    $student = Student::all()->where('email', 'jad4@student.le.ac.uk')->first();
    // update only if student found and status column exists and status is not active
    if ($student && $student->status !== 'active') {
        $student->status = 'active';
        $student->save();
    }
    dd($student);
});
