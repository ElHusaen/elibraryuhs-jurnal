@extends('layouts.app-simple')

@section('title', 'Data Jurnal')

@section('content')

{{-- Info Filter Aktif --}}
@if(request('prodi_filter') || request('keyword'))
    <div class="alert-custom alert-info-custom">
        <strong><i class="fa fa-filter"></i> Filter aktif:</strong>
        @if(request('prodi_filter'))
            <span class="badge-custom badge-info-custom">Prodi: {{ request('prodi_filter') }}</span>
        @endif
        @if(request('keyword'))
            <span class="badge-custom badge-success-custom">Keyword: "{{ request('keyword') }}"</span>
        @endif
        <span class="badge-custom badge-secondary-custom">Total: {{ $hasil->count() }} data</span>
    </div>
@endif

{{-- Form Pencarian --}}
<div class="card-custom">
    <form action="{{ route('jurnal.index') }}" method="GET">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group" style="margin-bottom:0;">
                    <label for="keyword" style="font-size:13px; color:#666;">Cari</label>
                    <input type="text"
                        name="keyword"
                        id="keyword"
                        class="form-control"
                        placeholder="Judul / Abstrak / Penulis"
                        value="{{ request('keyword') }}">
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group" style="margin-bottom:0;">
                    <label for="prodi_filter" style="font-size:13px; color:#666;">Program Studi</label>
                    <select name="prodi_filter" id="prodi_filter" class="form-control">
                        <option value="">-- Semua Prodi --</option>
                        @foreach($prodiList as $prodi)
                            <option value="{{ $prodi }}" 
                                {{ request('prodi_filter') == $prodi ? 'selected' : '' }}>
                                {{ $prodi }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group" style="margin-bottom:0;">
                    <label for="per_page" style="font-size:13px; color:#666;">Tampilkan</label>
                    <select name="per_page" id="per_page" class="form-control">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 data</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 data</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 data</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 data</option>
                    </select>
                </div>
            </div>

            <div class="col-md-3" style="display:flex; align-items:flex-end; gap:8px; padding-bottom:1px;">
                <button type="submit" class="btn-primary-custom">
                    <i class="fa fa-search"></i> Cari
                </button>
                <a href="{{ route('jurnal.index') }}" class="btn-secondary-custom" style="background:#6c757d; color:#fff; padding:10px 20px; border-radius:8px; text-decoration:none; font-size:14px; display:inline-flex; align-items:center; gap:8px;">
                    <i class="fa fa-refresh"></i> Reset
                </a>
            </div>
        </div>
    </form>
</div>

{{-- Hasil Pencarian --}}
@if(request('keyword'))
    <div class="alert-custom alert-info-custom">
        <strong><i class="fa fa-search"></i> Hasil pencarian untuk:</strong> "{{ request('keyword') }}"
        
        <span class="badge-custom {{ $hasil->count() > 0 ? 'badge-success-custom' : 'badge-danger-custom' }}">
            {{ $hasil->count() }} hasil ditemukan
        </span>
        
        @if(isset($searchMethod) && $hasil->count() > 0)
            <span class="badge-custom badge-primary-custom" style="background:#1a3c6e; color:#fff;">
                <i class="fa fa-code"></i> {{ $searchMethod }}
            </span>
        @endif
        
        @if(isset($searchMethod) && strpos($searchMethod, 'Binary') !== false)
            <br>
            <small style="color:#666;">
                <i class="fa fa-info-circle"></i> Binary Search digunakan untuk mencari kemiripan kata (approximate match)
            </small>
        @endif
    </div>
@endif

{{-- Jika Tidak Ditemukan --}}
@if(request('keyword') && $hasil->count() == 0)
    <div class="alert-custom alert-danger-custom">
        <i class="fa fa-exclamation-triangle"></i> Jurnal tidak ditemukan di repository lokal.
    </div>
    <a href="https://doaj.org/search/articles/{{ urlencode(request('keyword')) }}"
       target="_blank"
       class="btn-success-custom">
        <i class="fa fa-external-link"></i> Cari di DOAJ
    </a>
@endif

{{-- Data Jurnal --}}
<div class="card-custom">
    <div class="card-header-custom" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
        <span><i class="fa fa-book"></i> Data Jurnal</span>
        <a href="{{ route('jurnal.create') }}" class="btn-success-custom" style="padding:6px 16px; font-size:13px;">
            <i class="fa fa-plus"></i> Tambah Jurnal
        </a>
    </div>

    <div class="table-responsive">
        <table class="table-custom">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Program Studi</th>
                    <th>Tahun</th>
                    <th>PDF</th>
                    <th width="20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $dataTampil = request('keyword') ? $hasil : $jurnal;
                @endphp

                @forelse($dataTampil as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->judul }}</td>
                        
                        {{-- TAMPILKAN NAMA PENULIS ASLI --}}
                        <td>
                            @if($item->mahasiswa)
                                {{ $item->mahasiswa->nama_lengkap }}
                            @else
                                <span class="badge-custom badge-warning-custom">Penulis tidak ditemukan</span>
                            @endif
                        </td>
                        
                        {{-- TAMPILKAN PRODI --}}
                        <td>
                            {{ $item->mahasiswa->prodi ?? '-' }}
                        </td>
                        
                        <td>{{ date('Y', strtotime($item->tgl_upload)) }}</td>
                        
                        <td>
                            @if($item->file_pdf)
                                <a href="{{ asset('uploads/jurnal/' . $item->file_pdf) }}"
                                   target="_blank"
                                   class="btn-success-custom" style="padding:4px 12px; font-size:12px;">
                                    <i class="fa fa-file-pdf-o"></i> Baca PDF
                                </a>
                            @else
                                <span class="badge-custom badge-danger-custom">
                                    Tidak Ada PDF
                                </span>
                            @endif
                        </td>

                        <td>
                            <div style="display:flex; gap:4px; flex-wrap:wrap;">
                                <a href="{{ route('jurnal.edit', $item->id_jurnal) }}"
                                   class="btn-warning-custom" style="padding:4px 10px; font-size:12px;">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <form action="{{ route('jurnal.destroy', $item->id_jurnal) }}"
                                      method="POST"
                                      style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn-danger-custom" style="padding:4px 10px; font-size:12px; border:none; cursor:pointer; border-radius:6px;"
                                            onclick="return confirm('Yakin ingin menghapus jurnal ini?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>

                                <a href="{{ route('jurnal.show', $item->id_jurnal) }}"
                                   class="btn-info-custom" style="padding:4px 10px; font-size:12px;">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:40px; color:#999;">
                            <i class="fa fa-inbox" style="font-size:28px; display:block; margin-bottom:10px;"></i>
                            Belum ada data jurnal
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div style="display:flex; justify-content:space-between; align-items:center; margin-top:20px; flex-wrap:wrap; gap:12px;">
            <div>
                <span style="color:#666; font-size:14px;">
                    Menampilkan {{ $hasil->firstItem() ?? 0 }} - {{ $hasil->lastItem() ?? 0 }} 
                    dari total {{ $hasil->total() }} data
                </span>
            </div>
            <div>
                {{ $hasil->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

@endsection