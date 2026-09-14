<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Area;
use App\Models\TrainingCenter;

class TeacherController extends Controller
{

  public function index(Request $request){
      $search = trim($request->get('search'));
      $teachers = Teacher::query()
          ->with(['trainingCenter', 'area'])
          ->when($search, function ($query, $search) {
              $query->where(function ($q) use ($search) {
                  $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%")
                    ->orWhere('training_center_id', 'like', "%{$search}%")
                    ->orWhere('area_id', 'like', "%{$search}%")
                    ->orWhereHas('trainingCenter', function ($centerQuery) use ($search) {
                        $centerQuery->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('area', function ($areaQuery) use ($search) {
                        $areaQuery->where('name', 'like', "%{$search}%");
                    });
              });
          })
          ->get();

    return view('teacher.index', compact('teachers', 'search'));
    }
   
  public function show($id){
      $teacher = Teacher::findOrFail($id);

      return view('teacher.show', compact('teacher'));
   }

public function create(){
    $areas = Area::all();

    $training_centers = TrainingCenter::all();

    return view('teacher.create',compact('areas', 'training_centers'));
}

public function store(Request $request){
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'area_id' => 'nullable|exists:areas,id',
        'training_center_id' => 'nullable|exists:training_centers,id',
        'urlFoto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $data = $request->only(['name', 'email', 'area_id', 'training_center_id']);

    if ($request->hasFile('urlFoto')) {
        $file = $request->file('urlFoto');
        $nombreArchivo = 'foto_' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/images', $nombreArchivo);
        $data['urlFoto'] = $nombreArchivo;
    }

    Teacher::create($data);

    return redirect()->route('teacher.index')->with('success', 'Profesor creado correctamente.');
}

 public function edit($id){
      $teacher = Teacher::findOrFail($id);
      $areas = Area::all();
      $training_centers = TrainingCenter::all();
      return view('teacher.edit', compact('teacher', 'areas', 'training_centers'));
  }
  

 public function update(Request $request, $id){
   $teacher = Teacher::findOrFail($id);
   $teacher->update($request->all());
   return redirect()->route('teacher.index')->with('success','Profesor actualizado.');
 }

 public function destroy($id){
   $teacher = Teacher::findOrFail($id);
   $teacher->delete();
   return redirect()->route('teacher.index')->with('success','Profesor eliminado.');
 }

 public function apiIndex()
 {
     return response()->json(Teacher::with(['area', 'trainingCenter'])->get());
 }

 public function apiShow($id)
 {
     return response()->json(Teacher::with(['area', 'trainingCenter'])->findOrFail($id));
 }

 public function apiStore(Request $request)
 {
     $request->validate([
         'name' => 'required|string|max:255',
         'email' => 'nullable|email|max:255',
         'area_id' => 'nullable|exists:areas,id',
         'training_center_id' => 'nullable|exists:training_centers,id',
         'urlFoto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
     ]);

     $data = $request->only(['name', 'email', 'area_id', 'training_center_id']);

     if ($request->hasFile('urlFoto')) {
         $file = $request->file('urlFoto');
         $nombreArchivo = 'foto_' . time() . '.' . $file->getClientOriginalExtension();
         $file->storeAs('public/images', $nombreArchivo);
         $data['urlFoto'] = $nombreArchivo;
     }

     $teacher = Teacher::create($data);

     return response()->json($teacher->load(['area', 'trainingCenter']), 201);
 }

 public function apiUpdate(Request $request, $id)
 {
     $teacher = Teacher::findOrFail($id);

     $request->validate([
         'name' => 'sometimes|required|string|max:255',
         'email' => 'nullable|email|max:255',
         'area_id' => 'nullable|exists:areas,id',
         'training_center_id' => 'nullable|exists:training_centers,id',
         'urlFoto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
     ]);

     $data = $request->only(['name', 'email', 'area_id', 'training_center_id']);

     if ($request->hasFile('urlFoto')) {
         $file = $request->file('urlFoto');
         $nombreArchivo = 'foto_' . time() . '.' . $file->getClientOriginalExtension();
         $file->storeAs('public/images', $nombreArchivo);
         $data['urlFoto'] = $nombreArchivo;
     }

     $teacher->update($data);

     return response()->json($teacher->fresh()->load(['area', 'trainingCenter']));
 }

 public function apiDestroy($id)
 {
     $teacher = Teacher::findOrFail($id);
     $teacher->delete();

     return response()->json(['message' => 'Profesor eliminado correctamente.']);
 }

}