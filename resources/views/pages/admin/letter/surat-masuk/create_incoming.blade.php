@extends('layouts.admin')

@section('title')
   Tambah Surat Masuk
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
                                Tambah Surat Masuk
                            </h1>
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
            <form action="{{ url(auth()->user()->role .'/surat-masuk/store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row gx-4">
                    <div class="col-lg-9">
                        <div class="card mb-4">
                            <div class="card-header">Form Surat</div>
                            <div class="card-body">
                                
                                <div class="mb-3 row">
                                    <label for="no_surat" class="col-sm-3 col-form-label">No. Surat</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('no_surat') is-invalid @enderror" value="{{ old('no_surat') }}" name="no_surat" placeholder="Nomor Surat.." required>
                                    </div>
                                    @error('no_surat')
                                        <div class="invalid-feedback">
                                            {{ $message; }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3 row">
                                    <label for="pengirim" class="col-sm-3 col-form-label">Pengirim</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('pengirim') is-invalid @enderror" value="{{ old('pengirim') }}" name="pengirim" placeholder="Pengirim.." required>
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
                                        <input type="text" class="form-control @error('perihal') is-invalid @enderror" value="{{ old('perihal') }}" name="perihal" placeholder="Perihal.." required>
                                    </div>
                                    @error('perihal')
                                        <div class="invalid-feedback">
                                            {{ $message; }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3 row">
                                    <label for="tanggal_surat" class="col-sm-3 col-form-label">Tanggal Surat</label>
                                    <div class="col-sm-9">
                                        <input type="date" class="form-control @error('tanggal_surat') is-invalid @enderror" value="{{ old('tanggal_surat') }}" name="tanggal_surat" required>
                                    </div>
                                    @error('tanggal_surat')
                                        <div class="invalid-feedback">
                                            {{ $message; }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3 row">
                                    <label for="isi_singkat" class="col-sm-3 col-form-label">Isi Singkat</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control @error('isi_singkat') is-invalid @enderror" name="isi_singkat" placeholder="Isi Singkat.." required>{{ old('isi_singkat') }}</textarea>
                                    </div>
                                    @error('isi_singkat')
                                        <div class="invalid-feedback">
                                            {{ $message; }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3 row">
                                    <label for="tanggal_diterima" class="col-sm-3 col-form-label">Tanggal Diterima</label>
                                    <div class="col-sm-9">
                                        <input type="date" class="form-control @error('tanggal_diterima') is-invalid @enderror" value="{{ old('tanggal_diterima') }}" name="tanggal_diterima" required>
                                    </div>
                                    @error('tanggal_diterima')
                                        <div class="invalid-feedback">
                                            {{ $message; }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3 row">
                                    <label for="lampiran" class="col-sm-3 col-form-label">Lampiran</label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control @error('lampiran') is-invalid @enderror" value="{{ old('lampiran') }}" name="lampiran" required>
                                    </div>
                                    @error('lampiran')
                                        <div class="invalid-feedback">
                                            {{ $message; }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3 row">
                                    <label for="sifat_surat" class="col-sm-3 col-form-label">Sifat Surat</label>
                                    <div class="col-sm-9">
                                        <select name="sifat_surat" class="form-control" required>
                                            <option value="">Pilih..</option>
                                            <option value="Biasa" {{ (old('sifat_surat') == 'Biasa')? 'selected':''; }}>Biasa</option>
                                            <option value="Segera" {{ (old('sifat_surat') == 'Segera')? 'selected':''; }}>Segera</option>
                                            <option value="Sangat Segera" {{ (old('sifat_surat') == 'Sangat Segera')? 'selected':''; }}>Sangat Segera</option>
                                        </select>
                                    </div>
                                    @error('sifat_surat')
                                        <div class="invalid-feedback">
                                            {{ $message; }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3 row">
                                    <label for="file_surat" class="col-sm-3 col-form-label">File</label>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control @error('file_Surat') is-invalid @enderror" value="{{ old('file_surat') }}" name="file_surat" required>
                                        <div id="file_surat" class="form-text">Ekstensi .pdf</div>
                                    </div>
                                    @error('file_Surat')
                                        <div class="invalid-feedback">
                                            {{ $message; }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3 row">
                                    <label for="" class="col-sm-3 col-form-label"></label>
                                    <div class="col-sm-9">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
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

