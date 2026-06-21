<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mahasiswa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'penulis';

    protected $primaryKey = 'penulis';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'penulis',
        'nama_lengkap',
        'email',
        'password',
        'prodi',
        'fakultas'
    ];

    protected $hidden = [
        'password'
    ];

    public function jurnal()
    {
        return $this->hasMany(
            Jurnal::class,
            'penulis',
            'penulis'
        );
    }
}