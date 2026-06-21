@extends('layouts.app')

@section('content')

<div class="container-fluid">

```
<div class="card">

    <div class="card-header">
        <h4>Detail Jurnal</h4>
    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <tr>
                <th width="25%">Judul</th>
                <td>{{ $jurnal->judul }}</td>
            </tr>

            <tr>
                <th>Penulis</th>
                <td>{{ $jurnal->mahasiswa->nama_lengkap ?? '-' }}</td>
            </tr>

            <tr>
                <th>Program Studi</th>
                <td>{{ $jurnal->mahasiswa->prodi ?? '-' }}</td>
            </tr>

            <tr>
                <th>Kategori</th>
                <td>{{ $jurnal->kategori->nama_kategori ?? '-' }}</td>
            </tr>

            <tr>
                <th>Tanggal Upload</th>
                <td>{{ date('d-m-Y', strtotime($jurnal->tgl_upload)) }}</td>
            </tr>

            <tr>
                <th>Status</th>
                <td>

                    @if($jurnal->status == 'publish')
                        <span class="badge bg-success">
                            Publish
                        </span>

                    @elseif($jurnal->status == 'review')
                        <span class="badge bg-warning">
                            Review
                        </span>

                    @else
                        <span class="badge bg-danger">
                            Ditolak
                        </span>
                    @endif

                </td>
            </tr>

            <tr>
                <th>Abstrak</th>
                <td>{{ $jurnal->abstrak }}</td>
            </tr>

            <tr>
                <th>File PDF</th>
                <td>

                    @if($jurnal->file_pdf)

                        <a href="{{ asset('uploads/jurnal/'.$jurnal->file_pdf) }}"
                           target="_blank"
                           class="btn btn-success">

                            Baca PDF

                        </a>

                    @else

                        <span class="text-danger">
                            File tidak tersedia
                        </span>

                    @endif

                </td>
            </tr>

        </table>

        <a href="{{ route('jurnal.index') }}"
           class="btn btn-secondary">

            Kembali

        </a>

    </div>

</div>
```

</div>

@endsection
