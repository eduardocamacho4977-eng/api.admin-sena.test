<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('vistas.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $request->session()->put('selected_role', Auth::user()->role ?? User::ROLE_APPRENTICE);

            return redirect()->intended(route('administracion'));
        }

        return back()->withErrors([
            'email' => 'El correo o la contraseña son incorrectos.',
        ])->onlyInput('email');
    }

    // Muestra el formulario de registro
    public function showRegister()
    {
        return view('vistas.register');
    }

    // Procesa el registro de nuevos usuarios
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'nullable|in:aprendiz,instructor,aspirante',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? User::ROLE_APPRENTICE,
        ]);

        Auth::login($user);
        $request->session()->put('selected_role', $user->role ?? User::ROLE_APPRENTICE);

        return redirect()->route('administracion');
    }

    public function switchRole(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $rol = $request->input('role');
        $rolesPermitidos = [
            User::ROLE_ADMINISTRATOR,
            User::ROLE_INSTRUCTOR,
            User::ROLE_APPLICANT,
            User::ROLE_APPRENTICE,
        ];

        if (!in_array($rol, $rolesPermitidos, true)) {
            abort(400, 'Rol no válido.');
        }

        $request->session()->put('selected_role', $rol);

        return redirect()->back();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}