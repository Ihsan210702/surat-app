<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Outgoing;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class OutgoingController extends Controller
{

    public function index()
    {
        //
    }

    public function outgoing_mail()
    {
        if (request()->ajax()) {
            // Cek role user
            $userRole = auth()->user()->role;
            // Mendapatkan query data
            if ($userRole == 'kepsek') {
                // Filter untuk menampilkan hanya data yang disetujui KTU bagi kepala sekolah dan guru
                $query = Outgoing::whereIn('status', ['0', '2', '3'])->latest()->get();
            } else {
                // Untuk role lain (admin, staff, dll), tampilkan semua data
                $query = Outgoing::where('status', '!=', '4')->latest()->get();
            }

            return Datatables::of($query)
                ->addColumn('status', function ($item) {
                    $statusText = '';
                    $userRole = auth()->user()->role;
                    // Kombinasi status utama 
                    if ($userRole == 'kepsek') {
                        // Jika status = 2
                        switch ($item->status) {
                            case '0':
                                $statusText = '<span class="badge bg-danger"><i class="fa fa-times"></i> &nbsp;Ditolak Kepala</span>';
                                break;
                            case '2':
                                $statusText = '<span class="badge bg-warning"><i class="fas fa-check"></i> &nbsp;Mohon Cek Berkas</span>';
                                break;
                            case '3':
                                $statusText = '<span class="badge bg-success"><i class="fas fa-paper-plane"></i> &nbsp;Berkas siap dikirim</span>';
                                break;
                            default:
                                $statusText = '<span class="badge bg-secondary">Status Tidak Diketahui</span>';
                                break;
                        }
                    } else {
                        switch ($item->status) {
                            case '1':
                                $statusText = '<span class="badge bg-warning"><i class="fas fa-spinner"></i> &nbsp;Pengecekan KTU</span>';
                                break;
                            case '2':
                                $statusText = '<span class="badge bg-info"><i class="fas fa-spinner"></i> &nbsp;Berkas dicek Pimpinan</span>';
                                break;
                            case '3':
                                $statusText = '<span class="badge bg-success"><i class="fa fa-paper-plane"></i> &nbsp;Berkas siap dikirim</span>';
                                break;
                            case '0':
                                $statusText = '<span class="badge bg-danger"><i class="fa fa-times"></i> &nbsp;Ditolak Kepala</span>';
                                break;
                            default:
                                $statusText = '<span class="badge bg-secondary">Status Tidak Diketahui</span>';
                                break;
                        }
                    }
                    return $statusText;
                })
                ->addColumn('action', function ($item) {
                    $rolePrefix = [
                        'admin' => 'admin',
                        'guru' => 'guru',
                        'staff' => 'staff',
                        'kepsek' => 'kepsek'
                    ];

                   // Gunakan mapping $rolePrefix untuk mendapatkan prefix yang benar
                    $prefix = $rolePrefix[auth()->user()->role] ?? 'default'; // 'default' jika role tidak dikenali

                    // Tampilkan tombol "Detail" untuk semua role
                    $buttons = '
                    <a class="btn btn-success btn-xs" href="' . url($prefix . '/surat-keluar/' . $item->id . '/show') . '">
                        <i class="fa fa-search-plus"></i> &nbsp; Detail
                    </a>';

                    // Tampilkan tombol "Ubah" dan "Hapus" hanya jika role pengguna adalah "admin" atau "staff administrasi"
                    if ($item->status == '0' || $item->status == '1') {
                        if (auth()->user()->role == 'admin' || auth()->user()->role == 'staff') {
                        $buttons .= '
                            <a class="btn btn-primary btn-xs" href="' . url($prefix . '/surat-keluar/' . $item->id . '/edit') . '">
                                <i class="fas fa-edit"></i> &nbsp; Ubah
                            </a>
                            <form action="' . url($prefix . '/surat-keluar/' . $item->id . '/destroy') . '" method="POST" onsubmit="return confirm(' . "'Anda akan menghapus item ini dari situs anda?'" . ')">
                                ' . method_field('delete') . csrf_field() . '
                                <button class="btn btn-danger btn-xs">
                                    <i class="far fa-trash-alt"></i> &nbsp; Hapus
                                </button>
                            </form>';
                        }
                    }
                    // Jika status 3, tambahkan tombol "Arsipkan" hanya untuk admin
                    if ($item->status == '3' && auth()->user()->role == 'admin') {
                        $buttons .= '
                            <a class="btn btn-secondary btn-xs" href="' . url($prefix . '/surat-keluar/' . $item->id . '/arsipkan') . '">
                                <i class="fa fa-archive"></i> &nbsp; Arsipkan
                            </a>';
                    }

                    return $buttons;
                })
                ->editColumn('post_status', function ($item) {
                    return $item->post_status == 'Published' ? '<div class="badge bg-green-soft text-green">' . $item->post_status . '</div>' : '<div class="badge bg-gray-200 text-dark">' . $item->post_status . '</div>';
                })
                ->addIndexColumn()
                ->removeColumn('id')
                ->rawColumns(['action', 'post_status','status'])
                ->make();
        }

        return view('pages.admin.letter.surat-keluar.outgoing');
    }
    public function outgoing_store(Request $request)
    {
        $validatedData = $request->validate([
            'no_surat' => 'required',
            'tanggal_surat' => 'required|date',
            'tujuan' => 'required|string|max:255',
            'jenis_surat' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'file_surat' => 'required|mimes:pdf|file',
        ]);

        if ($request->file('file_surat')) {
            $validatedData['file_surat'] = $request->file('file_surat')->store('public/surat-keluar');
        }

        $validatedData['status'] = '1';

        Outgoing::create($validatedData);

        return redirect()
            ->to('/' . auth()->user()->role . '/surat-keluar')
            ->with('success', 'Sukses! 1 Data Berhasil Disimpan');
    }

    public function outgoing_create()
    {
        return view('pages.admin.letter.surat-keluar.create_outgoing', [
            
        ]);
    }

    public function show_outgoing($id)
    {
        // dd($id);
        $item = Outgoing::findOrFail($id);

        return view('pages.admin.letter.surat-keluar.show', [
            'item' => $item,
        ]);
    }

    public function edit_outgoing($id)
    {
        $item = Outgoing::findOrFail($id);

        return view('pages.admin.letter.surat-keluar.edit', [
            'item' => $item,
        ]);
    }
    public function update_outgoing(Request $request, $id)
    {
        $validatedData = $request->validate([
            'no_surat' => 'required',
            'tanggal_surat' => 'required|date',
            'tujuan' => 'required|string|max:255',
            'jenis_surat' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'file_surat' => 'mimes:pdf|file',
        ]);

        $item = Outgoing::findOrFail($id);

        if ($request->hasFile('file_surat')) {
            // Jika ada file lama, hapus file tersebut
            if ($item->file_surat) {
                // Menghapus file lama yang ada di storage
                Storage::delete($item->file_surat);
            }

            // Simpan file baru
            $validatedData['file_surat'] = $request->file('file_surat')->store('public/surat-keluar');
        }

        $item->update($validatedData);

        return redirect()
            ->to('/' . auth()->user()->role . '/surat-keluar')
            ->with('success', 'Sukses! 1 Data Berhasil Diubah');
    }
    public function download_surat_keluar($id)
    {
        $item = Outgoing::findOrFail($id);
        // dd($item->letter_file);
        // dd(Storage::download('storage/' . $item->letter_file));

        return Storage::download($item->file_surat);
    }
    public function approve(Request $request, $id)
    {

        $item = Outgoing::findOrFail($id);

        // dd($item);
        $item->update([
            'status' => '2',
            'catatan' => ''
        ]);
        // dd($item->fresh());
        return redirect()
            ->to('/' . auth()->user()->role . '/surat-keluar')
            ->with('success', 'Sukses! Surat Keluar diajukan ke Kepala');
    }

    public function reject(Request $request, $id)
    {

        $item = Outgoing::findOrFail($id);

        // dd($item);
        $item->update(['status' => '0']);

        return redirect()->back()
            ->with('success', 'Sukses! 1 Data Berhasil Diubah');
    }
    public function destroy_outgoing($id)
    {
        $item = Outgoing::findorFail($id);

        Storage::delete($item->file_surat);

        $item->delete();

        // dd($item);
        return redirect()
            ->to('/' . auth()->user()->role . '/surat-keluar')
            ->with('success', 'Sukses! 1 Data Berhasil Dihapus');
    }

    public function kirimSurat(Request $request, $id)
    {
        // Validasi data dari form
        $request->validate([
            'catatan' => 'required|string|max:255',
        ]);

        // Temukan surat berdasarkan ID
        $OutgoingMail = Outgoing::findOrFail($id);
        // Simpan tujuan disposisi dan catatan
        $OutgoingMail->catatan = $request->input('catatan');
        $OutgoingMail->status = 3 ;

        // Simpan perubahan ke database
        $OutgoingMail->save();

        // Redirect dengan pesan sukses
        return redirect()
            ->to('/' . auth()->user()->role . '/surat-keluar')
            ->with('success', 'Surat Keluar sudah di ACC');
    }
    public function tolakSurat(Request $request, $id)
    {
        // Validasi data dari form
        $request->validate([
            'catatan' => 'required|string|max:255',
        ]);

        // Temukan surat berdasarkan ID
        $OutgoingMail = Outgoing::findOrFail($id);
        // Simpan tujuan disposisi dan catatan
        $OutgoingMail->catatan = $request->input('catatan');
        $OutgoingMail->status = 0 ;

        // Simpan perubahan ke database
        $OutgoingMail->save();

        // Redirect dengan pesan sukses
        return redirect()
            ->to('/' . auth()->user()->role . '/surat-keluar')
            ->with('success', 'Surat Keluar ditolak');
    }
    public function arsipkan(Request $request, $id)
    {
        $OutgoingMail = Outgoing::findOrFail($id);
        
        // Ubah status_disposisi sesuai kebutuhan (misalnya menjadi 2 jika disposisi diteruskan)
        $OutgoingMail->status = 4;

        // Simpan perubahan
        $OutgoingMail->save();

        return redirect()
            ->to('/' . auth()->user()->role . '/surat-keluar')
            ->with('success', 'Surat Keluar sudah diarsipkan');
    }

}
