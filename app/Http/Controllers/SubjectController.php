<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'subject_name' => 'required|string|max:255',
        ]);

        // Create a new subject
        $subject = new Subject();
        $subject->subject_name = $request->input('subject_name');
        $subject->save();

        // Redirect back with a success message
        return redirect()->back()->with('book_create', 'Subject added successfully!');
    }
}
