<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Pasamos el registro del usuario autenticado a la vista unificada
        return view('admin.dashboard', [
            'getRecord' => Auth::user()
        ]);
    }
}
