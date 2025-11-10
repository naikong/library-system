<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'fac_name' => 'required|string|max:255',
        ]);

        // Create a new faculty
        $faculty = new Faculty();
        $faculty->fac_name = $request->input('fac_name');
        $faculty->save();

        // Redirect back with a success message
        return redirect()->back()->with('faculty_create', 'New faculty added successfully!');
    }
}
