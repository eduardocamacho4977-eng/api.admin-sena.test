<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrainingCenter;
use Cloudinary\Cloudinary;

class TrainingCenterController extends Controller
{
/*
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
*/
 public function apiIndex()
 {
    
     return response()->json(TrainingCenter::all());
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
         'location' => 'nullable|string|max:255',
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
             'folder' => 'training_centers',
             'resource_type' => 'image',
         ]
     );

     $trainingCenter = TrainingCenter::create([
         'name' => $request->name,
         'location' => $request->location,
         'imagen_url' => $resultado['secure_url'],
         'imagen_public_id' => $resultado['public_id'],
     ]);

     return response()->json($trainingCenter, 201);
 }

 public function apiStore(Request $request)
 {
     return $this->store($request);
 }

 /**
  * Display the specified resource.
  *
  * @param  \App\Models\TrainingCenter  $trainingCenter
  * @return \Illuminate\Http\Response
  */
 public function apiShow($id)
 {
     return response()->json(TrainingCenter::findOrFail($id));
 }

 public function apiUpdate(Request $request, $id)
 {
     $trainingCenter = TrainingCenter::findOrFail($id);

     $request->validate([
         'name' => 'sometimes|required|string|max:255',
         'location' => 'nullable|string|max:255',
        
     ]);

     $trainingCenter->update($request->all ());

     return response()->json($trainingCenter->fresh());
 }

 public function apiDestroy($id)
 {
     $trainingCenter = TrainingCenter::findOrFail($id);
     $trainingCenter->delete();

     return response()->json(['message' => 'Centro de formación eliminado correctamente.']);
 }

}