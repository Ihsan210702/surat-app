<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Incoming;
use App\Models\Outgoing;

class DashboardController extends Controller
{
    public function index()
    {
        $masuk = Incoming::get()->count();
        $keluar = Outgoing::get()->count();

        return view('pages.admin.dashboard',[
            'masuk' => $masuk,
            'keluar' => $keluar
        ]);
    }
}
