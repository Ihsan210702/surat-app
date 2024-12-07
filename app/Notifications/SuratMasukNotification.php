<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SuratMasukNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $surat;

    public function __construct($surat)
    {
        $this->surat = $surat;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    // Menyusun pesan notifikasi untuk disimpan di database
    public function toDatabase($notifiable)
    {
        // Dapatkan role pengguna
        $role = $notifiable->role; // pastikan kolom role ada di tabel users

        // Tentukan prefix berdasarkan role
        $prefix = ($role == 'admin') ? 'admin' :
        (($role == 'kepsek') ? 'kepsek' :
        (($role == 'guru') ? 'guru' :
        (($role == 'staff') ? 'staff' : 'user')));


        // Susun URL dengan prefix yang sesuai
        
        $url = url($prefix . '/surat-masuk/' . $this->surat->id . '/show');
        return [
            'surat_id' => $this->surat->id,
            'jenis_surat' => $this->surat->jenis_surat, 
            'tipe_surat' => 'Surat Masuk', 
            'perihal' => $this->surat->perihal,
            'tanggal_surat' => $this->surat->tanggal_surat,
            'url' => $url, // URL untuk melihat detail surat
        ];
    }
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}