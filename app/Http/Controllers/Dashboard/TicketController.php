<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Yeah;
use Auth;
use DB;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $link_ticket = 'ticket';
        if(Yeah::hakAkses($link_ticket,'lihat') == 'true')
        {
            $data['link_ticket']        = $link_ticket;
            $url_sekarang              	= $request->fullUrl();
            $data['hasil_kata']        	= '';
        	$data['lihat_tickets']      = \App\Models\Master_ticket::join('master_events','events_id','=','master_events.id_events')
                                                                    ->where('status_hapus_tickets',0)
                                                                    ->orderBy('tanggal_events','desc')
                                                                    ->orderBy('nama_tickets','asc')
        															->get();
            session()->forget('halaman');
            session()->forget('hasil_kata');
            session(['halaman'                          => $url_sekarang]);
        	return view('dashboard.ticket.lihat', $data);
        }
        else
            return redirect('dashboard');
    }

    public function cari(Request $request)
    {
        $link_ticket = 'ticket';
        if(Yeah::hakAkses($link_ticket,'lihat') == 'true')
        {
            $data['link_ticket']            = $link_ticket;
            $url_sekarang                 	= $request->fullUrl();
            $hasil_kata                   	= $request->cari_kata;
            $data['hasil_kata']           	= $hasil_kata;
            $data['lihat_tickets']          = \App\Models\Master_ticket::join('master_events','events_id','=','master_events.id_events')
                                                                        ->where('nama_events', 'LIKE', '%'.$hasil_kata.'%')
                                                                        ->where('status_hapus_tickets',0)
                                                                        ->orWhere('nama_tickets', 'LIKE', '%'.$hasil_kata.'%')
                                                                        ->where('status_hapus_tickets',0)
                                                                        ->orderBy('tanggal_events','desc')
                                                                        ->orderBy('nama_tickets','asc')
                                                                        ->get();
            session(['halaman'                  => $url_sekarang]);
            session(['hasil_kata'               => $hasil_kata]);
            return view('dashboard.ticket.lihat', $data);
        }
        else
            return redirect('dashboard/ticket');
    }

    public function tambah()
    {
        $link_ticket = 'ticket';
        if(Yeah::hakAkses($link_ticket,'tambah') == 'true')
        {
            $data['tambah_events']  = \App\Models\Master_event::where('mulai_registrasi_events','<=',date('Y-m-d H:i:s'))
                                                                ->where('selesai_registrasi_events','>=',date('Y-m-d H:i:s'))
                                                                ->where('status_hapus_events',0)
                                                                ->orderBy('tanggal_events','desc')
                                                                ->get();
            return view('dashboard.ticket.tambah',$data);
        }
        else
            return redirect('dashboard/ticket');
    }

    public function prosestambah(Request $request)
    {
        $link_ticket = 'ticket';
        if(Yeah::hakAkses($link_ticket,'tambah') == 'true')
        {
            $aturan = [
                'events_id'                         => 'required',
                'nama_tickets'                      => 'required',
                'harga_tickets'                     => 'required',
                'kuota_tickets'                     => 'required',
                'deskripsi_tickets'                 => 'required',
                'keterangan_tickets'                => 'required',
                'max_pemesanan_tickets'             => 'required|numeric|min:1',
            ];
            $error_pesan = [
                'events_id.required'                => 'Form Event Harus Diisi.',
                'nama_tickets.required'             => 'Form Nama Harus Diisi.',
                'harga_tickets.required'            => 'Form Harga Harus Diisi.',
                'kuota_tickets.required'            => 'Form Kuoat Harus Diisi.',
                'deskripsi_tickets.required'        => 'Form Deskripsi Harus Diisi.',
                'keterangan_tickets.required'       => 'Form Keterangan Harus Diisi.',
                'max_pemesanan_tickets.required'    => 'Form Max Pemesanan Harus Diisi.',
                'max_pemesanan_tickets.min'         => 'Form Max Pemesanan Minimal Harus Diisi 1.',
            ];
            $this->validate($request, $aturan, $error_pesan);

            $id_tickets = Yeah::autoIncrementKey('master_tickets','id_tickets');
            $data = [
                'id_tickets'                    => $id_tickets,
                'events_id'                     => $request->events_id,
                'users_id'                      => Auth::user()->id,
                'nama_tickets'    	            => $request->nama_tickets,
                'harga_tickets'                 => Yeah::ubahHargaKeDB($request->harga_tickets),
                'kuota_tickets'                 => $request->kuota_tickets,
                'sisa_kuota_tickets'            => $request->kuota_tickets,
                'deskripsi_tickets'             => $request->deskripsi_tickets,
                'keterangan_tickets'            => $request->keterangan_tickets,
                'max_pemesanan_tickets'         => $request->max_pemesanan_tickets,
                'status_hapus_tickets'          => 0,
                'created_at'                    => date('Y-m-d H:i:s'),
                'updated_at'                    => date('Y-m-d H:i:s')
            ];
            \App\Models\Master_ticket::insert($data);
            
            $simpan           = $request->simpan;
            $simpan_kembali   = $request->simpan_kembali;
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
                    $redirect_halaman  = 'dashboard/ticket';

                return redirect($redirect_halaman);
            }
        }
        else
            return redirect('dashboard/ticket');
    }

    public function baca($id_tickets=0)
    {
        $link_ticket = 'ticket';
        if(Yeah::hakAkses($link_ticket,'baca') == 'true')
        {
            if (!is_numeric($id_tickets))
                $id_tickets = 0;
            $cek_tickets = \App\Models\Master_ticket::where('id_tickets',$id_tickets)->count();
            if($cek_tickets != 0)
            {
                $data['baca_tickets']    = \App\Models\Master_ticket::join('users','users_id','=','users.id')
                                                                    ->join('master_events','events_id','=','master_events.id_events')
                                                                    ->where('id_tickets',$id_tickets)
                                                                    ->first();
                return view('dashboard.ticket.baca',$data);
            }
            else
                return redirect('dashboard/ticket');
        }
        else
            return redirect('dashboard/ticket');
    }

    public function edit($id_tickets=0)
    {
        $link_ticket = 'ticket';
        if(Yeah::hakAkses($link_ticket,'edit') == 'true')
        {
            if (!is_numeric($id_tickets))
                $id_tickets = 0;
            $cek_tickets = \App\Models\Master_ticket::where('id_tickets',$id_tickets)->first();
            if(!empty($cek_tickets))
            {
                $data['edit_events']    = \App\Models\Master_event::where('mulai_registrasi_events','<=',date('Y-m-d H:i:s'))
                                                                    ->where('selesai_registrasi_events','>=',date('Y-m-d H:i:s'))
                                                                    ->where('status_hapus_events',0)
                                                                    ->orderBy('tanggal_events','desc')
                                                                    ->get();
                $data['edit_tickets']   = $cek_tickets;
                return view('dashboard.ticket.edit',$data);
            }
            else
                return redirect('dashboard/ticket');
        }
        else
            return redirect('dashboard/ticket');
    }

    public function prosesedit($id_tickets=0, Request $request)
    {
        $link_ticket = 'ticket';
        if(Yeah::hakAkses($link_ticket,'edit') == 'true')
        {
            if (!is_numeric($id_tickets))
                $id_tickets = 0;
            $cek_tickets = \App\Models\Master_ticket::where('id_tickets',$id_tickets)->first();
            if(!empty($cek_tickets))
            {
                $aturan = [
                    'events_id'                         => 'required',
                    'nama_tickets'                      => 'required',
                    'harga_tickets'                     => 'required',
                    'kuota_tickets'                     => 'required',
                    'deskripsi_tickets'                 => 'required',
                    'keterangan_tickets'                => 'required',
                    'max_pemesanan_tickets'             => 'required|numeric|min:1',
                ];
                $error_pesan = [
                    'events_id.required'                => 'Form Event Harus Diisi.',
                    'nama_tickets.required'             => 'Form Nama Harus Diisi.',
                    'harga_tickets.required'            => 'Form Harga Harus Diisi.',
                    'kuota_tickets.required'            => 'Form Kuoat Harus Diisi.',
                    'deskripsi_tickets.required'        => 'Form Deskripsi Harus Diisi.',
                    'keterangan_tickets.required'       => 'Form Keterangan Harus Diisi.',
                    'max_pemesanan_tickets.required'    => 'Form Max Pemesanan Harus Diisi.',
                    'max_pemesanan_tickets.min'         => 'Form Max Pemesanan Minimal Harus Diisi 1.',
                ];
                $this->validate($request, $aturan, $error_pesan);

                $total_registrasi_events = \App\Models\Registrasi_event_detail::join('registrasi_events','registrasi_events_id','=','registrasi_events.id_registrasi_events')
                                                                                ->where('tickets_id',$id_tickets)
                                                                                ->count();

                $sisa_kuota_tickets = $request->kuota_tickets - $total_registrasi_events;
                
                if($sisa_kuota_tickets < 0)
                {
                    $setelah_simpan = [
                        'alert'  => 'error',
                        'text'   => 'Kuota lebih kecil dari total yang sudah registrasi. Total registrasi = '.$total_registrasi_events.', kuota yang dimasukkan = '.$request->kuota_tickets,
                    ];
                    return redirect()->back()->with('setelah_simpan', $setelah_simpan);
                }
                else
                {
                    $data = [
                        'events_id'                     => $request->events_id,
                        'users_id'                      => Auth::user()->id,
                        'nama_tickets'    	            => $request->nama_tickets,
                        'harga_tickets'                 => Yeah::ubahHargaKeDB($request->harga_tickets),
                        'kuota_tickets'                 => $request->kuota_tickets,
                        'sisa_kuota_tickets'            => $sisa_kuota_tickets,
                        'deskripsi_tickets'             => $request->deskripsi_tickets,
                        'keterangan_tickets'            => $request->keterangan_tickets,
                        'max_pemesanan_tickets'         => $request->max_pemesanan_tickets,
                        'updated_at'                    => date('Y-m-d H:i:s')
                    ];
                    \App\Models\Master_ticket::where('id_tickets', $id_tickets)
                                            ->update($data);

                    if(request()->session()->get('halaman') != '')
                        $redirect_halaman    = request()->session()->get('halaman');
                    else
                        $redirect_halaman  = 'dashboard/ticket';
                    
                    return redirect($redirect_halaman);
                }
            }
            else
                return redirect('dashboard/ticket');
        }
        else
            return redirect('dashboard/ticket');
    }

    public function hapus($id_tickets=0)
    {
        $link_ticket = 'ticket';
        if(Yeah::hakAkses($link_ticket,'hapus') == 'true')
        {
            if (!is_numeric($id_tickets))
                $id_tickets = 0;
            $cek_tickets = \App\Models\Master_ticket::where('id_tickets',$id_tickets)->count();
            if($cek_tickets != 0)
            {
            	$tickets_data = [
                    'users_id'              => Auth::user()->id,
            		'status_hapus_tickets'	=> 1
            	];
            	\App\Models\Master_ticket::where('id_tickets',$id_tickets)
            								->update($tickets_data);
            	return response()->json(["sukses" => "sukses"], 200);
            }
            else
                return redirect('dashboard/ticket');
        }
        else
            return redirect('dashboard/ticket');
    }
}