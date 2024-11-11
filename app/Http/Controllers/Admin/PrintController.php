<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Incoming;
use App\Models\Outgoing;

class PrintController extends Controller
{
    public function index()
    {
        $item = Incoming::latest()->get();

        return view('pages.admin.letter.surat-masuk.print-incoming',[
            'item' => $item
        ]);
    }

    public function outgoing()
    {
        $item = Outgoing::latest()->get();

        return view('pages.admin.letter.surat-keluar.print-outgoing',[
            'item' => $item
        ]);
    }
}
