<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        // CORRECCIÓN CRUCIAL: Se añade 'foto_de_perfil' al select para que el Accessor funcione
        $users = User::select('id', 'name', 'email', 'apellido_p', 'apellido_m', 'is_role', 'foto_de_perfil')
            ->when($request->search, function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'ilike', "%{$search}%")
                        ->orWhere('apellido_p', 'ilike', "%{$search}%")
                        ->orWhere('apellido_m', 'ilike', "%{$search}%")
                        ->orWhere('email', 'ilike', "%{$search}%");
                });
            })
            ->paginate(8);

        return view('users.index', compact('users'));
    }

    public function registration()
    {
        return view('users.registration');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Opcional: Limpiar disco al eliminar usuario
        if ($user->foto_de_perfil && Storage::disk('public')->exists($user->foto_de_perfil)) {
            Storage::disk('public')->delete($user->foto_de_perfil);
        }

        $user->delete();
        return redirect()->back()->with('success', 'Usuario eliminado correctamente.');
    }

    public function registration_post(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'apellido_p' => 'required|string|max:100',
            'apellido_m' => 'required|string|max:100',
            'edad' => 'required|integer|min:1|max:120',
            'genero' => 'required|string',
            'tipo_sangre' => 'nullable|string|max:5',
            'alergias' => 'nullable|string|max:255',
            'curp' => 'required|string|max:18|unique:users,curp',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|digits:10',
            'mobile' => 'required|digits:10|different:phone',
            'is_role' => 'required|in:0,1,2',
            'password' => 'required|string|min:6|confirmed',
            'foto_de_perfil' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048'
        ]);

        $pathAvatar = null;
        if ($request->hasFile('foto_de_perfil')) {
            $extension = $request->file('foto_de_perfil')->getClientOriginalExtension();
            // Mantenemos la estructura unificada de nombres de archivo
            $fileName = 'avatar_new_' . time() . '_' . uniqid() . '.' . $extension;
            $pathAvatar = $request->file('foto_de_perfil')->storeAs('avatars', $fileName, 'public');
        }

        $user = User::create([
            'name' => trim($request->name),
            'apellido_p' => trim($request->apellido_p),
            'apellido_m' => trim($request->apellido_m),
            'edad' => $request->edad,
            'genero' => $request->genero,
            'tipo_sangre' => $request->tipo_sangre,
            'alergias' => $request->alergias,
            'curp' => strtoupper($request->curp),
            'email' => trim($request->email),
            'phone' => trim($request->phone),
            'mobile' => trim($request->mobile),
            'is_role' => $request->is_role,
            'password' => Hash::make($request->password),
            'active' => true,
            'foto_de_perfil' => $pathAvatar
        ]);

        if ($request->is_role == 2) {
            $user->assignRole('admin');
        } elseif ($request->is_role == 1) {
            $user->assignRole('cocina');
        } else {
            $user->assignRole('mesero');
        }

        return redirect()->route('users')->with('success', 'Usuario registrado correctamente');
    }

    public function updateAvatar(Request $request, $id)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ], [
            'avatar.required' => 'Debes seleccionar una imagen.',
            'avatar.image'    => 'El archivo debe ser una imagen válida.',
            'avatar.mimes'    => 'Formatos permitidos: jpeg, png, jpg, svg.',
            'avatar.max'      => 'La imagen no debe pesar más de 2MB.',
        ]);

        $user = User::findOrFail($id);

        if ($request->hasFile('avatar')) {
            // 1. Eliminar la foto anterior física si existe
            if ($user->foto_de_perfil && Storage::disk('public')->exists($user->foto_de_perfil)) {
                Storage::disk('public')->delete($user->foto_de_perfil);
            }
            // 2. Guardar con la misma nomenclatura exacta
            $extension = $request->file('avatar')->getClientOriginalExtension();
            $fileName = 'avatar_new_' . time() . '_' . uniqid() . '.' . $extension;
            $path = $request->file('avatar')->storeAs('avatars', $fileName, 'public');
            // 3. Persistir cambio
            $user->update([
                'foto_de_perfil' => $path
            ]);

            return redirect()->back()->with('success', 'Fotografía de perfil actualizada con éxito.');
        }

        return redirect()->back()->with('error', 'No se pudo procesar la imagen.');
    }
}
