<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $data['getRecord'] = $user;
        if ($user->is_role == 2) {
            return view('admin.dashboard', $data);
        } elseif ($user->is_role == 1) {
            return view('cocina.dashboard', $data);
        } elseif ($user->is_role == 0) {
            return view('mesero.dashboard', $data);
        }
    }
}
