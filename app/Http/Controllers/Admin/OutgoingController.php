<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Outgoing;
use App\Models\Letter;
use App\Models\Sender;
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
            $query = Outgoing::latest()->get();

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    $rolePrefix = [
                        'admin' => 'admin',
                        'guru' => 'guru',
                        'staff' => 'staff',
                        'kepala sekolah' => 'kepala-sekolah'
                    ];

                    $prefix = $rolePrefix[Session('user')['role']] ?? 'default'; // default jika role tidak dikenali

                    return '
    
                        <a class="btn btn-success btn-xs" href="' . route('letter.show_outgoing', ['id' => $item->id]) . ' ">
                            <i class="fa fa-search-plus"></i> &nbsp; Detail
                        </a>
                        <a class="btn btn-primary btn-xs" href="' . route('letter.edit_outgoing', $item->id) . '">
                            <i class="fas fa-edit"></i> &nbsp; Ubah
                        </a>
                        <form action="' . route('letter.destroy_outgoing', $item->id) . '" method="POST" onsubmit="return confirm(' . "'Anda akan menghapus item ini dari situs anda?'" . ')">
                            ' . method_field('delete') . csrf_field() . '
                            <button class="btn btn-danger btn-xs">
                                <i class="far fa-trash-alt"></i> &nbsp; Hapus
                            </button>
                        </form>
                    ';
                })
                ->editColumn('post_status', function ($item) {
                    return $item->post_status == 'Published' ? '<div class="badge bg-green-soft text-green">' . $item->post_status . '</div>' : '<div class="badge bg-gray-200 text-dark">' . $item->post_status . '</div>';
                })
                ->addIndexColumn()
                ->removeColumn('id')
                ->rawColumns(['action', 'post_status'])
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
            ->route('surat-keluar')
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
            ->route('surat-keluar')
            ->with('success', 'Sukses! 1 Data Berhasil Diubah');
    }
    public function download_letter($id)
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
        $item->update(['status' => '2']);

        return redirect()->back()
            ->with('success', 'Sukses! 1 Data Berhasil Diubah');
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
            ->route('surat-keluar')
            ->with('success', 'Sukses! 1 Data Berhasil Dihapus');
    }

    public function arsip()
    {
        if (request()->ajax()) {
            $query = Letter::with(['department', 'sender'])->where('status', '!=', 'diproses')->latest()->get();

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    $rolePrefix = [
                        'admin' => 'admin',
                        'guru' => 'guru',
                        'staff' => 'staff',
                        'kepala sekolah' => 'kepala-sekolah'
                    ];

                    $prefix = $rolePrefix[Session('user')['role']] ?? 'default'; // default jika role tidak dikenali

                    return '
                       

<a class="btn btn-success btn-xs" href="' . url($prefix . '/letter/surat', $item->id) . ' ">
                            <i class="fa fa-search-plus"></i> &nbsp; Detail
                        </a>
                        <a class="btn btn-primary btn-xs" href="' . route('letter.edit', $item->id) . '">
                            <i class="fas fa-edit"></i> &nbsp; Ubah
                        </a>
                        <form action="' . route('letter.destroy', $item->id) . '" method="POST" onsubmit="return confirm(' . "'Anda akan menghapus item ini dari situs anda?'" . ')">
                            ' . method_field('delete') . csrf_field() . '
                            <button class="btn btn-danger btn-xs">
                                <i class="far fa-trash-alt"></i> &nbsp; Hapus
                            </button>
                        </form>
                    ';
                })
                ->editColumn('post_status', function ($item) {
                    return $item->post_status == 'Published' ? '<div class="badge bg-green-soft text-green">' . $item->post_status . '</div>' : '<div class="badge bg-gray-200 text-dark">' . $item->post_status . '</div>';
                })
                ->addIndexColumn()
                ->removeColumn('id')
                ->rawColumns(['action', 'post_status'])
                ->make();
        }

        return view('pages.admin.letter.arsip');
    }
}
