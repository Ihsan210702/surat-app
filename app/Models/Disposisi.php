<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposisi extends Model
{
    use HasFactory;

    // Menentukan nama tabel yang digunakan oleh model
    protected $table = 'disposisi_mails'; // Ganti dengan nama tabel Anda
    protected $fillable = [
        'id_surat_masuk',
        'user_id',
        'status_dibaca',
        'tanggapan'
    ];

    protected $hidden = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
