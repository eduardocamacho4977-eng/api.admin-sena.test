<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Computer;
use Cloudinary\Cloudinary;

class ComputerController extends Controller
{
    /*
    public function index(Request $request){
    $search = trim($request->get('search'));
    $computers = Computer::query()
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('number', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
            });
        })
        ->get();

     return view('computer.index',compact('computers', 'search'));
    }
   
   public function show($id){
      $computer = Computer::findOrFail($id);

      return view('computer.show', compact('computer'));
   }

   public function create(){ 

    return view('computer.create');
}

    public function store(Request $request){ 
     $request->validate([
         'number' => 'required|string|max:255',
         'brand' => 'nullable|string|max:255',
         'urlFoto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
     ]);

     $data = $request->only(['number', 'brand']);

     if ($request->hasFile('urlFoto')) {
         $file = $request->file('urlFoto');
         $nombreArchivo = 'foto_' . time() . '.' . $file->getClientOriginalExtension();
         $file->storeAs('public/images', $nombreArchivo);
         $data['urlFoto'] = $nombreArchivo;
     }

     Computer::create($data);

     return redirect()->route('computer.index')->with('success', 'Computadora creada correctamente.');
}

    public function edit($id){
     $computer = Computer::findOrFail($id);
     return view('computer.edit', compact('computer'));
}

    public function update(Request $request, $id){
     $computer = Computer::findOrFail($id);
     $computer->update($request->all());
     return redirect()->route('computer.index')->with('success','Computadora actualizada.');
}

    public function destroy($id){
     $computer = Computer::findOrFail($id);
     $computer->delete();
     return redirect()->route('computer.index')->with('success','Computadora eliminada.');
}
     */

 public function apiIndex()
 {
     return response()->json(Computer::all());
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
         'number' => 'required|string|max:255',
         'brand' => 'nullable|string|max:255',
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
             'folder' => 'computers',
             'resource_type' => 'image',
         ]
     );

     $computer = Computer::create([
         'number' => $request->number,
         'brand' => $request->brand,
         'imagen_url' => $resultado['secure_url'],
         'imagen_public_id' => $resultado['public_id'],
     ]);

     return response()->json($computer, 201);
 }

 public function apiStore(Request $request)
 {
     return $this->store($request);
 }

 /**
  * Display the specified resource.
  *
  * @param  \App\Models\Computer  $computer
  * @return \Illuminate\Http\Response
  */
 public function apiShow($id)
 {
     return response()->json(Computer::findOrFail($id));
 }

 public function apiUpdate(Request $request, $id)
 {
     $computer = Computer::findOrFail($id);

     $request->validate([
         'number' => 'sometimes|required|string|max:255',
         'brand' => 'nullable|string|max:255',
        
     ]);

     $computer->update($request ->all());

     return response()->json($computer->fresh());
 }

 public function apiDestroy($id)
 {
     $computer = Computer::findOrFail($id);
     $computer->delete();

     return response()->json(['message' => 'Computadora eliminada correctamente.']);
 }

}