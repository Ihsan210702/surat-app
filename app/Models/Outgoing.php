<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outgoing extends Model
{
    use HasFactory;

    // Menentukan nama tabel yang digunakan oleh model
    protected $table = 'outgoing_mails'; // Ganti dengan nama tabel Anda
    protected $fillable = [
        'no_surat',
        'tanggal_surat',
        'tujuan',
        'jenis_surat',
        'perihal',
        'file_surat',
        'status'
    ];

    protected $hidden = [];
    
}
