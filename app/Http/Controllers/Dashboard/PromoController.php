<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Yeah;
use Auth;
use DB;

class PromoController extends Controller
{
    public function index(Request $request)
    {
        $link_promo = 'promo';
        if(Yeah::hakAkses($link_promo,'lihat') == 'true')
        {
            $data['link_promo']         = $link_promo;
            $url_sekarang              	= $request->fullUrl();
            $data['hasil_kata']        	= '';
        	$data['lihat_promos']       = \App\Models\Master_promo::join('master_events','events_id','=','master_events.id_events')
                                                                    ->where('status_hapus_promos',0)
                                                                    ->orderBy('tanggal_events','desc')
                                                                    ->orderBy('nama_promos','asc')
        															->get();
            session()->forget('halaman');
            session()->forget('hasil_kata');
            session(['halaman'                          => $url_sekarang]);
        	return view('dashboard.promo.lihat', $data);
        }
        else
            return redirect('dashboard');
    }

    public function cari(Request $request)
    {
        $link_promo = 'promo';
        if(Yeah::hakAkses($link_promo,'lihat') == 'true')
        {
            $data['link_promo']             = $link_promo;
            $url_sekarang                 	= $request->fullUrl();
            $hasil_kata                   	= $request->cari_kata;
            $data['hasil_kata']           	= $hasil_kata;
            $data['lihat_promos']           = \App\Models\Master_promo::join('master_events','events_id','=','master_events.id_events')
                                                                        ->where('nama_events', 'LIKE', '%'.$hasil_kata.'%')
                                                                        ->where('status_hapus_promos',0)
                                                                        ->orWhere('nama_promos', 'LIKE', '%'.$hasil_kata.'%')
                                                                        ->where('status_hapus_promos',0)
                                                                        ->orderBy('tanggal_events','desc')
                                                                        ->orderBy('nama_promos','asc')
                                                                        ->get();
            session(['halaman'                  => $url_sekarang]);
            session(['hasil_kata'               => $hasil_kata]);
            return view('dashboard.promo.lihat', $data);
        }
        else
            return redirect('dashboard/promo');
    }

    public function tambah()
    {
        $link_promo = 'promo';
        if(Yeah::hakAkses($link_promo,'tambah') == 'true')
        {
            $data['tambah_events']  = \App\Models\Master_event::where('mulai_registrasi_events','<=',date('Y-m-d H:i:s'))
                                                                ->where('selesai_registrasi_events','>=',date('Y-m-d H:i:s'))
                                                                ->where('status_hapus_events',0)
                                                                ->orderBy('tanggal_events','desc')
                                                                ->get();
            return view('dashboard.promo.tambah',$data);
        }
        else
            return redirect('dashboard/promo');
    }

