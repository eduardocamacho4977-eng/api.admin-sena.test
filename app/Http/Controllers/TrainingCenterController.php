<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrainingCenter;

class TrainingCenterController extends Controller
{

   public function index(Request $request){
      $search = trim($request->get('search'));
      $training_centers = TrainingCenter::query()
          ->when($search, function ($query, $search) {
              $query->where(function ($q) use ($search) {
                  $q->where('id', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
              });
          })
          ->get();

     return view('training_center.index', compact('training_centers', 'search'));
    }
   
   public function show($id){
      $training_center = TrainingCenter::findOrFail($id);

      return view('training_center.show', compact('training_center'));
   }


  public function create(){

    return view('training_center.create');
}

   public function store(Request $request){
    $request->validate([
        'name' => 'required|string|max:255',
        'location' => 'nullable|string|max:255',
        'urlFoto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $data = $request->only(['name', 'location']);

    if ($request->hasFile('urlFoto')) {
        $file = $request->file('urlFoto');
        $nombreArchivo = 'foto_' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/images', $nombreArchivo);
        $data['urlFoto'] = $nombreArchivo;
    }

    TrainingCenter::create($data);

    return redirect()->route('training_center.index')->with('success', 'Centro de formación creado correctamente.');
}

   public function edit($id){
   $training_center = TrainingCenter::findOrFail($id);
   return view('training_center.edit', compact('training_center'));
}

   public function update(Request $request, $id){
   $training_center = TrainingCenter::findOrFail($id);
   $training_center->update($request->all());
   return redirect()->route('training_center.index')->with('success','Centro actualizado.');
}

   public function destroy($id){
   $training_center = TrainingCenter::findOrFail($id);
   $training_center->delete();
   return redirect()->route('training_center.index')->with('success','Centro eliminado.');
}

 public function apiIndex()
 {
     return response()->json(TrainingCenter::all());
 }

 public function apiShow($id)
 {
     return response()->json(TrainingCenter::findOrFail($id));
 }

 public function apiStore(Request $request)
 {
     $request->validate([
         'name' => 'required|string|max:255',
         'location' => 'nullable|string|max:255',
         'urlFoto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
     ]);

     $data = $request->only(['name', 'location']);

     if ($request->hasFile('urlFoto')) {
         $file = $request->file('urlFoto');
         $nombreArchivo = 'foto_' . time() . '.' . $file->getClientOriginalExtension();
         $file->storeAs('public/images', $nombreArchivo);
         $data['urlFoto'] = $nombreArchivo;
     }

     $trainingCenter = TrainingCenter::create($data);

     return response()->json($trainingCenter, 201);
 }

 public function apiUpdate(Request $request, $id)
 {
     $trainingCenter = TrainingCenter::findOrFail($id);

     $request->validate([
         'name' => 'sometimes|required|string|max:255',
         'location' => 'nullable|string|max:255',
         'urlFoto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
     ]);

     $data = $request->only(['name', 'location']);

     if ($request->hasFile('urlFoto')) {
         $file = $request->file('urlFoto');
         $nombreArchivo = 'foto_' . time() . '.' . $file->getClientOriginalExtension();
         $file->storeAs('public/images', $nombreArchivo);
         $data['urlFoto'] = $nombreArchivo;
     }

     $trainingCenter->update($data);

     return response()->json($trainingCenter->fresh());
 }

 public function apiDestroy($id)
 {
     $trainingCenter = TrainingCenter::findOrFail($id);
     $trainingCenter->delete();

     return response()->json(['message' => 'Centro de formación eliminado correctamente.']);
 }

}