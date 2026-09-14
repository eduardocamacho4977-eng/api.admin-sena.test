<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apprentice;
use App\Models\Course;
use App\Models\Computer;

class ApprenticeController extends Controller
{

public function index(Request $request){
      $search = trim($request->get('search'));
      $apprentices = Apprentice::query()
          ->with(['course', 'computer'])
          ->when($search, function ($query, $search) {
              $query->where(function ($q) use ($search) {
                  $q->where('id', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('cell_number', 'like', "%{$search}%")
                    ->orWhere('course_id', 'like', "%{$search}%")
                    ->orWhere('computer_id', 'like', "%{$search}%")
                    ->orWhereHas('course', function ($courseQuery) use ($search) {
                        $courseQuery->where('course_number', 'like', "%{$search}%");
                    })
                    ->orWhereHas('computer', function ($computerQuery) use ($search) {
                        $computerQuery->where('number', 'like', "%{$search}%")
                            ->orWhere('brand', 'like', "%{$search}%");
                    });
              });
          })
          ->get();

     return view('apprentice.index', compact('apprentices', 'search'));

    }
   
  public function show($id){
      $apprentice = Apprentice::findOrFail($id);

      return view('apprentice.show', compact('apprentice'));
   }
  
public function create(){
    $courses = Course::all();

    $computers = Computer::all();

    return view('apprentice.create',compact('courses', 'computers' ));
}

public function store(Request $request){
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'course_id' => 'nullable|exists:courses,id',
        'computer_id' => 'nullable|exists:computers,id',
        'urlFoto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $data = $request->only(['name', 'email', 'cell_number', 'course_id', 'computer_id']);

    if ($request->hasFile('urlFoto')) {
        $file = $request->file('urlFoto');
        $nombreArchivo = 'foto_' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/images', $nombreArchivo);
        $data['urlFoto'] = $nombreArchivo;
    }

    Apprentice::create($data);

    return redirect()->route('apprentice.index')->with('success', 'Aprendiz creado correctamente.');
}

 public function edit($id){
        $apprentice = Apprentice::findOrFail($id);
        $courses = Course::all();
        $computers = Computer::all();
        return view('apprentice.edit', compact('apprentice', 'courses', 'computers'));
    }

 public function update(Request $request, $id){
     $apprentice = Apprentice::findOrFail($id);
     $apprentice->update($request->all());
     return redirect()->route('apprentice.index')->with('success','Aprendiz actualizado.');
 }

 public function destroy($id){
     $apprentice = Apprentice::findOrFail($id);
     $apprentice->delete();
     return redirect()->route('apprentice.index')->with('success','Aprendiz eliminado.');
 }

 public function apiIndex()
 {
     return response()->json(Apprentice::with(['course', 'computer'])->get());
 }

 public function apiShow($id)
 {
     return response()->json(Apprentice::with(['course', 'computer'])->findOrFail($id));
 }

 public function apiStore(Request $request)
 {
     $request->validate([
         'name' => 'required|string|max:255',
         'email' => 'nullable|email|max:255',
         'cell_number' => 'nullable|string|max:255',
         'course_id' => 'nullable|exists:courses,id',
         'computer_id' => 'nullable|exists:computers,id',
         'urlFoto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
     ]);

     $data = $request->only(['name', 'email', 'cell_number', 'course_id', 'computer_id']);

     if ($request->hasFile('urlFoto')) {
         $file = $request->file('urlFoto');
         $nombreArchivo = 'foto_' . time() . '.' . $file->getClientOriginalExtension();
         $file->storeAs('public/images', $nombreArchivo);
         $data['urlFoto'] = $nombreArchivo;
     }

     $apprentice = Apprentice::create($data);

     return response()->json($apprentice->load(['course', 'computer']), 201);
 }

 public function apiUpdate(Request $request, $id)
 {
     $apprentice = Apprentice::findOrFail($id);

     $request->validate([
         'name' => 'sometimes|required|string|max:255',
         'email' => 'nullable|email|max:255',
         'cell_number' => 'nullable|string|max:255',
         'course_id' => 'nullable|exists:courses,id',
         'computer_id' => 'nullable|exists:computers,id',
         'urlFoto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
     ]);

     $data = $request->only(['name', 'email', 'cell_number', 'course_id', 'computer_id']);

     if ($request->hasFile('urlFoto')) {
         $file = $request->file('urlFoto');
         $nombreArchivo = 'foto_' . time() . '.' . $file->getClientOriginalExtension();
         $file->storeAs('public/images', $nombreArchivo);
         $data['urlFoto'] = $nombreArchivo;
     }

     $apprentice->update($data);

     return response()->json($apprentice->fresh()->load(['course', 'computer']));
 }

 public function apiDestroy($id)
 {
     $apprentice = Apprentice::findOrFail($id);
     $apprentice->delete();

     return response()->json(['message' => 'Aprendiz eliminado correctamente.']);
 }

}