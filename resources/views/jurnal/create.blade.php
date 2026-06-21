@extends('layouts.app-simple')

@section('title', 'Tambah Jurnal')

@section('content')

<div class="card-custom">
    <div class="card-header-custom">
        <i class="fa fa-plus-circle"></i> Tambah Jurnal
    </div>

    <form action="{{ route('jurnal.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        {{-- ===== BAGIAN PENULIS ASLI ===== --}}
        <div class="alert-custom alert-info-custom" style="margin-bottom:20px;">
            <i class="fa fa-info-circle"></i> 
            <strong>Informasi:</strong> Isi nama penulis ASLI dari karya tulis ini (bisa berbeda dengan nama Anda yang login)
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="nama_penulis_asli">Nama Penulis Asli <span class="text-danger">*</span></label>
                    <input type="text"
                           name="nama_penulis_asli"
                           id="nama_penulis_asli"
                           class="form-control @error('nama_penulis_asli') is-invalid @enderror"
                           required
                           placeholder="Contoh: Prof. Dr. Ahmad, S.Kom., M.Kom"
                           value="{{ old('nama_penulis_asli') }}">
                    <small style="color:#888; font-size:12px; display:block; margin-top:4px;">
                        <i class="fa fa-info-circle"></i> Isi dengan nama penulis SEBENARNYA dari jurnal ini
                    </small>
                    @error('nama_penulis_asli')
                        <div style="color:#dc3545; font-size:13px; margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="email_penulis">Email Penulis <span style="color:#888; font-weight:400;">(Opsional)</span></label>
                    <input type="email"
                           name="email_penulis"
                           id="email_penulis"
                           class="form-control @error('email_penulis') is-invalid @enderror"
                           placeholder="email.penulis@example.com"
                           value="{{ old('email_penulis') }}">
                    @error('email_penulis')
                        <div style="color:#dc3545; font-size:13px; margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="prodi">Program Studi <span class="text-danger">*</span></label>
                    <input type="text"
                           name="prodi"
                           id="prodi"
                           class="form-control @error('prodi') is-invalid @enderror"
                           required
                           placeholder="Contoh: Teknik Informatika"
                           value="{{ old('prodi') }}">
                    @error('prodi')
                        <div style="color:#dc3545; font-size:13px; margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="fakultas">Fakultas <span class="text-danger">*</span></label>
                    <input type="text"
                           name="fakultas"
                           id="fakultas"
                           class="form-control @error('fakultas') is-invalid @enderror"
                           required
                           placeholder="Contoh: Teknik"
                           value="{{ old('fakultas') }}">
                    @error('fakultas')
                        <div style="color:#dc3545; font-size:13px; margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <hr style="margin: 24px 0; border-color: #eee;">

        {{-- ===== BAGIAN JURNAL ===== --}}
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="id_kategori">Kategori <span class="text-danger">*</span></label>
                    <select name="id_kategori"
                            id="id_kategori"
                            class="form-control @error('id_kategori') is-invalid @enderror"
                            required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $ktg)
                            <option value="{{ $ktg->id_kategori }}" {{ old('id_kategori') == $ktg->id_kategori ? 'selected' : '' }}>
                                {{ $ktg->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_kategori')
                        <div style="color:#dc3545; font-size:13px; margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="judul">Judul Jurnal <span class="text-danger">*</span></label>
                    <input type="text"
                           name="judul"
                           id="judul"
                           class="form-control @error('judul') is-invalid @enderror"
                           required
                           placeholder="Masukkan judul jurnal"
                           value="{{ old('judul') }}">
                    @error('judul')
                        <div style="color:#dc3545; font-size:13px; margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="abstrak">Abstrak <span class="text-danger">*</span></label>
                    <textarea name="abstrak"
                              id="abstrak"
                              class="form-control @error('abstrak') is-invalid @enderror"
                              rows="6"
                              required
                              placeholder="Masukkan abstrak jurnal...">{{ old('abstrak') }}</textarea>
                    @error('abstrak')
                        <div style="color:#dc3545; font-size:13px; margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="file_pdf">Upload PDF <span class="text-danger">*</span></label>
                    <input type="file"
                           name="file_pdf"
                           id="file_pdf"
                           class="form-control @error('file_pdf') is-invalid @enderror"
                           accept=".pdf"
                           required>
                    <small style="color:#888; font-size:12px; display:block; margin-top:4px;">
                        <i class="fa fa-info-circle"></i> Maksimal ukuran file 10 MB
                    </small>
                    @error('file_pdf')
                        <div style="color:#dc3545; font-size:13px; margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status"
                            id="status"
                            class="form-control">
                        <option value="review" {{ old('status') == 'review' ? 'selected' : '' }}>Review</option>
                        <option value="publish" {{ old('status') == 'publish' ? 'selected' : '' }}>Publish</option>
                        <option value="ditolak" {{ old('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
            </div>
        </div>

        <div style="display:flex; gap:12px; margin-top:8px; flex-wrap:wrap;">
            <button type="submit" class="btn-success-custom">
                <i class="fa fa-save"></i> Simpan
            </button>
            <a href="{{ route('jurnal.index') }}" class="btn-secondary-custom" style="padding:8px 20px; text-decoration:none; display:inline-flex; align-items:center; gap:8px; background:#6c757d; color:#fff; border-radius:8px;">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>

    </form>
</div>

@endsection