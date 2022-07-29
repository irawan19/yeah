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
            $cek_event                              = \App\Models\Master_event::where('status_hapus_events',0)
                                                                                ->orderBy('tanggal_events','desc')
                                                                                ->first();
            if(!empty($cek_event))
                $hasil_event                        = $cek_event->id_events;
            else
                $hasil_event                        = 0;
            
            $data['hasil_event']                    = $hasil_event;
            $data['lihat_events']                   = \App\Models\Master_event::where('status_hapus_events',0)
                                                                                ->orderBy('tanggal_events','desc')
                                                                                ->get();
        	$data['lihat_registrasi_events']        = \App\Models\Registrasi_event_detail::selectRaw('*,
                                                                                                    registrasi_event_details.created_at AS tanggal_registrasi_event_details,
                                                                                                    registrasi_event_details.updated_at AS update_registrasi_event_details')
                                                                                        ->join('registrasi_events','registrasi_events_id','registrasi_events.id_registrasi_events')
                                                                                        ->join('master_tickets','tickets_id','=','master_tickets.id_tickets')
                                                                                        ->join('master_events','master_tickets.events_id','=','master_events.id_events')
                                                                                        ->join('master_jenis_kelamins','jenis_kelamins_id','=','master_jenis_kelamins.id_jenis_kelamins')
                                                                                        ->join('master_status_pembayarans','status_pembayarans_id','=','master_status_pembayarans.id_status_pembayarans')
                                                                                        ->where('id_events',$hasil_event)
                                                                                        ->orderBy('registrasi_events.created_at','desc')
                                                                                        ->get();
            session()->forget('halaman');
            session()->forget('hasil_kata');
            session()->forget('hasil_event');
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
            $hasil_event                            = $request->cari_event;
            $data['hasil_event']                    = $hasil_event;
            $data['lihat_events']                   = \App\Models\Master_event::where('status_hapus_events',0)
                                                                                ->orderBy('tanggal_events','desc')
                                                                                ->get();
            $data['lihat_registrasi_events']        = \App\Models\Registrasi_event_detail::selectRaw('*,
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
            session(['halaman'                  => $url_sekarang]);
            session(['hasil_kata'               => $hasil_kata]);
            session(['hasil_event'              => $hasil_event]);
            return view('dashboard.registrasi_event.lihat', $data);
        }
        else
            return redirect('dashboard/registrasi_event');
    }

    public function ambilformregistrasidetails(Request $request)
    {
        $max_pemesanan_tickets                  = $request->max;
        $id_registrasi_events                   = $request->id;
        $data['max_pemesanan_tickets']          = $max_pemesanan_tickets;
        if($id_registrasi_events == 0)
        {
            $data['edit_jenis_kelamins']            = \App\Models\Master_jenis_kelamin::get();
            $data['edit_registrasi_event_details']  = collect();
        }
        else
        {
            $data['edit_jenis_kelamins']            = \App\Models\Master_jenis_kelamin::get();
            $data['edit_registrasi_event_details']  = \App\Models\Registrasi_event_detail::join('master_jenis_kelamins','jenis_kelamins_id','=','master_jenis_kelamins.id_jenis_kelamins')
                                                                                        ->where('registrasi_events_id',$id_registrasi_events)
                                                                                        ->get();
        }
        return view('dashboard.registrasi_event.formregistrasidetail',$data);
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
                                                                            ->where('mulai_registrasi_events','<=',date('Y-m-d H:i:s'))
                                                                            ->where('selesai_registrasi_events','>=',date('Y-m-d H:i:s'))
                                                                            ->where('sisa_kuota_tickets','>',0)
                                                                            ->get();
            return view('dashboard.registrasi_event.tambah',$data);
        }
        else
            return redirect('dashboard/registrasi_event');
    }

    public function prosestambah(Request $request)
    {
        $link_registrasi_event = 'registrasi_event';
        if(Yeah::hakAkses($link_registrasi_event,'tambah') == 'true')
        {
            $id_registrasi_events       = Yeah::autoIncrementKey('registrasi_events','id_registrasi_events');
            $harga_registrasi_events    = Yeah::ubahHargaKeDB($request->harga_tickets);

            if(!empty($request->userfile_bukti_pembayaran))
            {
                $aturan = [
                    'tickets_id'                                => 'required',
                    'pembayarans_id'                            => 'required',
                    'status_pembayarans_id'                     => 'required',
                    'userfile_bukti_pembayaran'                 => 'required|mimes:png,jpg,jpeg,pdf',
                ];
                $error_pesan = [
                    'tickets_id.required'                           => 'Form Ticket Harus Diisi.',
                    'pembayarans_id.required'                       => 'Form Pembayaran Harus Diisi.',
                    'status_pembayarans_id.required'                => 'Form Status Pembayaran Harus Diisi.',
                    'userfile_bukti_pembayaran.required'            => 'Form Bukti Pembayaran Harus Diisi.',
                ];
                $this->validate($request, $aturan, $error_pesan);

                $nama_bukti_pembayaran = date('Ymd').date('His').str_replace(')','',str_replace('(','',str_replace(' ','-',$request->file('userfile_bukti_pembayaran')->getClientOriginalName())));
                $path_bukti_pembayaran = './public/uploads/bukti_pembayaran/';
                $request->file('userfile_bukti_pembayaran')->move(
                    base_path() . '/public/uploads/bukti_pembayaran/', $nama_bukti_pembayaran
                );

                $registrasi_events_data = [
                    'id_registrasi_events'                  => $id_registrasi_events,
                    'tickets_id'                            => $request->tickets_id,
                    'pembayarans_id'                        => $request->pembayarans_id,
                    'status_pembayarans_id'                 => $request->status_pembayarans_id,
                    'jumlah_registrasi_events'              => 0,
                    'harga_registrasi_events'               => $harga_registrasi_events,
                    'total_harga_registrasi_events'         => 0,
                    'bukti_pembayaran_registrasi_events'    => $path_bukti_pembayaran.$nama_bukti_pembayaran,
                    'created_at'                            => date('Y-m-d H:i:s'),
                    'updated_at'                            => date('Y-m-d H:i:s'),
                    'no_registrasi_events'                  => Yeah::noRegistrasi(),
                ];
            }
            else
            {
                $aturan = [
                    'tickets_id'                                => 'required',
                    'pembayarans_id'                            => 'required',
                    'status_pembayarans_id'                     => 'required',
                ];
                $error_pesan = [
                    'tickets_id.required'                       => 'Form Ticket Harus Diisi.',
                    'pembayarans_id.required'                   => 'Form Pembayaran Harus Diisi.',
                    'status_pembayarans_id.required'            => 'Form Status Pembayaran Harus Diisi.',
                ];
                $this->validate($request, $aturan, $error_pesan);

                $registrasi_events_data = [
                    'id_registrasi_events'                  => $id_registrasi_events,
                    'tickets_id'                            => $request->tickets_id,
                    'pembayarans_id'                        => $request->pembayarans_id,
                    'status_pembayarans_id'                 => $request->status_pembayarans_id,
                    'jumlah_registrasi_events'              => 0,
                    'harga_registrasi_events'               => $harga_registrasi_events,
                    'total_harga_registrasi_events'         => 0,
                    'bukti_pembayaran_registrasi_events'    => '',
                    'created_at'                            => date('Y-m-d H:i:s'),
                    'updated_at'                            => date('Y-m-d H:i:s'),
                    'no_registrasi_events'                  => Yeah::noRegistrasi(),
                ];
            }

            $jumlah_registrasi_event_details = 0;
            foreach($request->jenis_kelamins_id as $key => $jenis_kelamins)
            {
                if(!empty($request->nama_registrasi_event_details[$key]))
                {
                    $registrasi_event_details_data = [
                        'id_registrasi_event_details'                   => Yeah::autoIncrementKey('registrasi_event_details','id_registrasi_event_details'),
                        'registrasi_events_id'                          => $id_registrasi_events,
                        'jenis_kelamins_id'                             => $jenis_kelamins,
                        'nama_registrasi_event_details'                 => $request->nama_registrasi_event_details[$key],
                        'tanggal_lahir_registrasi_event_details'        => date('Y-m-d', strtotime($request->tanggal_lahir_registrasi_event_details[$key])),
                        'email_registrasi_event_details'                => $request->email_registrasi_event_details[$key],
                        'telepon_registrasi_event_details'              => $request->telepon_registrasi_event_details[$key],
                        'created_at'                                    => date('Y-m-d H:i:s'),
                        'updated_at'                                    => date('Y-m-d H:i:s'),
                    ];
                    \App\Models\Registrasi_event_detail::insert($registrasi_event_details_data);
                    
                    $jumlah_registrasi_event_details += 1;
                }
            }
            \App\Models\Registrasi_event::insert($registrasi_events_data);

            $update_registrasi_events = [
                'jumlah_registrasi_events'          => $jumlah_registrasi_event_details,
                'total_harga_registrasi_events'     => $harga_registrasi_events * $jumlah_registrasi_event_details,
                'updated_at'                        => date('Y-m-d H:i:s'),
            ];
            \App\Models\Registrasi_event::where('id_registrasi_events',$id_registrasi_events)
                                        ->update($update_registrasi_events);

            $ambil_tickets = \App\Models\Master_ticket::where('id_tickets',$request->tickets_id)
                                                        ->first();
            if(!empty($ambil_tickets))
            {
                $sisa_kuota_tickets     = $ambil_tickets->sisa_kuota_tickets;
                $hitung_kuota_tickets   = $sisa_kuota_tickets - $jumlah_registrasi_event_details;
                $tickets_data           = [
                    'sisa_kuota_tickets'    => $hitung_kuota_tickets
                ];
                \App\Models\Master_ticket::where('id_tickets',$request->tickets_id)
                                        ->update($tickets_data);
            }

            $simpan                   = $request->simpan;
            $simpan_kembali           = $request->simpan_kembali;
            if($simpan)
            {
                $setelah_simpan = [
                    'alert'  => 'sukses',
                    'text'   => 'Data berhasil ditambahkan',
                ];
                return redirect()->back()->with('setelah_simpan', $setelah_simpan);
            }
            if($simpan_kembali)
            {
                if(request()->session()->get('halaman') != '')
                    $redirect_halaman  = request()->session()->get('halaman');
                else
                    $redirect_halaman  = 'dashboard/registrasi_event';
            
                return redirect($redirect_halaman);
            }
        }
        else
            return redirect('dashboard/registrasi_event');
    }

    public function edit($id_registrasi_events=0)
    {
        $link_registrasi_event = 'registrasi_event';
        if(Yeah::hakAkses($link_registrasi_event,'edit') == 'true')
        {
            if (!is_numeric($id_registrasi_events))
                $id_registrasi_events = 0;
            $cek_registrasi_events = \App\Models\Registrasi_event::where('id_registrasi_events',$id_registrasi_events)->count();
            if(!empty($cek_registrasi_events))
            {
                $data['edit_pembayarans']               = \App\Models\Master_pembayaran::where('status_hapus_pembayarans',0)
                                                                                    ->orderBy('nama_pembayarans','desc')
                                                                                    ->get();
                $data['edit_status_pembayarans']        = \App\Models\Master_status_pembayaran::get();
                $data['edit_tickets']                   = \App\Models\Master_ticket::join('master_events','events_id','=','master_events.id_events')
                                                                                ->where('mulai_registrasi_events','<=',date('Y-m-d H:i:s'))
                                                                                ->where('selesai_registrasi_events','>=',date('Y-m-d H:i:s'))
                                                                                ->where('sisa_kuota_tickets','>',0)
                                                                                ->get();
                $data['edit_registrasi_events']         = \App\Models\Registrasi_event::where('id_registrasi_events',$id_registrasi_events)
                                                                                        ->first();
                return view('dashboard.registrasi_event.edit',$data);
            }
            else
                return redirect('dashboard/registrasi_event');
        }
        else
            return redirect('dashboard/registrasi_event');
    }

    public function prosesedit(Request $request, $id_registrasi_events=0)
    {
        $link_registrasi_event = 'registrasi_event';
        if(Yeah::hakAkses($link_registrasi_event,'edit') == 'true')
        {
            if (!is_numeric($id_registrasi_events))
                $id_registrasi_events = 0;
            $cek_registrasi_events = \App\Models\Registrasi_event::where('id_registrasi_events',$id_registrasi_events)->first();
            if(!empty($cek_registrasi_events))
            {
                if(!empty($request->userfile_bukti_pembayaran))
                {
                    $aturan = [
                        'tickets_id'                                => 'required',
                        'pembayarans_id'                            => 'required',
                        'status_pembayarans_id'                     => 'required',
                        'userfile_bukti_pembayaran'                 => 'required|mimes:png,jpg,jpeg,pdf',
                    ];
                    $error_pesan = [
                        'tickets_id.required'                           => 'Form Ticket Harus Diisi.',
                        'pembayarans_id.required'                       => 'Form Pembayaran Harus Diisi.',
                        'status_pembayarans_id.required'                => 'Form Status Pembayaran Harus Diisi.',
                        'userfile_bukti_pembayaran.required'            => 'Form Bukti Pembayaran Harus Diisi.',
                    ];
                    $this->validate($request, $aturan, $error_pesan);

                    $harga_registrasi_events    = Yeah::ubahHargaKeDB($request->harga_tickets);

                    $bukti_pembayaran_lama        = $cek_registrasi_events->bukti_pembayaran_registrasi_events;
                    if (file_exists($bukti_pembayaran_lama))
                        unlink($bukti_pembayaran_lama);

                    $nama_bukti_pembayaran = date('Ymd').date('His').str_replace(')','',str_replace('(','',str_replace(' ','-',$request->file('userfile_bukti_pembayaran')->getClientOriginalName())));
                    $path_bukti_pembayaran = './public/uploads/bukti_pembayaran/';
                    $request->file('userfile_bukti_pembayaran')->move(
                        base_path() . '/public/uploads/bukti_pembayaran/', $nama_bukti_pembayaran
                    );

                    $registrasi_events_data = [
                        'tickets_id'                            => $request->tickets_id,
                        'pembayarans_id'                        => $request->pembayarans_id,
                        'status_pembayarans_id'                 => $request->status_pembayarans_id,
                        'jumlah_registrasi_events'              => 0,
                        'bukti_pembayaran_registrasi_events'    => $path_bukti_pembayaran.$nama_bukti_pembayaran,
                        'harga_registrasi_events'               => $harga_registrasi_events,
                        'updated_at'                            => date('Y-m-d H:i:s'),
                    ];
                }
                else
                {
                    $aturan = [
                        'tickets_id'                                => 'required',
                        'pembayarans_id'                            => 'required',
                        'status_pembayarans_id'                     => 'required',
                    ];
                    $error_pesan = [
                        'tickets_id.required'                       => 'Form Ticket Harus Diisi.',
                        'pembayarans_id.required'                   => 'Form Pembayaran Harus Diisi.',
                        'status_pembayarans_id.required'            => 'Form Status Pembayaran Harus Diisi.',
                    ];
                    $this->validate($request, $aturan, $error_pesan);

                    $harga_registrasi_events    = Yeah::ubahHargaKeDB($request->harga_tickets);

                    $registrasi_events_data = [
                        'tickets_id'                            => $request->tickets_id,
                        'pembayarans_id'                        => $request->pembayarans_id,
                        'status_pembayarans_id'                 => $request->status_pembayarans_id,
                        'jumlah_registrasi_events'              => 0,
                        'harga_registrasi_events'               => $harga_registrasi_events,
                        'updated_at'                            => date('Y-m-d H:i:s'),
                    ];
                }
                \App\Models\Registrasi_event::where('id_registrasi_events',$id_registrasi_events)
                                            ->update($registrasi_events_data);

                \App\Models\Registrasi_event_detail::where('registrasi_events_id',$id_registrasi_events)
                                                    ->delete();

                $jumlah_registrasi_event_details = 0;
                foreach($request->jenis_kelamins_id as $key => $jenis_kelamins)
                {
                    if(!empty($request->nama_registrasi_event_details[$key]))
                    {
                        $registrasi_event_details_data = [
                            'id_registrasi_event_details'                   => Yeah::autoIncrementKey('registrasi_event_details','id_registrasi_event_details'),
                            'registrasi_events_id'                          => $id_registrasi_events,
                            'jenis_kelamins_id'                             => $jenis_kelamins,
                            'nama_registrasi_event_details'                 => $request->nama_registrasi_event_details[$key],
                            'tanggal_lahir_registrasi_event_details'        => date('Y-m-d', strtotime($request->tanggal_lahir_registrasi_event_details[$key])),
                            'email_registrasi_event_details'                => $request->email_registrasi_event_details[$key],
                            'telepon_registrasi_event_details'              => $request->telepon_registrasi_event_details[$key],
                            'created_at'                                    => date('Y-m-d H:i:s'),
                            'updated_at'                                    => date('Y-m-d H:i:s'),
                        ];
                        \App\Models\Registrasi_event_detail::insert($registrasi_event_details_data);
                        
                        $jumlah_registrasi_event_details += 1;
                    }
                }

                $update_registrasi_events = [
                    'jumlah_registrasi_events'          => $jumlah_registrasi_event_details,
                    'total_harga_registrasi_events'     => $harga_registrasi_events * $jumlah_registrasi_event_details,
                    'updated_at'                        => date('Y-m-d H:i:s'),
                ];
                \App\Models\Registrasi_event::where('id_registrasi_events',$id_registrasi_events)
                                            ->update($update_registrasi_events);


                $ambil_tickets = \App\Models\Master_ticket::where('id_tickets',$request->tickets_id)
                                            ->first();
                if(!empty($ambil_tickets))
                {
                    $sisa_kuota_tickets     = $ambil_tickets->sisa_kuota_tickets;
                    $hitung_kuota_tickets   = $sisa_kuota_tickets - $jumlah_registrasi_event_details;
                    $tickets_data           = [
                        'sisa_kuota_tickets'    => $hitung_kuota_tickets
                    ];
                    \App\Models\Master_ticket::where('id_tickets',$request->tickets_id)
                                            ->update($tickets_data);
                }

                if(request()->session()->get('halaman') != '')
                    $redirect_halaman    = request()->session()->get('halaman');
                else
                    $redirect_halaman  = 'dashboard/registrasi_event';
                
                return redirect($redirect_halaman);
            }
            else
                return redirect('dashboard/registrasi_event');
        }
        else
            return redirect('dashboard/registrasi_event');
    }

    public function hapus($id_registrasi_event_details=0)
    {
        $link_registrasi_event = 'registrasi_event';
        if(Yeah::hakAkses($link_registrasi_event,'hapus') == 'true')
        {
            if (!is_numeric($id_registrasi_event_details))
                $id_registrasi_event_details = 0;
            $cek_registrasi_event_details = \App\Models\Registrasi_event_detail::where('id_registrasi_event_details',$id_registrasi_event_details)
                                                                                ->first();
            if(!empty($cek_registrasi_event_details))
            {
                $cek_registrasi_events = \App\Models\Registrasi_event::where('id_registrasi_events',$cek_registrasi_event_details->registrasi_events_id)->first();
                if(!empty($cek_registrasi_events))
                {
                    $id_registrasi_events = $cek_registrasi_events->id_registrasi_events;
                    $ambil_tickets = \App\Models\Master_ticket::where('id_tickets',$cek_registrasi_events->tickets_id)
                                                            ->first();
                    if(!empty($ambil_tickets))
                    {
                        $sisa_kuota_tickets     = $ambil_tickets->sisa_kuota_tickets;
                        $hitung_kuota_tickets   = $sisa_kuota_tickets + 1;
                        $tickets_data           = [
                            'sisa_kuota_tickets'    => $hitung_kuota_tickets
                        ];
                        \App\Models\Master_ticket::where('id_tickets',$ambil_tickets->id_tickets)
                                    ->update($tickets_data);
                    }

                    \App\Models\Registrasi_event_detail::where('id_registrasi_event_details',$id_registrasi_event_details)
                                                        ->delete();

                    $jumlah_registrasi_events           = $cek_registrasi_events->jumlah_registrasi_events;
                    $jumlah_registrasi_event_details    = \App\Models\Registrasi_event_detail::where('registrasi_events_id',$id_registrasi_events)
                                                                                            ->count();
                    if($jumlah_registrasi_event_details != 0)
                    {
                        if($jumlah_registrasi_events > $jumlah_registrasi_event_details)
                        {
                            $registrasi_events_data = [
                                'jumlah_registrasi_events'      => $jumlah_registrasi_event_details,
                                'total_harga_registrasi_events' => $cek_registrasi_events->harga_registrasi_events * $jumlah_registrasi_event_details,
                                'updated_at'                    => date('Y-m-d H:i:s')
                            ];
                            \App\Models\Registrasi_event::where('id_registrasi_events',$id_registrasi_events)
                                                        ->update($registrasi_events_data);
                        }
                        else
                        {
                            \App\Models\Registrasi_event::where('id_registrasi_events',$id_registrasi_events)
                                                                ->delete();
                        }
                    }
                    else
                    {
                        \App\Models\Registrasi_event::where('id_registrasi_events',$id_registrasi_events)
                                                            ->delete();
                    }

                    return response()->json(["sukses" => "sukses"], 200);
                }
                else
                    return redirect('dashboard/registrasi_event');
            }
            else
                return redirect('dashboard/registrasi_event');
        }
        else
            return redirect('dashboard/registrasi_event');
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
            return redirect('dashboard/registrasi_event');
    }
}