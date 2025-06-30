<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentSuggestController extends Controller
{
    public function suggest(Request $request)
    {
        $term = $request->input('term');

        $results = DB::connection('yuranpibg')
            ->table('families')
            ->select('student_name', 'class_name')
            ->where(function ($query) use ($term) {
                $query->where('student_name', 'like', "%{$term}%");
            })
            ->where(function ($query) {
                $query->where('class_name', 'like', '3 %')
                      ->orWhere('class_name', 'like', '4 %')
                      ->orWhere('class_name', 'like', '5 %')
                      ->orWhere('class_name', 'like', '6 %');
            })
            ->limit(10)
            ->get();

        return response()->json($results);
    }
}