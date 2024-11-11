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
                            <a class="btn btn-sm btn-light text-primary" href="{{ url(auth()->user()->role .'/surat-keluar') }}">
                                <i class="me-1" data-feather="arrow-left"></i>
                                Kembali Ke Semua Surat
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
                                @if ($item->status == '1' || $item->status == '0')
                                <a href="{{ url(auth()->user()->role . '/surat-keluar/' . $item->id . '/approve') }}" class="btn btn-sm btn-success">
                                    <i class="fa fa-check" aria-hidden="true"></i> &nbsp; Teruskan ke Kepala
                                </a>
                                <!-- <a href="{{ url(auth()->user()->role . '/surat-keluar/' . $item->id . '/reject') }}" class="btn btn-sm btn-danger">
                                    <i class="fa fa-times" aria-hidden="true"></i> &nbsp; Tolak
                                </a> -->
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
                                            <th>Tanggal Surat</th>
                                            <td>{{ $item->tanggal_surat }}</td>
                                        </tr>
                                        
                                        <tr>
                                            <th>Tujuan Surat</th>
                                            <td>{{ $item->tujuan }}</td>
                                        </tr>
                                        <tr>
                                            <th>Perihal</th>
                                            <td>{{ $item->perihal }}</td>
                                        </tr>
                                        <tr>
                                            <th id="catatan">Catatan</th>
                                            <td id="catatanText">
                                                @if ($item->catatan == '')
                                                    <i>Belum ada catatan</i>
                                                @else
                                                    {{ $item->catatan }}
                                                @endif
                                            </td>
                                        </tr>
                                        @if (auth()->user()->role == 'kepsek' && $item->status == '2')
                                        <tr>
                                            <th></th>
                                            <td>
                                                <!-- Tombol untuk memilih apakah akan disposisikan atau ditolak -->
                                                <button type="button" class="btn btn-success" id="kirim">Kirim Berkas</button>
                                                <button type="button" class="btn btn-danger" id="tolakBtn">Cek Kembali</button>
                                            </td>
                                        </tr>

                                        <!-- Form Disposisi -->
                                        <tr id="catatanForm" style="display:none;">
                                            <th>Catatan : </th>
                                            <td>
                                                <form action="{{ url(auth()->user()->role . '/surat-keluar/' . $item->id . '/kirim_surat') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <textarea name="catatan" id="catatan" class="form-control" rows="3" placeholder="Masukkan catatan pengiriman"></textarea>
                                                    <button type="submit" class="btn btn-primary mt-2">Kirim</button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Form Tolak -->
                                        <tr id="cekForm" style="display:none;">
                                            <th>Alasan Cek Kembali</th>
                                            <td>
                                                <form action="{{ url(auth()->user()->role . '/surat-keluar/' . $item->id . '/tolak_surat') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <textarea name="catatan" id="catatan" class="form-control" rows="3" placeholder="Masukkan alasan"></textarea>
                                                    <button type="submit" class="btn btn-danger mt-2">Tolak Surat</button>
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
                                ? route('download-surat-keluar-admin', $item->id)
                                : (auth()->user()->role == 'guru'
                                    ? route('download-surat-keluar-guru', $item->id)
                                    : (auth()->user()->role == 'staff'
                                        ? route('download-surat-keluar-staff', $item->id)
                                        : route('download-surat-keluar-kepsek', $item->id))) }}"
                                class="btn btn-sm btn-primary">
                                <i class="fa fa-download" aria-hidden="true"></i> &nbsp; Download Surat
                            </a>
                        </div>

                        <div class="card-body">
                            <div class="mb-3 row">
                                <embed src="{{ Storage::url($item->file_surat) }}" width="500" height="375"
                                    type="application/pdf">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@push('addon-script')
  <script>
    document.getElementById('kirim').addEventListener('click', function() {
        document.getElementById('catatan').style.display = 'none';
        document.getElementById('catatanText').style.display = 'none';
        document.getElementById('catatanForm').style.display = 'table-row';
        document.getElementById('cekForm').style.display = 'none';
    });

    document.getElementById('tolakBtn').addEventListener('click', function() {
        document.getElementById('catatan').style.display = 'none';
        document.getElementById('catatanText').style.display = 'none';
        document.getElementById('cekForm').style.display = 'table-row';
        document.getElementById('catatanForm').style.display = 'none';
    });
    </script>
@endpush