<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Area;
use App\Models\TrainingCenter;
use Cloudinary\Cloudinary;

class TeacherController extends Controller
{
/*
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
*/
 public function apiIndex()
 {
     return response()->json(Teacher::with(['area', 'trainingCenter'])->get());
 }

 /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
 public function store(Request $request)
 {
     $request->validate([
         'name' => 'required|string|max:255',
         'email' => 'nullable|email|max:255',
         'area_id' => 'nullable|exists:areas,id',
         'training_center_id' => 'nullable|exists:training_centers,id',
         'imagen' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
     ]);

     $file = $request->file('imagen');

     $cloudinary = new Cloudinary([
         'cloud' => [
             'cloud_name' => config('services.cloudinary.cloud_name'),
             'api_key' => config('services.cloudinary.api_key'),
             'api_secret' => config('services.cloudinary.api_secret'),
         ],
         'url' => ['secure' => true],
     ]);

     $resultado = $cloudinary->uploadApi()->upload(
         $file->getRealPath(),
         [
             'folder' => 'teachers',
             'resource_type' => 'image',
         ]
     );

     $teacher = Teacher::create([
         'name' => $request->name,
         'email' => $request->email,
         'area_id' => $request->area_id,
         'training_center_id' => $request->training_center_id,
         'imagen_url' => $resultado['secure_url'],
         'imagen_public_id' => $resultado['public_id'],
     ]);

     return response()->json($teacher->load(['area', 'trainingCenter']), 201);
 }

 public function apiStore(Request $request)
 {
     return $this->store($request);
 }

 /**
  * Display the specified resource.
  *
  * @param  \App\Models\Teacher  $teacher
  * @return \Illuminate\Http\Response
  */
 public function apiShow($id)
 {
     return response()->json(Teacher::with(['area', 'trainingCenter'])->findOrFail($id));
 }

 public function apiUpdate(Request $request, $id)
 {
     $teacher = Teacher::findOrFail($id);

     $request->validate([
         'name' => 'sometimes|required|string|max:255',
         'email' => 'nullable|email|max:255',
         'area_id' => 'nullable|exists:areas,id',
         'training_center_id' => 'nullable|exists:training_centers,id',
         
     ]);

     $teacher->update($request->all());

     return response()->json($teacher->fresh()->load(['area', 'trainingCenter']));
 }

 public function apiDestroy($id)
 {
     $teacher = Teacher::findOrFail($id);
     $teacher->delete();

     return response()->json(['message' => 'Profesor eliminado correctamente.']);
 }

}