<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incoming extends Model
{
    use HasFactory;

    // Menentukan nama tabel yang digunakan oleh model
    protected $table = 'incoming_mails'; // Ganti dengan nama tabel Anda
    protected $fillable = [
        'no_surat',
        'tanggal_surat',
        'pengirim',
        'jenis_surat',
        'tanggal_diterima',
        'perihal',
        'status_surat',
        'file_surat',
        'status',
        'tujuan_disposisi',
        'catatan_disposisi',
        'status_disposisi'
    ];

    protected $hidden = [];

    
}
