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
        'pengirim',
        'perihal',
        'tanggal_surat',
        'isi_singkat',
        'tanggal_diterima',
        'sifat_surat',
        'file_surat',
        'status',
        'tujuan_disposisi',
        'catatan_disposisi',
        'isi_disposisi',
        'status_disposisi'
    ];

    protected $hidden = [];

    
}
