<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    public function index(Request $request)
    {
        $users = User::select('id', 'name', 'email', 'apellido_p', 'apellido_m', 'is_role')
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
        $users = User::findOrFail($id);
        $users->delete();
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
            'password' => 'required|string|min:6|confirmed'
        ]);


        $user = User::create([
            'name' => $request->name,
            'apellido_p' => $request->apellido_p,
            'apellido_m' => $request->apellido_m,
            'edad' => $request->edad,
            'genero' => $request->genero,
            'tipo_sangre' => $request->tipo_sangre,
            'alergias' => $request->alergias,
            'curp' => $request->curp,
            'email' => $request->email,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'is_role' => $request->is_role,
            'password' => Hash::make($request->password),
            'active' => true
        ]);

        // Asignar rol automáticamente si estás usando Spatie
        if ($request->is_role == 2) {
            $user->assignRole('admin');
        } elseif ($request->is_role == 1) {
            $user->assignRole('cocina');
        } else {
            $user->assignRole('mesero');
        }
        return redirect()->route('users.index')->with('success', 'Usuario registrado correctamente');
    }

}
