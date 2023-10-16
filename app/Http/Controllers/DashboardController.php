<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;

        if ($role === 'admin') {
            return view('dashboard.admin.index')
                ->with([
                    'title' => 'Dashboard',
                    'role' => $role
                ]);
        } elseif ($role === 'kasir') {
            return view('dashboard.kasir.index')
                ->with([
                    'title' => 'Dashboard',
                    'role' => $role
                ]);
        } elseif ($role === 'owner') {
            return view('dashboard.owner.index')
                ->with([
                    'title' => 'Dashboard',
                    'role' => $role
                ]);
        }
    }
}
