<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Disposisi;
use App\Models\Incoming;
use Yajra\DataTables\Facades\DataTables;

class DisposisiController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Incoming::join('disposisi_mails', 'disposisi_mails.id_surat_masuk', '=', 'incoming_mails.id')
            ->join('users', 'disposisi_mails.user_id', '=', 'users.id') // Join users // Join tabel disposisi
            ->where('incoming_mails.status', '3') // Filter status di incoming
            ->whereIn('disposisi_mails.status_dibaca', [0,1]) // Filter status_disposisi di disposisi
            ->select('incoming_mails.*', 'disposisi_mails.status_dibaca as status_dibaca'
                        , 'disposisi_mails.user_id as user'
                        , 'users.name as name' // Nama user dari tabel users
                        , 'disposisi_mails.tanggapan as tanggapan') // Ambil kolom yang dibutuhkan
            ->latest()
            ->get();
                
            return Datatables::of($query)
                ->addColumn('status', function ($item) {
                    $statusText = '';
                    // Cek status_disposisi untuk menampilkan teks status yang sesuai
                    switch ($item->status_dibaca) {
                        case '0':
                            $statusText = '<span class="badge bg-info"><i class="fa fa-spinner"></i> &nbsp;Menunggu surat dibaca</span>';
                            break;
                        case '1':
                            $statusText = '<span class="badge bg-success"><i class="fas fa-check"></i> &nbsp;Surat telah dibaca</span>';
                            break;
                        case '2':
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
        
                    $buttons .= '
                            <a class="btn btn-success btn-xs" href="' . url('admin/surat-masuk/' . $item->id . '/show') . '">
                                <i class="fa fa-search-plus"></i> &nbsp; Detail
                            </a>
                        ';
                    

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
            ->to('/' . auth()->user()->role . '/surat-masuk')
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
