<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'bukus';

    public $timestamps = false;

    protected $casts = [
        'isbn' => 'string',
    ];

    protected $fillable = [
        'isbn',
        'judul',
        'pengarang',
        'tahun',
    ];

    protected $primaryKey = 'isbn';
}
