<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jurnal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jurnals';
    protected $primaryKey = 'id_jurnal';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_jurnal',
        'penulis',
        'id_kategori',
        'judul',
        'abstrak',
        'file_pdf',
        'tgl_upload',
        'status'
    ];

    public function mahasiswa() {
         return $this->belongsTo(
            Mahasiswa::class,
            'penulis', // foreign key di tabel jurnals
            'penulis'  // primary key di tabel mahasiswas
        );
    }

    public function kategori() {
        return $this->belongsTo(Kategori::class);
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }
}
