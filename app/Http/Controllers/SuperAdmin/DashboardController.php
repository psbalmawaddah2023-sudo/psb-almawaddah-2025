<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\Pendaftaran;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    $total = Pendaftaran::count();
    return view('superadmin.dashboard.index', compact('total'));
}

}
