<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Year;
use Illuminate\Http\Request;

class YearController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'year_name' => 'required|string|max:255',
        ]);

        // Create a new year
        $year = new Year();
        $year->year_name = $request->input('year_name');
        $year->save();

        // Redirect back with a success message
        return redirect()->back()->with('year_create', 'New year added successfully!');
    }

    public function destroy($id)
    {
        $year = Year::find($id);
        if ($year) {
            $year->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
}
