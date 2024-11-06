@extends('layouts.admin')

@section('title')
   Ubah Surat
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
                                Ubah Surat
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mb-3">
                            <button class="btn btn-sm btn-light text-primary" onclick="javascript:window.history.back();">
                                <i class="me-1" data-feather="arrow-left"></i>
                                Kembali Ke Semua Surat
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-fluid px-4">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form action="{{ route('letter.update_incoming', $item->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row gx-4">
                    <div class="col-lg-9">
                        <div class="card mb-4">
                            <div class="card-header">Form Surat</div>
                            <div class="card-body">
                                <div class="mb-3 row">
                                    <label for="no_surat" class="col-sm-3 col-form-label">No. Surat</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('no_surat') is-invalid @enderror" value="{{ $item->no_surat }}" name="no_surat" placeholder="Nomor Surat.." required>
                                    </div>
                                    @error('no_surat')
                                        <div class="invalid-feedback">
                                            {{ $message; }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3 row">
                                    <label for="tanggal_surat" class="col-sm-3 col-form-label">Tanggal Surat</label>
                                    <div class="col-sm-9">
                                        <input type="date" class="form-control @error('tanggal_surat') is-invalid @enderror" value="{{ $item->tanggal_surat }}" name="tanggal_surat" required>
                                    </div>
                                    @error('tanggal_surat')
                                        <div class="invalid-feedback">
                                            {{ $message; }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3 row">
                                    <label for="tanggal_diterima" class="col-sm-3 col-form-label">Tanggal Diterima</label>
                                    <div class="col-sm-9">
                                        <input type="date" class="form-control @error('tanggal_diterima') is-invalid @enderror" value="{{ $item->tanggal_diterima }}" name="tanggal_diterima" required>
                                    </div>
                                    @error('tanggal_diterima')
                                        <div class="invalid-feedback">
                                            {{ $message; }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3 row">
                                    <label for="pengirim" class="col-sm-3 col-form-label">Pengirim</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('pengirim') is-invalid @enderror" value="{{ $item->pengirim }}" name="pengirim" placeholder="Pengirim.." required>
                                    </div>
                                    @error('pengirim')
                                        <div class="invalid-feedback">
                                            {{ $message; }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3 row">
                                    <label for="perihal" class="col-sm-3 col-form-label">Perihal</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('perihal') is-invalid @enderror" value="{{ $item->perihal }}" name="perihal" placeholder="Perihal.." required>
                                    </div>
                                    @error('perihal')
                                        <div class="invalid-feedback">
                                            {{ $message; }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3 row">
                                    <label for="status_surat" class="col-sm-3 col-form-label">Status Surat</label>
                                    <div class="col-sm-9">
                                        <select name="status_surat" class="form-control selectx" required>
                                            <option value="" disabled>Pilih..</option>
                                            <option value="Asli" {{ (isset($item) && $item->status_surat == 'Asli') ? 'selected' : '' }}>Asli</option>
                                            <option value="Tembusan" {{ (isset($item) && $item->status_surat == 'Tembusan') ? 'selected' : '' }}>Tembusan</option>
                                        </select>
                                    </div>
                                    @error('status_surat')
                                        <div class="invalid-feedback">
                                            {{ $message; }}
                                        </div>
                                    @enderror
                                </div>
    
                                <div class="mb-3 row">
                                    <label for="file_surat" class="col-sm-3 col-form-label">File</label>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control @error('file_surat') is-invalid @enderror" value="{{ old('file_surat') }}" name="file_surat">
                                        <div id="file_surat" class="form-text">Ekstensi .pdf | Kosongkan file jika tidak diisi</div>
                                    </div>
                                    @error('file_surat')
                                        <div class="invalid-feedback">
                                            {{ $message; }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3 row">
                                    <label for="" class="col-sm-3 col-form-label"></label>
                                    <div class="col-sm-9">
                                        <button type="submit" class="btn btn-primary">Ubah</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
@endsection

@push('addon-style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.1.1/dist/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
@endpush

@push('addon-script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(".selectx").select2({
            theme: "bootstrap-5"
        });
    </script>
@endpush
