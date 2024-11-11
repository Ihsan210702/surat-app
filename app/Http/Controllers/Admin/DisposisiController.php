<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Incoming;
use Yajra\DataTables\Facades\DataTables;

class DisposisiController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Incoming::where(function ($query) {
                $query->where('status', '3')
                      ->whereIn('status_disposisi', [1, 2,3]);
            })
            ->latest()
            ->get();
            return Datatables::of($query)
                ->addColumn('status', function ($item) {
                    $statusText = '';
                    // Cek status_disposisi untuk menampilkan teks status yang sesuai
                    switch ($item->status_disposisi) {
                        case '1':
                            $statusText = '<span class="badge bg-info"><i class="fa fa-spinner"></i> &nbsp;Menunggu surat dibaca</span>';
                            break;
                        case '2':
                            $statusText = '<span class="badge bg-success"><i class="fas fa-check"></i> &nbsp;Surat telah dibaca</span>';
                            break;
                        case '3':
                            $statusText = '<span class="badge bg-warning"><i class="fas fa-check"></i> &nbsp;Surat telah dibaca dan diarsipkan</span>';
                            break;
                        default:
                            $statusText = '<span class="badge bg-secondary">Status Tidak Diketahui</span>';
                            break;
                    }

                    // Kembalikan teks status
                    return $statusText;
                })
                ->addColumn('action', function ($item) {
                    $buttons = '';
        
                    // Tampilkan tombol "Arsipkan" hanya jika status_disposisi = 2
                    if ($item->status_disposisi == '2') {
                        $buttons .= '
                            <a class="btn btn-secondary btn-xs" href="' . url('admin/surat-masuk/' . $item->id . '/arsipkan') . '">
                                <i class="fa fa-archive"></i> &nbsp; Arsipkan
                            </a>
                        ';
                    } else {
                        $buttons .= '
                            <button class="btn btn-secondary btn-xs" disabled onclick="alert(\'Surat harus dibaca sebelum dapat diarsipkan.\')">
                                <i class="fa fa-archive"></i> &nbsp; Arsipkan
                            </button>
                        ';
                    }

                    return $buttons;
                })
                ->addIndexColumn()
                ->removeColumn('id')
                ->rawColumns(['action','status'])
                ->make();
        }
        
        return view('pages.admin.letter.disposisi.disposisi');
    }

    public function arsipkan(Request $request, $id)
    {
        $incomingMail = Incoming::findOrFail($id);
        
        // Ubah status_disposisi sesuai kebutuhan (misalnya menjadi 2 jika disposisi diteruskan)
        $incomingMail->status_disposisi = 3;

        // Simpan perubahan
        $incomingMail->save();

        return redirect()
            ->to('/' . auth()->user()->role . '/disposisi')
            ->with('success', 'Surat sudah diarsipkan');
    }
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
       //
    }
    

}
