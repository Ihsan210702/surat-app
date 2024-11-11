@extends('layouts.admin')

@section('title', 'Arsip Surat')

@section('container')
<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="archive"></i></div>
                            Arsip Surat
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main page content-->
    <div class="container-xl px-4 mt-4">
        <!-- Form Filter -->
        <form method="GET" action="" class="mb-4">
            <div class="row">
                <!-- Tanggal Mulai -->
                <div class="col-md-4">
                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <!-- Tanggal Selesai -->
                <div class="col-md-4">
                    <label for="end_date" class="form-label">Tanggal Selesai</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <!-- Jenis Surat -->
                <div class="col-md-4">
                    <label for="jenis_surat" class="form-label">Jenis Surat</label>
                    <select name="jenis_surat" id="jenis_surat" class="form-select">
                        <option value="">Semua</option>
                        <option value="masuk" {{ request('jenis_surat') == 'masuk' ? 'selected' : '' }}>Surat Masuk</option>
                        <option value="keluar" {{ request('jenis_surat') == 'keluar' ? 'selected' : '' }}>Surat Keluar</option>
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Tampilkan</button>
                <!-- Tombol Reset -->
                <a href="{{ url()->current() }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        <!-- Tabel Arsip Surat -->
        <div class="card card-header-actions mb-4">
            <div class="card-header">
                List Arsip
            </div>
            <div class="card-body">
                {{-- Tabel Surat Masuk --}}
                @if(request('jenis_surat') === 'masuk')
                    <table class="table table-striped table-hover table-sm" id="crudTableMasuk">
                        <thead>
                            <tr>
                                <th width="10">No.</th>
                                <th>No. Surat</th>
                                <th>Tanggal Surat</th>
                                <th>Tanggal Diterima</th>
                                <th>Pengirim</th>
                                <th>Perihal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                @endif

                {{-- Tabel Surat Keluar --}}
                @if(request('jenis_surat') === 'keluar')
                    <table class="table table-striped table-hover table-sm" id="crudTableKeluar">
                        <thead>
                            <tr>
                                <th width="10">No.</th>
                                <th>No. Surat</th>
                                <th>Tanggal Surat</th>
                                <th>Tujuan</th>
                                <th>Perihal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                @endif
                {{-- Tampilkan Pesan jika filter tidak diisi --}}
                @if(request('jenis_surat') === null && request('start_date') === null && request('end_date') === null)
                    <div class="alert alert-warning">
                        <center><strong>Perhatian!</strong> Silakan pilih jenis surat dan rentang tanggal untuk menampilkan data.</center>
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection

@push('addon-script')
    <script>
        // Inisialisasi DataTable untuk Surat Masuk
        var datatableMasuk = $('#crudTableMasuk').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            ajax: {
                url: '',
                data: function (d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                    d.jenis_surat = 'masuk';
                }
            },
            columns: [
                { data: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'no_surat', name: 'no_surat' },
                { data: 'tanggal_surat', name: 'tanggal_surat' },
                { data: 'tanggal_diterima', name: 'tanggal_diterima' },
                { data: 'pengirim', name: 'pengirim' },
                { data: 'perihal', name: 'perihal' },
                { 
                    data: 'action', 
                    name: 'action',
                    orderable: false,
                    searcable: false,
                    width: '15%'
                },
            ]
        });

        // Inisialisasi DataTable untuk Surat Keluar
        var datatableKeluar = $('#crudTableKeluar').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            ajax: {
                url: '',
                data: function (d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                    d.jenis_surat = 'keluar';
                }
            },
            columns: [
                { data: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'no_surat', name: 'no_surat' },
                { data: 'tanggal_surat', name: 'tanggal_surat' },
                { data: 'tujuan', name: 'tujuan' },
                { data: 'perihal', name: 'perihal' },
                { 
                    data: 'action', 
                    name: 'action',
                    orderable: false,
                    searcable: false,
                    width: '15%'
                },
            ]
        });
    </script>
@endpush
