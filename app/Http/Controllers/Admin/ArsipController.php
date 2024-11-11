<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers\Admin;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Models\Incoming; // Model untuk Surat Masuk
use App\Models\Outgoing; // Model untuk Surat Keluar

class ArsipController extends Controller
{
    public function index(Request $request)
    {
        // Cek apakah request merupakan AJAX untuk DataTables
        if ($request->ajax()) {
            // Mendapatkan jenis surat dari request
            $jenisSurat = $request->jenis_surat;
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            // Logika untuk Surat Masuk
            if ($jenisSurat === 'masuk') {
                $query = Incoming::query();

                // Filter berdasarkan rentang tanggal jika disediakan
                if ($startDate && $endDate) {
                    $query->whereBetween('tanggal_surat', [$startDate, $endDate]);
                }

                // Tambahkan filter status disposisi = 3
                $query->where('status_disposisi', 3);
                return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('action', function ($item) {
                        $rolePrefix = [
                            'admin' => 'admin',
                            'guru' => 'guru',
                            'staff' => 'staff',
                            'kepala sekolah' => 'kepala-sekolah'
                        ];
    
                        $prefix = $rolePrefix[auth()->user()->role] ?? 'default'; // default jika role tidak dikenali
    
                        return '<a class="btn btn-success btn-xs" href="' . url($prefix . '/surat-masuk/' . $item->id . '/show') . ' ">
                                <i class="fa fa-search-plus"></i> &nbsp; Detail</a>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            // Logika untuk Surat Keluar
            if ($jenisSurat === 'keluar') {
                $query = Outgoing::query();

                // Filter berdasarkan rentang tanggal jika disediakan
                if ($startDate && $endDate) {
                    $query->whereBetween('tanggal_surat', [$startDate, $endDate]);
                }
                $query->where('status', 4);
                return DataTables::of($query)
                    ->addIndexColumn()   
                    ->addColumn('action', function ($item) {
                        $rolePrefix = [
                            'admin' => 'admin',
                            'guru' => 'guru',
                            'staff' => 'staff',
                            'kepala sekolah' => 'kepala-sekolah'
                        ];
    
                        $prefix = $rolePrefix[auth()->user()->role] ?? 'default'; // default jika role tidak dikenali
    
                        return '<a class="btn btn-success btn-xs" href="' . url($prefix . '/surat-keluar/' . $item->id . '/show') . ' ">
                                <i class="fa fa-search-plus"></i> &nbsp; Detail</a>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
        }

        // Jika bukan AJAX, tampilkan view arsip
        return view('pages.admin.letter.arsip');
    }
}
