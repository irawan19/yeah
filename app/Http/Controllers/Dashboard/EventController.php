<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Yeah;
use Auth;
use DB;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $link_event = 'event';
        if(Yeah::hakAkses($link_event,'lihat') == 'true')
        {
            $data['link_event']         = $link_event;
            $url_sekarang              	= $request->fullUrl();
            $data['hasil_kata']        	= '';
        	$data['lihat_events']       = \App\Models\Master_event::where('status_hapus_events',0)
                                                                    ->orderBy('tanggal_events','desc')
        															->get();
            session()->forget('halaman');
            session()->forget('hasil_kata');
            session(['halaman'                          => $url_sekarang]);
        	return view('dashboard.event.lihat', $data);
        }
        else
            return redirect('dashboard');
    }

    public function cari(Request $request)
    {
        $link_event = 'event';
        if(Yeah::hakAkses($link_event,'lihat') == 'true')
        {
            $data['link_event']             = $link_event;
            $url_sekarang                 	= $request->fullUrl();
            $hasil_kata                   	= $request->cari_kata;
            $data['hasil_kata']           	= $hasil_kata;
            $data['lihat_events']           = \App\Models\Master_event::where('nama_events', 'LIKE', '%'.$hasil_kata.'%')
                                                                        ->orWhere('lokasi_events', 'LIKE', '%'.$hasil_kata.'%')
                                                                        ->where('status_hapus_events',0)
                                                                        ->orderBy('tanggal_events','desc')
                                                                        ->get();
            session(['halaman'                  => $url_sekarang]);
            session(['hasil_kata'               => $hasil_kata]);
            return view('dashboard.event.lihat', $data);
        }
        else
            return redirect('dashboard');
    }

    public function tambah()
    {
        $link_event = 'event';
        if(Yeah::hakAkses($link_event,'tambah') == 'true')
            return view('dashboard.event.tambah');
        else
            return redirect('event');
    }

    public function prosestambah(Request $request)
    {
        $link_event = 'event';
        if(Yeah::hakAkses($link_event,'tambah') == 'true')
        {
            $aturan = [
                'nama_events'                   => 'required',
                'tanggal_events'                => 'required',
                'userfile_gambar_event'         => 'required|mimes:jpg,png,jpeg',
                'deskripsi_events'              => 'required',
                'disclaimer_events'             => 'required',
                'lokasi_events'                 => 'required',
                'tanggal_registrasi_events'     => 'required',
            ];
            $error_pesan = [
                'nama_events.required'              => 'Form Nama Harus Diisi.',
                'tanggal_events.required'           => 'Form Tanggal Harus Diisi.',
                'userfile_gambar_event.required'    => 'Form Gambar Harus Diisi.',
                'deskripsi_events.required'         => 'Form Deskripsi Harus Diisi.',
                'disclaimer_events.required'        => 'Form Disclaimer Harus Diisi.',
                'lokasi_events'                     => 'Form Lokasi Harus Diisi.',
                'tanggal_registrasi_events'         => 'Form Tanggal Registrasi Harus Diisi.',
            ];
            $this->validate($request, $aturan, $error_pesan);

            $nama_gambar_event = date('Ymd').date('His').str_replace(')','',str_replace('(','',str_replace(' ','-',$request->file('userfile_gambar_event')->getClientOriginalName())));
            $path_gambar_event = './public/uploads/event/';
            $request->file('userfile_gambar_event')->move(
                base_path() . '/public/uploads/event/', $nama_gambar_event
            );

            $pecah_tanggal_registrasi_events    = explode(' sampai ',$request->tanggal_registrasi_events);
            $mulai_registrasi                   = Yeah::ubahTanggalwaktuKeDB($pecah_tanggal_registrasi_events[0]);
            $selesai_registrasi                 = Yeah::ubahTanggalwaktuKeDB($pecah_tanggal_registrasi_events[1]);

            $id_events = Yeah::autoIncrementKey('master_events','id_events');
            $data = [
            	'id_events'      	        => $id_events,
                'nama_events'    	        => $request->nama_events,
                'tanggal_events'            => Yeah::ubahTanggalKeDB($request->tanggal_events),
                'gambar_events'             => $path_gambar_event.$nama_gambar_event,
                'deskripsi_events'          => $request->deskripsi_events,
                'disclaimer_events'         => $request->disclaimer_events,
                'lokasi_events'             => $request->lokasi_events,
                'mulai_registrasi_events'   => $mulai_registrasi,
                'selesai_registrasi_events' => $selesai_registrasi,
                'status_hapus_events'       => 0,
                'created_at'                => date('Y-m-d H:i:s'),
                'updated_at'                => date('Y-m-d H:i:s')
            ];
            \App\Models\Master_event::insert($data);
            
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
                    $redirect_halaman  = 'event';

                return redirect($redirect_halaman);
            }
        }
        else
            return redirect('event');
    }

    public function baca($id_events=0)
    {
        $link_event = 'event';
        if(Yeah::hakAkses($link_event,'baca') == 'true')
        {
            if (!is_numeric($id_events))
                $id_events = 0;
            $cek_events = \App\Models\Master_event::where('id_events',$id_events)->first();
            if(!empty($cek_events))
            {
                $data['baca_events']    = $cek_events;
                return view('dashboard.event.baca',$data);
            }
            else
                return redirect('dashboard/event');
        }
        else
            return redirect('dashboard/event');
    }

    public function edit($id_events=0)
    {
        $link_event = 'event';
        if(Yeah::hakAkses($link_event,'edit') == 'true')
        {
            if (!is_numeric($id_events))
                $id_events = 0;
            $cek_events = \App\Models\Master_event::where('id_events',$id_events)->first();
            if(!empty($cek_events))
            {
                $data['edit_events']  = $cek_events;
                return view('dashboard.event.edit',$data);
            }
            else
                return redirect('event');
        }
        else
            return redirect('event');
    }

    public function prosesedit($id_events=0, Request $request)
    {
        $link_event = 'event';
        if(Yeah::hakAkses($link_event,'edit') == 'true')
        {
            if (!is_numeric($id_events))
                $id_events = 0;
            $cek_events = \App\Models\Master_event::where('id_events',$id_events)->first();
            if(!empty($cek_events))
            {
                if(!empty($request->userfile_gambar_event))
                {
                    $aturan = [
                        'nama_events'                   => 'required',
                        'tanggal_events'                => 'required',
                        'userfile_gambar_event'         => 'required|mimes:jpg,png,jpeg',
                        'deskripsi_events'              => 'required',
                        'disclaimer_events'             => 'required',
                        'lokasi_events'                 => 'required',
                        'tanggal_registrasi_events'     => 'required',
                    ];
                    $error_pesan = [
                        'nama_events.required'              => 'Form Nama Harus Diisi.',
                        'tanggal_events.required'           => 'Form Tanggal Harus Diisi.',
                        'userfile_gambar_event.required'    => 'Form Gambar Harus Diisi.',
                        'deskripsi_events.required'         => 'Form Deskripsi Harus Diisi.',
                        'disclaimer_events.required'        => 'Form Disclaimer Harus Diisi.',
                        'lokasi_events'                     => 'Form Lokasi Harus Diisi.',
                        'tanggal_registrasi_events'         => 'Form Tanggal Registrasi Harus Diisi.',
                    ];
                    $this->validate($request, $aturan, $error_pesan);

                    $gambar_event_lama        = $cek_events->gambar_events;
                    if (file_exists($gambar_event_lama))
                        unlink($gambar_event_lama);
        
                    $nama_gambar_event = date('Ymd').date('His').str_replace(')','',str_replace('(','',str_replace(' ','-',$request->file('userfile_gambar_event')->getClientOriginalName())));
                    $path_gambar_event = './public/uploads/event/';
                    $request->file('userfile_gambar_event')->move(
                        base_path() . '/public/uploads/event/', $nama_gambar_event
                    );
        
                    $pecah_tanggal_registrasi_events    = explode(' sampai ',$request->tanggal_registrasi_events);
                    $mulai_registrasi                   = Yeah::ubahTanggalwaktuKeDB($pecah_tanggal_registrasi_events[0]);
                    $selesai_registrasi                 = Yeah::ubahTanggalwaktuKeDB($pecah_tanggal_registrasi_events[1]);
        
                    $data = [
                        'nama_events'    	        => $request->nama_events,
                        'tanggal_events'            => Yeah::ubahTanggalKeDB($request->tanggal_events),
                        'gambar_events'             => $path_gambar_event.$nama_gambar_event,
                        'deskripsi_events'          => $request->deskripsi_events,
                        'disclaimer_events'         => $request->disclaimer_events,
                        'lokasi_events'             => $request->lokasi_events,
                        'mulai_registrasi_events'   => $mulai_registrasi,
                        'selesai_registrasi_events' => $selesai_registrasi,
                        'updated_at'                => date('Y-m-d H:i:s')
                    ];
                }
                else
                {
                    $aturan = [
                        'nama_events'                   => 'required',
                        'tanggal_events'                => 'required',
                        'deskripsi_events'              => 'required',
                        'disclaimer_events'             => 'required',
                        'lokasi_events'                 => 'required',
                        'tanggal_registrasi_events'     => 'required',
                    ];
                    $error_pesan = [
                        'nama_events.required'              => 'Form Nama Harus Diisi.',
                        'tanggal_events.required'           => 'Form Tanggal Harus Diisi.',
                        'deskripsi_events.required'         => 'Form Deskripsi Harus Diisi.',
                        'disclaimer_events.required'        => 'Form Disclaimer Harus Diisi.',
                        'lokasi_events'                     => 'Form Lokasi Harus Diisi.',
                        'tanggal_registrasi_events'         => 'Form Tanggal Registrasi Harus Diisi.',
                    ];
                    $this->validate($request, $aturan, $error_pesan);
        
                    $pecah_tanggal_registrasi_events    = explode(' sampai ',$request->tanggal_registrasi_events);
                    $mulai_registrasi                   = Yeah::ubahTanggalwaktuKeDB($pecah_tanggal_registrasi_events[0]);
                    $selesai_registrasi                 = Yeah::ubahTanggalwaktuKeDB($pecah_tanggal_registrasi_events[1]);
        
                    $data = [
                        'nama_events'    	        => $request->nama_events,
                        'tanggal_events'            => Yeah::ubahTanggalKeDB($request->tanggal_events),
                        'deskripsi_events'          => $request->deskripsi_events,
                        'disclaimer_events'         => $request->disclaimer_events,
                        'lokasi_events'             => $request->lokasi_events,
                        'mulai_registrasi_events'   => $mulai_registrasi,
                        'selesai_registrasi_events' => $selesai_registrasi,
                        'updated_at'                => date('Y-m-d H:i:s')
                    ];
                }
                \App\Models\Master_event::where('id_events', $id_events)
                                        ->update($data);

                if(request()->session()->get('halaman') != '')
                    $redirect_halaman    = request()->session()->get('halaman');
                else
                    $redirect_halaman  = 'event';
                
                return redirect($redirect_halaman);
            }
            else
                return redirect('event');
        }
        else
            return redirect('event');
    }

    public function hapus($id_events=0)
    {
        $link_event = 'event';
        if(Yeah::hakAkses($link_event,'hapus') == 'true')
        {
            if (!is_numeric($id_events))
                $id_events = 0;
            $cek_events = \App\Models\Master_event::where('id_events',$id_events)->count();
            if($cek_events != 0)
            {
            	$events_data = [
            		'status_hapus_events'	=> 1
            	];
            	\App\Models\Master_event::where('id_events',$id_events)
            								->update($events_data);
            	return response()->json(["sukses" => "sukses"], 200);
            }
            else
                return redirect('event');
        }
        else
            return redirect('event');
    }
}