<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash as FacadesHash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

final class AuthController extends Controller
{
    public function registration()
    {
        return view('auth.registration');
    }

    public function registration_post(Request $request)
    {
        $messages = [
            'email.unique' => 'El correo ya está registrado. Intenta con otro.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'password_confirmation.required_with' => 'Debes confirmar la contraseña.',
            'foto_de_perfil.image' => 'El archivo debe ser una imagen válida.',
            'foto_de_perfil.mimes' => 'Formatos permitidos: jpeg, png, jpg, svg.',
            'foto_de_perfil.max' => 'La imagen no debe pesar más de 2MB.',
        ];

        request()->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email|max:100',
            'password' => 'required|min:6|max:50|different:current_password',
            'password_confirmation' => 'required_with:password|same:password|min:6|max:50',
            'is_role' => 'required|in:0,1,2',
            'edad' => 'required|integer|min:0|max:120',
            'genero' => 'required|in:masculino,femenino,otro',
            'tipo_sangre' => 'nullable|string|max:5',
            'alergias' => 'nullable|string|max:255',
            'curp' => 'required|string|size:18|unique:users,curp',
            'apellido_p' => 'required|string|max:30',
            'apellido_m' => 'required|string|max:30',
            'phone' => 'required|digits:10',
            'mobile' => 'required|digits:10|different:phone',
            'foto_de_perfil' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048'
        ], $messages);

        $user = new User();
        $user->name = trim($request->name);
        $user->email = trim($request->email);
        $user->password = FacadesHash::make($request->password);
        $user->is_role = trim($request->is_role);
        $user->apellido_p = trim($request->apellido_p);
        $user->apellido_m = trim($request->apellido_m);
        $user->phone = trim($request->phone);
        $user->mobile = trim($request->mobile);
        $user->edad = $request->edad;
        $user->genero = $request->genero;
        $user->tipo_sangre = $request->tipo_sangre;
        $user->alergias = $request->alergias;
        $user->curp = strtoupper($request->curp);
        $user->remember_token = Str::random(50);

        if ($request->hasFile('foto_de_perfil')) {
            $extension = $request->file('foto_de_perfil')->getClientOriginalExtension();
            $fileName = 'avatar_new_' . time() . '_' . uniqid() . '.' . $extension;
            $pathAvatar = $request->file('foto_de_perfil')->storeAs('avatars', $fileName, 'public');
            $user->foto_de_perfil = $pathAvatar;
        }

        $user->save();

        if ($request->is_role == 2) {
            $user->assignRole('admin');
        } elseif ($request->is_role == 1) {
            $user->assignRole('cocina');
        } else {
            $user->assignRole('mesero');
        }

        return redirect()->back()->with('success', 'Usuario registrado correctamente.');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function login_post(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'El usuario no está registrado en el sistema.');
        }

        if (!FacadesHash::check($request->password, $user->password)) {
            return redirect()->back()->with('error', 'La contraseña ingresada es incorrecta.');
        }

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ], true)) {
            if ($user->is_role == '2') {
                return redirect()->route('admin.dashboard');
            } else if ($user->is_role == '1') {
                return redirect()->route('cocina.dashboard');
            } else if ($user->is_role == '0') {
                return redirect()->route('mesero.dashboard');
            } else {
                return redirect()->back()->with('error', 'Credenciales inválidas.');
            }
        }

        return redirect()->back()->with('error', 'Error al iniciar sesión.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
