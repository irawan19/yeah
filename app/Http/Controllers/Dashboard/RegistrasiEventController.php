<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Yeah;
use Auth;
use DB;
use App\Exports\RegistrasiEventExport;
use Maatwebsite\Excel\Facades\Excel;

class RegistrasiEventController extends Controller
{
    public function index(Request $request)
    {
        $link_registrasi_event = 'registrasi_event';
        if(Yeah::hakAkses($link_registrasi_event,'lihat') == 'true')
        {
            $data['link_registrasi_event']          = $link_registrasi_event;
            $url_sekarang              	            = $request->fullUrl();
            $data['hasil_kata']        	            = '';
        	$data['lihat_registrasi_events']        = \App\Models\Registrasi_event_detail::selectRaw('*,
                                                                                                    registrasi_event_details.created_at AS tanggal_registrasi_event_details,
                                                                                                    registrasi_event_details.updated_at AS update_registrasi_event_details')
                                                                                        ->join('registrasi_events','registrasi_events_id','registrasi_events.id_registrasi_events')
                                                                                        ->join('master_tickets','tickets_id','=','master_tickets.id_tickets')
                                                                                        ->join('master_events','master_tickets.events_id','=','master_events.id_events')
                                                                                        ->join('master_jenis_kelamins','jenis_kelamins_id','=','master_jenis_kelamins.id_jenis_kelamins')
                                                                                        ->join('master_status_pembayarans','status_pembayarans_id','=','master_status_pembayarans.id_status_pembayarans')
                                                                                        ->orderBy('registrasi_events.created_at','desc')
                                                                                        ->paginate(25);
            session()->forget('halaman');
            session()->forget('hasil_kata');
            session(['halaman'                          => $url_sekarang]);
        	return view('dashboard.registrasi_event.lihat', $data);
        }
        else
            return redirect('dashboard');
    }

    public function cari(Request $request)
    {
        $link_registrasi_event = 'registrasi_event';
        if(Yeah::hakAkses($link_registrasi_event,'lihat') == 'true')
        {
            $data['link_registrasi_event']          = $link_registrasi_event;
            $url_sekarang                 	        = $request->fullUrl();
            $hasil_kata                   	        = $request->cari_kata;
            $data['hasil_kata']           	        = $hasil_kata;
            $data['lihat_registrasi_events']        = \App\Models\Registrasi_event_detail::join('registrasi_events','registrasi_events_id','registrasi_events.id_registrasi_events')
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
                                                                                        ->paginate(25);
            session(['halaman'                  => $url_sekarang]);
            session(['hasil_kata'               => $hasil_kata]);
            return view('dashboard.registrasi_event.lihat', $data);
        }
        else
            return redirect('dashboard');
    }

    public function tambah()
    {
        $link_registrasi_event = 'registrasi_event';
        if(Yeah::hakAkses($link_registrasi_event,'tambah') == 'true')
        {
            $data['tambah_pembayarans']         = \App\Models\Master_pembayaran::where('status_hapus_pembayarans',0)
                                                                                ->orderBy('nama_pembayarans','desc')
                                                                                ->get();
            $data['tambah_status_pembayarans']  = \App\Models\Master_status_pembayaran::get();
            $data['tambah_tickets']             = \App\Models\Master_ticket::join('master_events','events_id','=','master_events.id_events')
                                                                            ->where('mulai_registrasi_tickets','<=',date('Y-m-d H:i:s'))
                                                                            ->where('selesai_registrasi_tickets','>=',date('Y-m-d H:i:s'))
                                                                            ->where('sisa_kuota_tickets','>',0)
                                                                            ->get();
            $data['tambah_jenis_kelamins']      = \App\Models\Master_jenis_kelamin::get();
            return view('dashboard.registrasi_event.tambah',$data);
        }
        else
            return redirect('dashboard');
    }

    public function prosestambah(Request $request)
    {
        $link_registrasi_event = 'registrasi_event';
        if(Yeah::hakAkses($link_registrasi_event,'tambah') == 'true')
        {
            $aturan = [
                'tickets_id'                    => 'required',
            ];
            $error_pesan = [
                'tickets_id.required'           => 'Form Ticket Harus Diisi.',
            ];
            $this->validate($request, $aturan, $error_pesan);
        }
        else
            return redirect('dashboard');
    }

    public function edit($id_registrasi_event_details=0)
    {
        $link_registrasi_event = 'registrasi_event';
        if(Yeah::hakAkses($link_registrasi_event,'edit') == 'true')
        {

        }
        else
            return redirect('dashboard');
    }

    public function prosesedit(Request $request, $id_registrasi_event_details=0)
    {
        $link_registrasi_event = 'registrasi_event';
        if(Yeah::hakAkses($link_registrasi_event,'edit') == 'true')
        {

        }
        else
            return redirect('dashboard');
    }

    public function hapus($id_registrasi_event_details=0)
    {
        $link_registrasi_event = 'registrasi_event';
        if(Yeah::hakAkses($link_registrasi_event,'hapus') == 'true')
        {
            if (!is_numeric($id_registrasi_event_details))
                $id_registrasi_event_details = 0;
            $cek_registrasi_event_details = \App\Models\Master_registrasi_event_detail::where('id_registrasi_event_details',$id_registrasi_event_details)->count();
            if($cek_registrasi_event_details != 0)
            {
            	\App\Models\Master_registrasi_event::where('id_registrasi_events',$cek_registrasi_event_details->registrasi_events_id)
            								->delete();
                \App\Models\Master_registrasi_event_detail::where('id_registrasi_event_details',$id_registrasi_event_details)
                                                            ->delete();
            	return response()->json(["sukses" => "sukses"], 200);
            }
            else
                return redirect('registrasi_event');
        }
        else
            return redirect('registrasi_event');
    }

    public function cetakexcel()
    {
        $link_registrasi_event = 'registrasi_event';
        if(Yeah::hakAkses($link_registrasi_event,'hapus') == 'true')
        {
            $tanggal_hari_ini = date('Y-m-d H:i:s');
            return Excel::download(New RegistrasiEventExport, 'registrasi_event_'.Yeah::ubahDBKeTanggal($tanggal_hari_ini).'.xlsx');
        }
        else
            return redirect('registrasi_event');
    }
}