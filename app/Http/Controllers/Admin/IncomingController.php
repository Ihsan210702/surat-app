<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Notifications\SuratMasukNotification;
use Illuminate\Http\Request;
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
            'tanggal_surat' => 'required|date',
            'pengirim' => 'required|string|max:255',
            'jenis_surat' => 'required|string|max:255',
            'tanggal_diterima' => 'required|date',
            'perihal' => 'required|string|max:255',
            'status_surat' => 'required|in:Asli,Tembusan',
            'file_surat' => 'required|mimes:pdf|file',
        ]);

        if ($request->file('file_surat')) {
            $validatedData['file_surat'] = $request->file('file_surat')->store('public/surat-masuk');
        }


        $validatedData['status'] = '1';
        $validatedData['tujuan_disposisi'] = '';
        $validatedData['catatan_disposisi'] = '';
        $validatedData['status_disposisi'] = '0';

        $surat = Incoming::create($validatedData);
        // Kirim notifikasi ke semua user
        $users = User::all(); // Atau filter user sesuai kebutuhan
        foreach ($users as $user) {
            $user->notify(new SuratMasukNotification($surat));
        }
        return redirect()
            ->to('/' . auth()->user()->role . '/surat-masuk')
            ->with('success', 'Sukses! 1 Data Berhasil Disimpan');
    }

    public function outgoing_create()
    {
        return view('pages.admin.letter.surat-masuk.create_outgoing', [
            
        ]);
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
                $query = Incoming::whereJsonContains('tujuan_disposisi', (string)$userId)
                 ->where('status_disposisi', '!=', '3')
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
                                if ($userRole == 'guru') {
                                    $statusText = '<span class="badge bg-warning"><i class="fas fa-envelope"></i>&nbsp;Surat Belum Dibaca</span>';
                                } else {
                                    $statusText = '<span class="badge bg-success"><i class="fas fa-check"></i>&nbsp;Selesai Disposisi</span>';
                                }
                                break;
                            case '2':
                                if ($userRole == 'guru') {
                                    $statusText = '<span class="badge bg-success"><i class="fas fa-envelope"></i>&nbsp;Surat Sudah Dibaca</span>';
                                } else {
                                    $statusText = '<span class="badge bg-success"><i class="fas fa-check"></i>&nbsp;Selesai Disposisi</span>';
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

                    // Tampilkan tombol "Ubah" dan "Hapus" hanya jika role pengguna adalah "admin" atau "staff administrasi"
                    if (in_array($item->status, [0, 1,2]) 
                        // && $item->status_disposisi == '-1'
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

                    // Tambahkan tombol "Terima Berkas" khusus untuk role "guru" tanpa menghapus tombol "Detail"
                    if (auth()->user()->role == 'guru' && $item->status_disposisi == '1') {
                        $buttons .= '
                            <a class="btn btn-warning btn-xs" href="' . url($prefix . '/surat-masuk/' . $item->id . '/terima_berkas') . '">
                                <i class="fa fa-check"></i> &nbsp; Terima Berkas
                            </a>';
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
        $item = Incoming::findOrFail($id);
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
            'tanggal_surat' => 'required|date',
            'pengirim' => 'required|string|max:255',
            'jenis_surat' => 'required|string|max:255',
            'tanggal_diterima' => 'required|date',
            'perihal' => 'required|string|max:255',
            'status_surat' => 'required|in:Asli,Tembusan',
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
        $incomingMail->tujuan_disposisi = json_encode($request->input('tujuan_disposisi'));
        $incomingMail->catatan_disposisi = $request->input('catatan_disposisi');
        $incomingMail->status_disposisi = 1 ;

        // Simpan perubahan ke database
        $incomingMail->save();

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

        return redirect()
            ->to('/' . auth()->user()->role . '/surat-masuk')
            ->with('success', 'Disposisi berhasil diteruskan.');
    }

    public function terima_berkas(Request $request, $id)
    {
        $incomingMail = Incoming::findOrFail($id);
        
        // Ubah status_disposisi sesuai kebutuhan (misalnya menjadi 2 jika disposisi diteruskan)
        $incomingMail->status_disposisi = 2;

        // Simpan perubahan
        $incomingMail->save();

        return redirect()
            ->to('/' . auth()->user()->role . '/surat-masuk')
            ->with('success', 'Surat sudah diterima dan dibaca');
    }

  

    
}
