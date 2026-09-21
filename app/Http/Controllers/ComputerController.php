<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Computer;

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

 public function apiShow($id)
 {
     return response()->json(Computer::findOrFail($id));
 }

 public function apiStore(Request $request)
 {
     $request->validate([
         'number' => 'required|string|max:255',
         'brand' => 'nullable|string|max:255',
        
     ]);

     $computer = Computer::create($request ->all());

     return response()->json($computer, 201);
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