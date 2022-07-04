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
        $hasil_event = 0;
        if(!empty(session('hasil_event')))
            $hasil_event = session('hasil_event');

        $hasil_kata = '';
        if(!empty(session('hasil_kata')))
            $hasil_kata = session('hasil_kata');

        $data['lihat_registrasi_events'] = \App\Models\Registrasi_event_detail::selectRaw('*,
                                                                                            registrasi_event_details.created_at AS tanggal_registrasi_event_details,
                                                                                            registrasi_event_details.updated_at AS update_registrasi_event_details')
                                                                            ->join('registrasi_events','registrasi_events_id','registrasi_events.id_registrasi_events')
                                                                            ->join('master_tickets','tickets_id','=','master_tickets.id_tickets')
                                                                            ->join('master_events','events_id','=','master_events.id_events')
                                                                            ->join('master_jenis_kelamins','jenis_kelamins_id','=','master_jenis_kelamins.id_jenis_kelamins')
                                                                            ->join('master_status_pembayarans','status_pembayarans_id','=','master_status_pembayarans.id_status_pembayarans')
                                                                            ->where('no_registrasi_events', 'LIKE', '%'.$hasil_kata.'%')
                                                                            ->where('id_events',$hasil_event)
                                                                            ->orWhere('nama_events', 'LIKE', '%'.$hasil_kata.'%')
                                                                            ->where('id_events',$hasil_event)
                                                                            ->orWhere('nama_tickets', 'LIKE', '%'.$hasil_kata.'%')
                                                                            ->where('id_events',$hasil_event)
                                                                            ->orWhere('email_registrasi_event_details', 'LIKE', '%'.$hasil_kata.'%')
                                                                            ->where('id_events',$hasil_event)
                                                                            ->orWhere('telepon_registrasi_event_details', 'LIKE', '%'.$hasil_kata.'%')
                                                                            ->where('id_events',$hasil_event)
                                                                            ->orWhere('nama_registrasi_event_details', 'LIKE', '%'.$hasil_kata.'%')
                                                                            ->where('id_events',$hasil_event)
                                                                            ->orWhere('nama_jenis_kelamins', 'LIKE', '%'.$hasil_kata.'%')
                                                                            ->where('id_events',$hasil_event)
                                                                            ->orWhere('tanggal_lahir_registrasi_event_details', 'LIKE', '%'.$hasil_kata.'%')
                                                                            ->where('id_events',$hasil_event)
                                                                            ->orWhere('nama_status_pembayarans', 'LIKE', '%'.$hasil_kata.'%')
                                                                            ->where('id_events',$hasil_event)
                                                                            ->orderBy('registrasi_events.created_at','desc')
                                                                            ->get();
        return view('dashboard.registrasi_event.cetakexcel',$data);
    }
}
