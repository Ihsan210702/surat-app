@extends('layouts.admin')

@section('title')
    Detail Surat
@endsection

@section('container')
    <main>
        <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
            <div class="container-fluid px-4">
                <div class="page-header-content">
                    <div class="row align-items-center justify-content-between pt-3">
                        <div class="col-auto mb-3">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="file-text"></i></div>
                                Detail Surat
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mb-3">
                            <a class="btn btn-sm btn-light text-primary" href="{{ url(auth()->user()->role.'/surat-masuk') }}">
                                <i class="me-1" data-feather="arrow-left"></i>
                                Kembali ke Semua Surat
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-fluid px-4">
            <div class="row gx-4">
                <div class="col-lg-7">
                    <div class="card mb-4">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <div>Detail Surat
                            </div>
                            <div class="d-flex gap-2">
                            @if (auth()->user()->role == 'admin')
                                @if ($item->status == '1' || $item->status_disposisi == '-1')
                                    <a href="{{ url(auth()->user()->role . '/surat-masuk/' . $item->id . '/approve') }}" class="btn btn-sm btn-success">
                                        <i class="fa fa-check" aria-hidden="true"></i> &nbsp; Teruskan ke Kepala
                                    </a>
                                    <!-- <a href="{{ url(auth()->user()->role . '/surat-masuk/' . $item->id . '/reject') }}" class="btn btn-sm btn-danger">
                                        <i class="fa fa-times" aria-hidden="true"></i> &nbsp; Tolak
                                    </a> -->
                                <!--  -->
                                @endif
                            @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 row">
                                <table class="table">
                                    <tbody>
                                    
                                        <tr>
                                            <th>Nomor Surat</th>
                                            <td>{{ $item->no_surat }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pengirim Surat</th>
                                            <td>{{ $item->pengirim }}</td>
                                        </tr>
                                        <tr>
                                            <th>Perihal</th>
                                            <td>{{ $item->perihal }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Surat</th>
                                            <td>{{ $item->tanggal_surat }}</td>
                                        </tr>
                                        <tr>
                                            <th>Isi Singkat</th>
                                            <td>{{ $item->isi_singkat }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Diterima</th>
                                            <td>{{ $item->tanggal_diterima }}</td>
                                        </tr>
                                        <tr>
                                            <th>Lampiran</th>
                                            <td>{{ $item->lampiran }}</td>
                                        </tr>
                                        <tr>
                                            <th>Sifat Surat</th>
                                            <td>{{ $item->sifat_surat }}</td>
                                        </tr>
                                        <tr>
                                        <tr>
                                            <th id="disposisi">Disposisi</th>
                                            <td id="disposisiText">
                                                @if ($item->disposisi->isEmpty())
                                                    <i>Belum ada tujuan disposisi</i>
                                                @else
                                                    {{-- Tampilkan nama pengguna dari disposisi --}}
                                                    {{ implode(', ', $item->disposisi->map(fn($d) => $d->user->name)->toArray()) }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th id="catatan">Catatan</th>
                                            <td id="catatanText">
                                                @if ($item->catatan_disposisi == '')
                                                    <i>Belum ada catatan disposisi</i>
                                                @else
                                                    {{ $item->catatan_disposisi }}
                                                @endif
                                            </td>
                                        </tr>
                                        @if (auth()->user()->role == 'kepsek' && $item->status == '2' && $item->status_disposisi == '0')
                                        <tr>
                                            <th></th>
                                            <td>
                                                <!-- Tombol untuk memilih apakah akan disposisikan atau ditolak -->
                                                <button type="button" class="btn btn-success" id="disposisiBtn">Disposisikan</button>
                                                <button type="button" class="btn btn-danger" id="tolakBtn">Tolak</button>
                                            </td>
                                        </tr>

                                        <!-- Form Disposisi -->
                                        <tr id="disposisiForm" style="display:none;">
                                            <th>Disposisikan ke </th>
                                            <td>
                                                <form action="{{ url(auth()->user()->role . '/surat-masuk/' . $item->id . '/disposisikan') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <select name="tujuan_disposisi[]" id="guru" class="form-select" multiple aria-label="Multiple select example">
                                                        @foreach($guru as $guru)
                                                            <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="mt-3">
                                                        <label for="catatan_disposisi">Catatan:</label>
                                                        <textarea name="catatan_disposisi" id="catatan_disposisi" class="form-control" rows="3" placeholder="Masukkan catatan disposisi"></textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary mt-2">Disposisikan</button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Form Tolak -->
                                        <tr id="tolakForm" style="display:none;">
                                            <th>Alasan Penolakan</th>
                                            <td>
                                                <form action="{{ url(auth()->user()->role . '/surat-masuk/' . $item->id . '/tolak_disposisi') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <textarea name="catatan_disposisi" id="catatan_tolak" class="form-control" rows="3" placeholder="Masukkan alasan penolakan"></textarea>
                                                    <button type="submit" class="btn btn-danger mt-2">Tolak Surat</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endif
                                        @if (auth()->user()->role == 'admin' && $item->status == '2' && $item->status_disposisi == '1')
                                       <!-- Form di Blade -->
                                        <tr>
                                            <th></th>
                                            <td>
                                                <form action="{{ url(auth()->user()->role . '/surat-masuk/' . $item->id . '/teruskan') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success mt-2">Teruskan Disposisi</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endif

                                        @if (
                                                (auth()->user()->role == 'guru' && $item->status == '3' && $item->status_disposisi == '1' && $item->disposisi->firstWhere('status_dibaca', '0')) ||
                                                (auth()->user()->role == 'guru' && $item->status == '3' && $item->status_disposisi == '3' && $item->disposisi->firstWhere('status_dibaca', '0'))
                                            )
                                        <tr>
                                            <th></th>
                                            <td>
                                                <!-- Tombol untuk memilih apakah akan disposisikan atau ditolak -->
                                                <button type="button" class="btn btn-warning" id="terimaBtn">Terima Berkas</button>
                                            </td>
                                        </tr>
                                        <!-- Form Isi Disposisi -->
                                        <tr id="ini" style="display:none;">
                                            <th>Balas Disposisi</th>
                                            <td>
                                                <form action="{{ url(auth()->user()->role . '/surat-masuk/' . $item->id . '/terima_berkas') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <textarea name="isi_disposisi" id="balas_disposisi" class="form-control" rows="3" placeholder="Masukkan balasan disposisi"></textarea>
                                                    <button type="submit" class="btn btn-success mt-2">Kirim</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card mb-4">
                        <div class="card-header">
                            File Surat -
                            <a href="{{ auth()->user()->role == 'admin'
                                ? route('download-surat-masuk-admin', $item->id)
                                : (auth()->user()->role == 'guru'
                                    ? route('download-surat-masuk-guru', $item->id)
                                    : (auth()->user()->role == 'staff'
                                        ? route('download-surat-masuk-staff', $item->id)
                                        : route('download-surat-masuk-kepsek', $item->id))) }}"
                                class="btn btn-sm btn-primary">
                                <i class="fa fa-download" aria-hidden="true"></i> &nbsp; Download Surat
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 row">
                                <object data="{{ Storage::url($item->file_surat) }}" type="application/pdf" width="100%" height="500">
                                    PDF tidak dapat ditampilkan. <a href="{{ Storage::url($item->file_surat) }}">Unduh PDF</a>.
                                </object>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    

@endsection

@push('addon-style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.1.1/dist/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
@endpush

@push('addon-script')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Delegated Event Listener untuk semua tombol
        document.body.addEventListener('click', function(event) {
            // Cek jika tombol yang diklik adalah Terima Berkas
            if (event.target && event.target.id === 'terimaBtn') {
                document.getElementById('ini').style.display = 'table-row';  // Menampilkan form disposisi
            }
            // Cek jika tombol yang diklik adalah Disposisikan
            if (event.target && event.target.id === 'disposisiBtn') {
                document.getElementById('disposisi').style.display = 'none';
                document.getElementById('disposisiText').style.display = 'none';
                document.getElementById('catatan').style.display = 'none';
                document.getElementById('catatanText').style.display = 'none';
                document.getElementById('disposisiForm').style.display = 'table-row';
                document.getElementById('tolakForm').style.display = 'none';
            }
            // Cek jika tombol yang diklik adalah Tolak
            if (event.target && event.target.id === 'tolakBtn') {
                document.getElementById('disposisi').style.display = 'none';
                document.getElementById('disposisiText').style.display = 'none';
                document.getElementById('catatan').style.display = 'none';
                document.getElementById('catatanText').style.display = 'none';
                document.getElementById('tolakForm').style.display = 'table-row';
                document.getElementById('disposisiForm').style.display = 'none';
            }
        });
    });

    $(document).ready(function() {
    // Inisialisasi Select2 pada elemen dengan class 'form-select'
    $('#guru').select2({
        placeholder: "Pilih Guru", // Placeholder yang muncul sebelum item dipilih
        allowClear: true, // Memungkinkan untuk menghapus pilihan
        width: '70%', // Membuat Select2 mengambil lebar penuh form
        theme: "bootstrap-5"
    
    });
    });    
    </script>
@endpush