    public function prosestambah(Request $request)
    {
        $link_promo = 'promo';
        if(Yeah::hakAkses($link_promo,'tambah') == 'true')
        {
            $aturan = [
                'events_id'                     => 'required',
                'nama_promos'                   => 'required',
                'userfile_gambar_promo'         => 'required|mimes:jpg,png,jpeg',
                'deskripsi_promos'              => 'required',
            ];
            $error_pesan = [
                'events_id.required'                => 'Form Event Harus Diisi.',
                'nama_promos.required'              => 'Form Nama Harus Diisi.',
                'userfile_gambar_promo.required'    => 'Form Gambar Harus Diisi.',
                'deskripsi_promos.required'         => 'Form Deskripsi Harus Diisi.',
            ];
            $this->validate($request, $aturan, $error_pesan);

            $nama_gambar_promo = date('Ymd').date('His').str_replace(')','',str_replace('(','',str_replace(' ','-',$request->file('userfile_gambar_promo')->getClientOriginalName())));
            $path_gambar_promo = './public/uploads/promo/';
            $request->file('userfile_gambar_promo')->move(
                base_path() . '/public/uploads/promo/', $nama_gambar_promo
            );

            $id_promos = Yeah::autoIncrementKey('master_promos','id_promos');
            $data = [
            	'id_promos'      	        => $id_promos,
                'events_id'                 => $request->events_id,
                'users_id'                  => Auth::user()->id,
                'nama_promos'    	        => $request->nama_promos,
                'gambar_promos'             => $path_gambar_promo.$nama_gambar_promo,
                'deskripsi_promos'          => $request->deskripsi_promos,
                'status_hapus_promos'       => 0,
                'created_at'                => date('Y-m-d H:i:s'),
                'updated_at'                => date('Y-m-d H:i:s')
            ];
            \App\Models\Master_promo::insert($data);
            
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
                    $redirect_halaman  = 'dashboard/promo';

                return redirect($redirect_halaman);
            }
        }
        else
            return redirect('dashboard/promo');
    }

    public function baca($id_promos=0)
    {
        $link_promo = 'promo';
        if(Yeah::hakAkses($link_promo,'baca') == 'true')
        {
            if (!is_numeric($id_promos))
                $id_promos = 0;
            $cek_promos = \App\Models\Master_promo::where('id_promos',$id_promos)->count();
            if($cek_promos != 0)
            {
                $data['baca_promos']    = \App\Models\Master_promo::join('users','users_id','=','users.id')
                                                                    ->join('master_events','events_id','=','master_events.id_events')
                                                                    ->where('id_promos',$id_promos)
                                                                    ->first();
                return view('dashboard.promo.baca',$data);
            }
            else
                return redirect('dashboard/promo');
        }
        else
            return redirect('dashboard/promo');
    }

    public function edit($id_promos=0)
    {
        $link_promo = 'promo';
        if(Yeah::hakAkses($link_promo,'edit') == 'true')
        {
            if (!is_numeric($id_promos))
                $id_promos = 0;
            $cek_promos = \App\Models\Master_promo::where('id_promos',$id_promos)->first();
            if(!empty($cek_promos))
            {
                $data['edit_events']    = \App\Models\Master_event::where('mulai_registrasi_events','<=',date('Y-m-d H:i:s'))
                                                                    ->where('selesai_registrasi_events','>=',date('Y-m-d H:i:s'))
                                                                    ->where('status_hapus_events',0)
                                                                    ->orderBy('tanggal_events','desc')
                                                                    ->get();
                $data['edit_promos']  = $cek_promos;
                return view('dashboard.promo.edit',$data);
            }
            else
                return redirect('dashboard/promo');
        }
        else
            return redirect('dashboard/promo');
    }

    public function prosesedit($id_promos=0, Request $request)
    {
        $link_promo = 'promo';
        if(Yeah::hakAkses($link_promo,'edit') == 'true')
        {
            if (!is_numeric($id_promos))
                $id_promos = 0;
            $cek_promos = \App\Models\Master_promo::where('id_promos',$id_promos)->first();
            if(!empty($cek_promos))
            {
                if(!empty($request->userfile_gambar_promo))
                {
                    $aturan = [
                        'events_id'                     => 'required',
                        'nama_promos'                   => 'required',
                        'userfile_gambar_promo'         => 'required|mimes:jpg,png,jpeg',
                        'deskripsi_promos'              => 'required',
                    ];
                    $error_pesan = [
                        'events_id.required'                => 'Form Event Harus Diisi.',
                        'nama_promos.required'              => 'Form Nama Harus Diisi.',
                        'userfile_gambar_promo.required'    => 'Form Gambar Harus Diisi.',
                        'deskripsi_promos.required'         => 'Form Deskripsi Harus Diisi.',
                    ];
                    $this->validate($request, $aturan, $error_pesan);

                    $gambar_promo_lama        = $cek_promos->gambar_promos;
                    if (file_exists($gambar_promo_lama))
                        unlink($gambar_promo_lama);
        
                    $nama_gambar_promo = date('Ymd').date('His').str_replace(')','',str_replace('(','',str_replace(' ','-',$request->file('userfile_gambar_promo')->getClientOriginalName())));
                    $path_gambar_promo = './public/uploads/promo/';
                    $request->file('userfile_gambar_promo')->move(
                        base_path() . '/public/uploads/promo/', $nama_gambar_promo
                    );

                    $data = [
                        'events_id'                 => $request->events_id,
                        'users_id'                  => Auth::user()->id,
                        'nama_promos'    	        => $request->nama_promos,
                        'gambar_promos'             => $path_gambar_promo.$nama_gambar_promo,
                        'deskripsi_promos'          => $request->deskripsi_promos,
                        'updated_at'                => date('Y-m-d H:i:s')
                    ];
                }
                else
                {
                    $aturan = [
                        'events_id'                     => 'required',
                        'nama_promos'                   => 'required',
                        'deskripsi_promos'              => 'required',
                    ];
                    $error_pesan = [
                        'events_id.required'                => 'Form Event Harus Diisi.',
                        'nama_promos.required'              => 'Form Nama Harus Diisi.',
                        'deskripsi_promos.required'         => 'Form Deskripsi Harus Diisi.',
                    ];
                    $this->validate($request, $aturan, $error_pesan);

                    $data = [
                        'events_id'                 => $request->events_id,
                        'users_id'                  => Auth::user()->id,
                        'nama_promos'    	        => $request->nama_promos,
                        'deskripsi_promos'    	    => $request->deskripsi_promos,
                        'updated_at'                => date('Y-m-d H:i:s')
                    ];
                }
                \App\Models\Master_promo::where('id_promos', $id_promos)
                                        ->update($data);

                if(request()->session()->get('halaman') != '')
                    $redirect_halaman    = request()->session()->get('halaman');
                else
                    $redirect_halaman  = 'dashboard/promo';
                
                return redirect($redirect_halaman);
            }
            else
                return redirect('dashboard/promo');
        }
        else
            return redirect('dashboard/promo');
    }

    public function hapus($id_promos=0)
    {
        $link_promo = 'promo';
        if(Yeah::hakAkses($link_promo,'hapus') == 'true')
        {
            if (!is_numeric($id_promos))
                $id_promos = 0;
            $cek_promos = \App\Models\Master_promo::where('id_promos',$id_promos)->count();
            if($cek_promos != 0)
            {
            	$promos_data = [
                    'users_id'              => Auth::user()->id,
            		'status_hapus_promos'	=> 1
            	];
            	\App\Models\Master_promo::where('id_promos',$id_promos)
            								->update($promos_data);
            	return response()->json(["sukses" => "sukses"], 200);
            }
            else
                return redirect('dashboard/promo');
        }
        else
            return redirect('dashboard/promo');
    }
}