<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;

class AreaController extends Controller
{
   /* public function index(Request $request){
      $search = trim($request->get('search'));
      $areas = Area::query()
          ->when($search, function ($query, $search) {
              $query->where('name', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
          })
          ->get();

     return view('area.index', compact('areas', 'search'));
    }
   
   public function show($id){
      $area = Area::findOrFail($id);

      return view('area.show', compact('area'));
   }
   
   public function create(){

    return view('area.create');
}

  public function store(Request $request){
    $request->validate([
        'name' => 'required|string|max:255',
        'urlFoto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $data = $request->only(['name']);

    if ($request->hasFile('urlFoto')) {
        $file = $request->file('urlFoto');
        $nombreArchivo = 'foto_' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/images', $nombreArchivo);
        $data['urlFoto'] = $nombreArchivo;
    }

    $area = Area::create($data);

    return redirect()->route('area.index')->with('success', 'Área creada correctamente.');
}

  public function edit($id){
    $area = Area::findOrFail($id);
    return view('area.edit', compact('area'));
  }

  public function update(Request $request, $id){
    $area = Area::findOrFail($id);
    $area->update($request->all());
    return redirect()->route('area.index')->with('success', 'Área actualizada.');
  }

  public function destroy($id){
    $area = Area::findOrFail($id);
    $area->delete();
    return redirect()->route('area.index')->with('success', 'Área eliminada.');
  }*/

  public function apiIndex()
  {
      $areas = Area::all();

      return response()->json ($areas);
  }


  public function apiShow($id)
  {
          $area = Area::findOrFail($id);
      return response()->json(Area::findOrFail($id));
  }

  public function apiStore(Request $request)
  {
      $request->validate([
         'name' => 'required|max:255',
          
      ]);

      $area = Area::create($request->all());

      return response()->json($area);
  }
  public function apiUpdate(Request $request, $id)
  {
      $area = Area::findOrFail($id);

      $request->validate([
          'name' => 'sometimes|required|string|max:255|unique:areas,name,' . $area->id,
          
      ]);

      $area->update($request ->all());

      return response()->json($area);
  }

  public function apiDestroy($id)
  {
      $area = Area::findOrFail($id);
      $area->delete();
      return response()->json(['message' => 'Área eliminada correctamente.']);
  }

   
}