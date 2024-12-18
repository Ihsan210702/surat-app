<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Notifications\SuratMasukNotification;
use Illuminate\Http\Request;
use App\Models\Disposisi;
use App\Models\Incoming;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class IncomingController extends Controller
{

    public function index()
    {
        //
    }

    public function incoming_create()
    {
        return view('pages.admin.letter.surat-masuk.create_incoming', [
            
        ]);
    }

    public function incoming_store(Request $request)
    {
        $validatedData = $request->validate([
            'no_surat' => 'required',
            'pengirim' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'isi_singkat' => 'required|string',
            'tanggal_diterima' => 'required|date',
            'lampiran'  => 'required|numeric',
            'sifat_surat' => 'required|in:Biasa,Segera,Sangat Segera',
            'file_surat' => 'required|mimes:pdf|file',
        ]);

        if ($request->file('file_surat')) {
            $validatedData['file_surat'] = $request->file('file_surat')->store('public/surat-masuk');
        }

        $validatedData['status'] = '1';
        $validatedData['catatan_disposisi'] = '';
        $validatedData['status_disposisi'] = '0';

        $surat = Incoming::create($validatedData);
        // Kirim notifikasi ke semua user
        $users = User::whereIn('role', ['admin', 'staff'])->get(); // Hanya user dengan role tertentu
        foreach ($users as $user) {
            $user->notify(new SuratMasukNotification($surat));
        }
        return redirect()
            ->to('/' . auth()->user()->role . '/surat-masuk')
            ->with('success', 'Sukses! 1 Data Berhasil Disimpan');
    }

    public function incoming_mail()
    {
        
        // dd(Auth::id()); // Cek data pengguna yang sedang login
        if (request()->ajax()) {
            // Cek role user
            $userRole = auth()->user()->role;
            // Ambil ID pengguna yang sedang login
            $userId = Auth::id();
            
            // Mendapatkan query data
            if ($userRole == 'kepsek') {
                // Filter untuk menampilkan hanya data yang disetujui KTU bagi kepala sekolah dan guru
                $query = Incoming::where(function ($query) {
                    $query->where('status', '2')
                          ->where('status_disposisi', '0');
                })
                ->orWhereIn('status_disposisi', [-1,1, 2])
                ->latest()
                ->get();
            } elseif ($userRole == 'guru') {
                $userId = Auth::id();
                 // Ambil ID pengguna yang sedang login
                $query = Incoming::join('disposisi_mails', 'disposisi_mails.id_surat_masuk', '=', 'incoming_mails.id') // Join tabel disposisi
                ->where('disposisi_mails.user_id', $userId) // Ambil sesuai id_user di tabel disposisi
                ->where('incoming_mails.status', '3') // Filter status di tabel incoming
                ->select('incoming_mails.*', 'disposisi_mails.status_dibaca as status_dibaca') // Pilih kolom yang dibutuhkan
                ->latest()
                ->get();
            } else {
                // Untuk role lain (admin, staff, dll), tampilkan semua data
                $query = Incoming::where('status_disposisi', '!=', '3')->latest()->get();
            }

            return Datatables::of($query)
                ->addColumn('status', function ($item) {
                    $statusText = '';
                    $userRole = auth()->user()->role;
                    // Kombinasi status utama dan status_disposisi
                    if ($item->status == '2') {
                        // Jika status = 2, tambahkan status_disposisi
                        switch ($item->status_disposisi) {
                            case '0':
                                $statusText = '<span class="badge bg-info"><i class="fas fa-spinner"></i> &nbsp;Menunggu Disposisi</span>';
                                break;
                            case '1':
                                $statusText = '<span class="badge bg-warning"><i class="fas fa-spinner"></i> &nbsp;Disposisi diproses KTU</span>';
                                break;
                            case '-1':
                                $statusText = '<span class="badge bg-danger">Ditolak Kepala</span>';
                                break;
                            default:
                                $statusText = '<span class="badge bg-secondary">Status Tidak Diketahui</span>';
                                break;
                        }
                    } elseif ($item->status == '3') {
                        // Jika status = 3, tambahkan status_disposisi
                        switch ($item->status_disposisi) {
                            case '0':
                                $statusText = '<span class="badge bg-info"><i class="fas fa-spinner"></i> &nbsp;Menunggu Disposisi</span>';
                                break;
                            case '1':
                                // Cek apakah user adalah guru
                                if ($userRole == 'guru' && $item->status_dibaca == 0) {
                                    $statusText = '<span class="badge bg-warning"><i class="fas fa-envelope"></i>&nbsp;Surat Belum Dibaca</span>';
                                } elseif ($userRole == 'guru' && $item->status_dibaca == 1) {
                                    $statusText = '<span class="badge bg-success"><i class="fas fa-envelope"></i>&nbsp;Surat Sudah Dibaca</span>';
                                } else {
                                    $statusText = '<span class="badge bg-success"><i class="fas fa-check"></i>&nbsp;Selesai Disposisi</span>';
                                }
                                break;
                            case '3':
                                // Cek apakah user adalah guru
                                if ($userRole == 'guru' && $item->status_dibaca == 0) {
                                    $statusText = '<span class="badge bg-warning"><i class="fas fa-envelope"></i>&nbsp;Surat Belum Dibaca</span>';
                                } else {
                                $statusText = '<span class="badge bg-secondary"><i class="fas fa-archive"></i> &nbsp;Surat telah diarsipkan</span>';
                                }
                                break;
                            default:
                                $statusText = '<span class="badge bg-secondary">Status Tidak Diketahui</span>';
                                break;
                        }
                    } else {
                        // Jika status bukan 2, tampilkan status utama saja
                        switch ($item->status) {
                            case '1':
                                $statusText = '<span class="badge bg-warning"><i class="fas fa-spinner"></i> &nbsp;Menunggu KTU</span>';
                                break;
                            case '0':
                                $statusText = '<span class="badge bg-danger">Ditolak KTU</span>';
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
                        'staff' => 'staff', // Mapping dari "staff administrasi" ke "staff"
                        'kepsek' => 'kepsek',
                    ];

                    // Gunakan mapping $rolePrefix untuk mendapatkan prefix yang benar
                    $prefix = $rolePrefix[auth()->user()->role] ?? 'default'; // 'default' jika role tidak dikenali
                    $buttons = '';
                    // Tampilkan tombol "Detail" untuk semua role
                    $buttons .= '
                        <a class="btn btn-success btn-xs" href="' . url($prefix . '/surat-masuk/' . $item->id . '/show') . '">
                            <i class="fa fa-search-plus"></i> &nbsp; Detail
                        </a>';
                    // Tampilkan tombol "Arsipkan" hanya jika status_disposisi = 2
                    if ($item->status == '3' && auth()->user()->role == 'admin') {
                        $buttons .= '
                            <a class="btn btn-secondary btn-xs" href="' . url('admin/surat-masuk/' . $item->id . '/arsipkan') . '">
                                <i class="fa fa-archive"></i> &nbsp; Arsipkan
                            </a>
                        ';
                    } 
                    // Tampilkan tombol "Ubah" dan "Hapus" hanya jika role pengguna adalah "admin" atau "staff administrasi"
                    // if (in_array($item->status, [0, 1,2]) 
                    //     && (in_array($item->status_disposisi, [0, -1]))
                    if (
                        // Tombol Edit hanya muncul jika kondisi berikut:
                        ($item->status == 0 || ($item->status == 1) || ($item->status == 2 && $item->status_disposisi == -1))
                        && (auth()->user()->role == 'admin' || auth()->user()->role == 'staff')) {
                        $buttons .= '
                            <a class="btn btn-primary btn-xs" href="' . url($prefix . '/surat-masuk/' . $item->id . '/edit') . '">
                                <i class="fas fa-edit"></i> &nbsp; Ubah
                            </a>
                            <form action="' . url($prefix . '/surat-masuk/' . $item->id . '/destroy') . '" method="POST" onsubmit="return confirm(' . "'Anda akan menghapus item ini dari situs anda?'" . ')">
                                ' . method_field('delete') . csrf_field() . '
                                <button class="btn btn-danger btn-xs">
                                    <i class="far fa-trash-alt"></i> &nbsp; Hapus
                                </button>
                            </form>';
                    } 
                    return $buttons;

                })             
                ->addIndexColumn()
                ->removeColumn('id')
                ->rawColumns(['action', 'status'])
                ->make();
        }

        return view('pages.admin.letter.surat-masuk.incoming');
    }
    public function show_incoming($id)
    {
        // dd($id);
        $item = Incoming::with('disposisi')->find($id);
        // Ambil semua pengguna dengan role 'guru'
        $guru = User::where('role', 'guru')->get();
        
        return view('pages.admin.letter.surat-masuk.show', [
            'item' => $item,
            'guru' => $guru
        ]);
    }

    public function edit_incoming($id)
    {
        $item = Incoming::findOrFail($id);

        return view('pages.admin.letter.surat-masuk.edit', [
            'item' => $item,
        ]);
    }
    public function update_incoming(Request $request, $id)
    {
        $validatedData = $request->validate([
            'no_surat' => 'required',
            'pengirim' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'isi_singkat' => 'required|string',
            'tanggal_diterima' => 'required|date',
            'lampiran' => 'required|numeric',
            'sifat_surat' => 'required|in:Biasa,Segera,Sangat Segera',
            'file_surat' => 'mimes:pdf|file',
        ]);

        $item = Incoming::findOrFail($id);

        if ($request->hasFile('file_surat')) {
            // Jika ada file lama, hapus file tersebut
            if ($item->file_surat) {
                // Menghapus file lama yang ada di storage
                Storage::delete($item->file_surat);
            }

            // Simpan file baru
            $validatedData['file_surat'] = $request->file('file_surat')->store('public/surat-masuk');
        }

        $item->update($validatedData);

        return redirect()
            ->to('/' . auth()->user()->role . '/surat-masuk')
            ->with('success', 'Sukses! 1 Data Berhasil Diubah');
    }
    public function download_surat_masuk($id)
    {
        $item = Incoming::findOrFail($id);
        // dd($item->letter_file);
        // dd(Storage::download('storage/' . $item->letter_file));
        return Storage::download($item->file_surat);
    }
    public function approve(Request $request, $id)
    {
        $item = Incoming::findOrFail($id);
        // dd($item);
        $item->update([
            'status' => '2',
            'status_disposisi' => '0',
            'catatan_disposisi' => ''  // Mengosongkan hanya catatan disposisi
        ]);
        // Notifikasi ke kepala sekolah
        $kepalaSekolah = User::where('role', 'kepsek')->first();
        if ($kepalaSekolah) {
            $kepalaSekolah->notify(new SuratMasukNotification($item));
        }
        return redirect()
            ->to('/' . auth()->user()->role . '/surat-masuk')
            ->with('success', 'Sukses! Surat diteruskan ke Kepala');
    }

    public function reject(Request $request, $id)
    {

        $item = Incoming::findOrFail($id);

        // dd($item);
        $item->update(['status' => '0']);

        return redirect()
            ->to('/' . auth()->user()->role . '/surat-masuk')
            ->with('success', 'Sukses! Surat Ditolak!');
    }
    public function destroy_incoming($id)
    {
        $item = Incoming::findorFail($id);

        Storage::delete($item->file_surat);

        $item->delete();

        // dd($item);
        return redirect()
            ->to('/' . auth()->user()->role . '/surat-masuk')
            ->with('success', 'Sukses! 1 Data Berhasil Dihapus');
    }

    public function disposisi(Request $request, $id)
    {
        // Validasi data dari form
        $request->validate([
            'tujuan_disposisi' => 'required|array', // pastikan array untuk multiple select
            'catatan_disposisi' => 'nullable|string|max:255',
        ]);

        // Temukan surat berdasarkan ID
        $incomingMail = Incoming::findOrFail($id);
        // Simpan tujuan disposisi dan catatan
        $incomingMail->catatan_disposisi = $request->input('catatan_disposisi');
        $incomingMail->status_disposisi = 1 ;
        // Simpan perubahan ke database
        $incomingMail->save();
        // Simpan tujuan disposisi di tabel disposisi
        $tujuanDisposisi = $request->input('tujuan_disposisi');

        // Tambahkan entri baru untuk masing-masing tujuan disposisi
        foreach ($tujuanDisposisi as $idUser) {
            Disposisi::firstOrCreate([
                'id_surat_masuk' => $incomingMail->id,
                'user_id' => $idUser,
                'status_dibaca' => '0',
                'tanggapan' =>  ''
            ]);
        }
        // Notifikasi ke admin
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            $admin->notify(new SuratMasukNotification($incomingMail));
        }
        // Redirect dengan pesan sukses
        return redirect()
            ->to('/' . auth()->user()->role . '/surat-masuk')
            ->with('success', 'Surat berhasil didisposisikan.');
}

    public function tolakDisposisi(Request $request, $id)
    {
        // Validasi data dari form
        $request->validate([
            'catatan_disposisi' => 'required|string|max:255',
        ]);

        // Temukan surat berdasarkan ID
        $incomingMail = Incoming::findOrFail($id);
        // Simpan tujuan disposisi dan catatan
        $incomingMail->catatan_disposisi = $request->input('catatan_disposisi');
        $incomingMail->status_disposisi = -1 ;

        // Simpan perubahan ke database
        $incomingMail->save();
        // Kirim notifikasi ke semua user
        $users = User::whereIn('role', ['admin', 'staff'])->get(); // Hanya user dengan role tertentu
        foreach ($users as $user) {
            $user->notify(new SuratMasukNotification($incomingMail));
        }
        // Redirect dengan pesan sukses
        return redirect()
            ->to('/' . auth()->user()->role . '/surat-masuk')
            ->with('success', 'Surat ditolak untuk didisposisikan.');
    }
    public function teruskan_disposisi(Request $request, $id)
    {
        $incomingMail = Incoming::findOrFail($id);
        
        // Ubah status_disposisi sesuai kebutuhan (misalnya menjadi 2 jika disposisi diteruskan)
        $incomingMail->status = 3;

        // Simpan perubahan
        $incomingMail->save();

        // Ambil daftar id_user dari tabel disposisi berdasarkan id surat
        $guruIds = Disposisi::where('id_surat_masuk', $incomingMail->id)->pluck('user_id');

        // Kirim notifikasi ke setiap guru
        foreach ($guruIds as $guruId) {
            $guru = User::find($guruId);
            if ($guru) {
                $guru->notify(new SuratMasukNotification($incomingMail));
            }
        }
        return redirect()
            ->to('/' . auth()->user()->role . '/surat-masuk')
            ->with('success', 'Disposisi berhasil diteruskan.');
    }

    public function terima_berkas(Request $request, $id)
    {
         // Validasi data dari form
         $request->validate([
            'isi_disposisi' => 'required|string|max:255',
        ]);
        // Temukan record di tabel disposisi berdasarkan id_surat_masuk dan user_id
        $disposisi = Disposisi::where('id_surat_masuk', $id)
        ->where('user_id', auth()->id()) // Sesuaikan dengan user yang sedang login
        ->firstOrFail();

        // Simpan tanggapan ke tabel disposisi
        $disposisi->tanggapan = $request->input('isi_disposisi');

        // Ubah status_disposisi jika diperlukan (misalnya, menjadi 2 untuk status "Sudah Diterima")
        $disposisi->status_dibaca = 1;
        // Simpan perubahan
        $disposisi->save();

        return redirect()
            ->to('/' . auth()->user()->role . '/surat-masuk')
            ->with('success', 'Surat sudah diterima dan dibaca');
    }

  

    
}
