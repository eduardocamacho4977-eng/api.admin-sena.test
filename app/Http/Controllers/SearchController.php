<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\Apprentice;
use App\Models\Area;
use App\Models\TrainingCenter;
use App\Models\Computer;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $search = trim($request->input('search', ''));

        $courses = [];
        $teachers = [];
        $apprentices = [];
        $areas = [];
        $trainingCenters = [];
        $computers = [];

        if ($search !== '') {

            $courses = Course::where( 'course_number', 'like', '%' . $search . '%')
                ->get();

            $teachers = Teacher::where('name', 'like', '%' . $search . '%')
                ->get();

            $apprentices = Apprentice::where('name', 'like', '%' . $search . '%')
                ->get();

            $areas = Area::where('name', 'like', '%' . $search . '%')
                ->get();

            $trainingCenters = TrainingCenter::where('name', 'like', '%' . $search . '%')
                ->get();

            $computers = Computer::where( 'number', 'like', '%' . $search . '%')
                ->get();
        }

        return view('vistas.search', compact(
            'search',
            'courses',
            'teachers',
            'apprentices',
            'areas',
            'trainingCenters',
            'computers'
        ));
    }
}