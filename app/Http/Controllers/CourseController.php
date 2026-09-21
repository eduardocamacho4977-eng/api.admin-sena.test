<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Area;
use App\Models\TrainingCenter;

class CourseController extends Controller
{
/*
 public function index(Request $request){
      $search = trim($request->get('search'));
      $courses = Course::query()
          ->with(['area', 'trainingCenter'])
          ->when($search, function ($query, $search) {
              $query->where(function ($q) use ($search) {
                  $q->where('id', 'like', "%{$search}%")
                    ->orWhere('course_number', 'like', "%{$search}%")
                    ->orWhere('day', 'like', "%{$search}%")
                    ->orWhere('area_id', 'like', "%{$search}%")
                    ->orWhere('training_center_id', 'like', "%{$search}%")
                    ->orWhereHas('area', function ($areaQuery) use ($search) {
                        $areaQuery->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('trainingCenter', function ($centerQuery) use ($search) {
                        $centerQuery->where('name', 'like', "%{$search}%");
                    });
              });
          })
          ->get();

     return view('course.index', compact('courses', 'search'));
    }
   
  public function show($id){
      $course = Course::findOrFail($id);

      return view('course.show', compact('course'));
   }
  
public function create(){
    $areas = Area::all();
    $training_centers = TrainingCenter::all();

    return view('course.create',compact('areas','training_centers'));
}

public function store(Request $request){
    $request->validate([
        'course_number' => 'required|string|max:255',
        'day' => 'nullable|string|max:255',
        'area_id' => 'nullable|exists:areas,id',
        'training_center_id' => 'nullable|exists:training_centers,id',
        'urlFoto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $data = $request->only(['course_number', 'day', 'area_id', 'training_center_id']);

    if ($request->hasFile('urlFoto')) {
        $file = $request->file('urlFoto');
        $nombreArchivo = 'foto_' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/images', $nombreArchivo);
        $data['urlFoto'] = $nombreArchivo;
    }

    Course::create($data);

    return redirect()->route('course.index')->with('success', 'Curso creado correctamente.');
}

   
 
 public function edit($id){
     $course = Course::findOrFail($id);
     $areas = Area::all();
     $training_centers = TrainingCenter::all();
     return view('course.edit', compact('course', 'areas', 'training_centers'));
 }

 public function update(Request $request, $id){
     $course = Course::findOrFail($id);
     $course->update($request->all());
     return redirect()->route('course.index')->with('success','Curso actualizado.');
 }

 public function destroy($id){
     $course = Course::findOrFail($id);
     $course->delete();
     return redirect()->route('course.index')->with('success','Curso eliminado.');
 }
     */

 public function apiIndex()
 {
     return response()->json(Course::with(['area', 'trainingCenter'])->get());
 }

 public function apiShow($id)
 {
     return response()->json(Course::with(['area', 'trainingCenter'])->findOrFail($id));
 }

 public function apiStore(Request $request)
 {
     $request->validate([
         'course_number' => 'required|string|max:255|unique:courses,course_number',
         'day' => 'nullable|string|max:255',
         'area_id' => 'nullable|exists:areas,id',
         'training_center_id' => 'nullable|exists:training_centers,id',
      
     ]);

    
     $course = Course::create($request->all());

     return response()->json($course->load(['area', 'trainingCenter']), 201);
 }

 public function apiUpdate(Request $request, $id)
 {
     $course = Course::findOrFail($id);

     $request->validate([
         'course_number' => 'sometimes|required|string|max:255|unique:courses,course_number,' . $course->id,
         'day' => 'nullable|string|max:255',
         'area_id' => 'nullable|exists:areas,id',
         'training_center_id' => 'nullable|exists:training_centers,id',
        
     ]);

     $course->update($request ->all());

     return response()->json($course->fresh()->load(['area', 'trainingCenter']));
 }

 public function apiDestroy($id)
 {
     $course = Course::findOrFail($id);
     $course->delete();

     return response()->json(['message' => 'Curso eliminado correctamente.']);
 }

}
