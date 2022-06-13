<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\Queue\ShouldQueue;
use Yeah;
use Auth;

class RegistrasiEventExport implements FromView, ShouldQueue
{
    use Exportable;

    public function view(): View
    {
        $hasil_kata = '';
        if(!empty(session('hasil_kata')))
            $hasil_kata = session('hasil_kata');

        $data['lihat_registrasi_events'] = \App\Models\Registrasi_event_detail::join('registrasi_events','registrasi_events_id','registrasi_events.id_registrasi_events')
                                                                                ->join('master_tickets','tickets_id','=','master_tickets.id_tickets')
                                                                                ->join('master_events','events_id','=','master_events.id_events')
                                                                                ->join('master_jenis_kelamins','jenis_kelamins_id','=','master_jenis_kelamins.id_jenis_kelamins')
                                                                                ->join('master_status_pembayarans','status_pembayarans_id','=','master_status_pembayarans.id_status_pembayarans')
                                                                                ->where('no_registrasi_events', 'LIKE', '%'.$hasil_kata.'%')
                                                                                ->orWhere('nama_events', 'LIKE', '%'.$hasil_kata.'%')
                                                                                ->orWhere('nama_tickets', 'LIKE', '%'.$hasil_kata.'%')
                                                                                ->orWhere('email_registrasi_event_details', 'LIKE', '%'.$hasil_kata.'%')
                                                                                ->orWhere('telepon_registrasi_event_details', 'LIKE', '%'.$hasil_kata.'%')
                                                                                ->orWhere('nama_registrasi_event_details', 'LIKE', '%'.$hasil_kata.'%')
                                                                                ->orWhere('nama_jenis_kelamins', 'LIKE', '%'.$hasil_kata.'%')
                                                                                ->orWhere('umur_registrasi_event_details', 'LIKE', '%'.$hasil_kata.'%')
                                                                                ->orWhere('nama_status_pembayarans', 'LIKE', '%'.$hasil_kata.'%')
                                                                                ->orderBy('registrasi_events.created_at','desc')
                                                                                ->get();
        return view('dashboard.registrasi_event.cetakexcel',$data);
    }
}
