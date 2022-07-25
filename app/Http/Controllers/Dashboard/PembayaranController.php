<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Yeah;
use Auth;
use DB;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $link_pembayaran = 'pembayaran';
        if(Yeah::hakAkses($link_pembayaran,'lihat') == 'true')
        {
            $data['link_pembayaran']        = $link_pembayaran;
            $url_sekarang              	    = $request->fullUrl();
            $data['hasil_kata']        	    = '';
        	$data['lihat_pembayarans']      = \App\Models\Master_pembayaran::join('master_tipe_pembayarans','tipe_pembayarans_id','=','master_tipe_pembayarans.id_tipe_pembayarans')
                                                                            ->leftJoin('master_events','events_id','=','master_events.id_events')
                                                                            ->where('status_hapus_pembayarans',0)
                                                                            ->orderBy('nama_tipe_pembayarans','asc')
                                                                            ->orderBy('nama_pembayarans','asc')
                                                                            ->get();
            session()->forget('halaman');
            session()->forget('hasil_kata');
            session(['halaman'                          => $url_sekarang]);
        	return view('dashboard.pembayaran.lihat', $data);
        }
        else
            return redirect('dashboard');
    }

    public function cari(Request $request)
    {
        $link_pembayaran = 'pembayaran';
        if(Yeah::hakAkses($link_pembayaran,'lihat') == 'true')
        {
            $data['link_pembayaran']            = $link_pembayaran;
            $url_sekarang                 	    = $request->fullUrl();
            $hasil_kata                   	    = $request->cari_kata;
            $data['hasil_kata']           	    = $hasil_kata;
            $data['lihat_pembayarans']          = \App\Models\Master_pembayaran::join('master_tipe_pembayarans','tipe_pembayarans_id','=','master_tipe_pembayarans.id_tipe_pembayarans')
                                                                                ->leftJoin('master_events','events_id','=','master_events.id_events')
                                                                                ->where('nama_tipe_pembayarans', 'LIKE', '%'.$hasil_kata.'%')
                                                                                ->where('status_hapus_pembayarans',0)
                                                                                ->orWhere('nama_pembayarans', 'LIKE', '%'.$hasil_kata.'%')
                                                                                ->where('status_hapus_pembayarans',0)
                                                                                ->orderBy('nama_tipe_pembayarans','asc')
                                                                                ->orderBy('nama_pembayarans','asc')
                                                                                ->get();
            session(['halaman'                  => $url_sekarang]);
            session(['hasil_kata'               => $hasil_kata]);
            return view('dashboard.pembayaran.lihat', $data);
        }
        else
            return redirect('dashboard/pembayaran');
    }

    public function tambah()
    {
        $link_pembayaran = 'pembayaran';
        if(Yeah::hakAkses($link_pembayaran,'tambah') == 'true')
        {
            $data['tambah_events']              = \App\Models\Master_event::where('status_hapus_events',0)
                                                                            ->orderBy('tanggal_events','desc')
                                                                            ->get();
            $data['tambah_tipe_pembayarans']    = \App\Models\Master_tipe_pembayaran::orderBy('nama_tipe_pembayarans')
                                                                                    ->get();            
            return view('dashboard.pembayaran.tambah',$data);
        }
        else
            return redirect('dashboard/pembayaran');
    }

    public function prosestambah(Request $request)
    {
        $link_pembayaran = 'pembayaran';
        if(Yeah::hakAkses($link_pembayaran,'tambah') == 'true')
        {
            $aturan = [
                'tipe_pembayarans_id'                   => 'required',
                'nama_pembayarans'                      => 'required',
                'userfile_logo_pembayaran'              => 'required|mimes:jpg,png,jpeg',
            ];
            $error_pesan = [
                'tipe_pembayarans_id.required'           => 'Form Tipe Pembayaran Harus Diisi.',
                'nama_pembayarans.required'              => 'Form Nama Harus Diisi.',
                'userfile_logo_pembayaran.required'      => 'Form Gambar Harus Diisi.',
            ];
            $this->validate($request, $aturan, $error_pesan);

            $nama_logo_pembayaran = date('Ymd').date('His').str_replace(')','',str_replace('(','',str_replace(' ','-',$request->file('userfile_logo_pembayaran')->getClientOriginalName())));
            $path_logo_pembayaran = './public/uploads/pembayaran/';
            $request->file('userfile_logo_pembayaran')->move(
                base_path() . '/public/uploads/pembayaran/', $nama_logo_pembayaran
            );
            
            $no_rekening_pembayarans = '';
            if(!empty($request->no_rekening_pembayarans))
                $no_rekening_pembayarans = $request->no_rekening_pembayarans;

            $nama_rekening_pembayarans = '';
            if(!empty($request->nama_rekening_pembayarans))
                $nama_rekening_pembayarans = $request->nama_rekening_pembayarans;

            $id_pembayarans = Yeah::autoIncrementKey('master_pembayarans','id_pembayarans');
            $data = [
            	'id_pembayarans'      	            => $id_pembayarans,
                'tipe_pembayarans_id'               => $request->tipe_pembayarans_id,
                'events_id'                         => $request->events_id,
                'nama_pembayarans'    	            => $request->nama_pembayarans,
                'logo_pembayarans'                  => $path_logo_pembayaran.$nama_logo_pembayaran,
                'no_rekening_pembayarans'           => $no_rekening_pembayarans,
                'nama_rekening_pembayarans'         => $nama_rekening_pembayarans,
                'status_hapus_pembayarans'          => 0,
                'created_at'                        => date('Y-m-d H:i:s'),
                'updated_at'                        => date('Y-m-d H:i:s')
            ];
            \App\Models\Master_pembayaran::insert($data);
            
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
                    $redirect_halaman  = 'dashboard/pembayaran';

                return redirect($redirect_halaman);
            }
        }
        else
            return redirect('dashboard/pembayaran');
    }

    public function baca($id_pembayarans=0)
    {
        $link_pembayaran = 'pembayaran';
        if(Yeah::hakAkses($link_pembayaran,'baca') == 'true')
        {
            if (!is_numeric($id_pembayarans))
                $id_pembayarans = 0;
            $cek_pembayarans = \App\Models\Master_pembayaran::where('id_pembayarans',$id_pembayarans)->count();
            if($cek_pembayarans != 0)
            {
                $data['baca_pembayarans']    = \App\Models\Master_pembayaran::join('master_tipe_pembayarans','tipe_pembayarans_id','=','master_tipe_pembayarans.id_tipe_pembayarans')
                                                                            ->leftJoin('master_events','events_id','=','master_events.id_events')
                                                                            ->where('id_pembayarans',$id_pembayarans)
                                                                            ->first();
                return view('dashboard.pembayaran.baca',$data);
            }
            else
                return redirect('dashboard/pembayaran');
        }
        else
            return redirect('dashboard/pembayaran');
    }

    public function edit($id_pembayarans=0)
    {
        $link_pembayaran = 'pembayaran';
        if(Yeah::hakAkses($link_pembayaran,'edit') == 'true')
        {
            if (!is_numeric($id_pembayarans))
                $id_pembayarans = 0;
            $cek_pembayarans = \App\Models\Master_pembayaran::where('id_pembayarans',$id_pembayarans)->first();
            if(!empty($cek_pembayarans))
            {
                $data['edit_events']            = \App\Models\Master_event::where('status_hapus_events',0)
                                                                            ->orderBy('tanggal_events','desc')
                                                                            ->get();
                $data['edit_tipe_pembayarans']  = \App\Models\Master_tipe_pembayaran::orderBy('nama_tipe_pembayarans','asc')
                                                                                    ->get();
                $data['edit_pembayarans']       = $cek_pembayarans;
                return view('dashboard.pembayaran.edit',$data);
            }
            else
                return redirect('dashboard/pembayaran');
        }
        else
            return redirect('dashboard/pembayaran');
    }

    public function prosesedit($id_pembayarans=0, Request $request)
    {
        $link_pembayaran = 'pembayaran';
        if(Yeah::hakAkses($link_pembayaran,'edit') == 'true')
        {
            if (!is_numeric($id_pembayarans))
                $id_pembayarans = 0;
            $cek_pembayarans = \App\Models\Master_pembayaran::where('id_pembayarans',$id_pembayarans)->first();
            if(!empty($cek_pembayarans))
            {
                if(!empty($request->userfile_logo_pembayaran))
                {
                    $aturan = [
                        'tipe_pembayarans_id'                   => 'required',
                        'nama_pembayarans'                      => 'required',
                        'userfile_logo_pembayaran'              => 'required|mimes:jpg,png,jpeg',
                    ];
                    $error_pesan = [
                        'tipe_pembayarans_id.required'           => 'Form Tipe Pembayaran Harus Diisi.',
                        'nama_pembayarans.required'              => 'Form Nama Harus Diisi.',
                        'userfile_logo_pembayaran.required'      => 'Form Gambar Harus Diisi.',
                    ];
                    $this->validate($request, $aturan, $error_pesan);

                    $logo_pembayaran_lama        = $cek_pembayarans->logo_pembayarans;
                    if (file_exists($logo_pembayaran_lama))
                        unlink($logo_pembayaran_lama);
        
                    $nama_logo_pembayaran = date('Ymd').date('His').str_replace(')','',str_replace('(','',str_replace(' ','-',$request->file('userfile_logo_pembayaran')->getClientOriginalName())));
                    $path_logo_pembayaran = './public/uploads/pembayaran/';
                    $request->file('userfile_logo_pembayaran')->move(
                        base_path() . '/public/uploads/pembayaran/', $nama_logo_pembayaran
                    );

                    $no_rekening_pembayarans = '';
                    if(!empty($request->no_rekening_pembayarans))
                        $no_rekening_pembayarans = $request->no_rekening_pembayarans;

                    $nama_rekening_pembayarans = '';
                    if(!empty($request->nama_rekening_pembayarans))
                        $nama_rekening_pembayarans = $request->nama_rekening_pembayarans;
        
                    $data = [
                        'tipe_pembayarans_id'               => $request->tipe_pembayarans_id,
                        'events_id'                         => $request->events_id,
                        'nama_pembayarans'    	            => $request->nama_pembayarans,
                        'logo_pembayarans'                  => $path_logo_pembayaran.$nama_logo_pembayaran,
                        'no_rekening_pembayarans'           => $no_rekening_pembayarans,
                        'nama_rekening_pembayarans'         => $nama_rekening_pembayarans,
                        'updated_at'                        => date('Y-m-d H:i:s')
                    ];
                }
                else
                {
                    $aturan = [
                        'tipe_pembayarans_id'                   => 'required',
                        'nama_pembayarans'                      => 'required',
                    ];
                    $error_pesan = [
                        'tipe_pembayarans_id.required'           => 'Form Tipe Pembayaran Harus Diisi.',
                        'nama_pembayarans.required'              => 'Form Nama Harus Diisi.',
                    ];
                    $this->validate($request, $aturan, $error_pesan);

                    $no_rekening_pembayarans = '';
                    if(!empty($request->no_rekening_pembayarans))
                        $no_rekening_pembayarans = $request->no_rekening_pembayarans;

                    $nama_rekening_pembayarans = '';
                    if(!empty($request->nama_rekening_pembayarans))
                        $nama_rekening_pembayarans = $request->nama_rekening_pembayarans;
        
                    $data = [
                        'tipe_pembayarans_id'               => $request->tipe_pembayarans_id,
                        'events_id'                         => $request->events_id,
                        'nama_pembayarans'    	            => $request->nama_pembayarans,
                        'no_rekening_pembayarans'           => $no_rekening_pembayarans,
                        'nama_rekening_pembayarans'         => $nama_rekening_pembayarans,
                        'updated_at'                        => date('Y-m-d H:i:s')
                    ];
                }
                \App\Models\Master_pembayaran::where('id_pembayarans', $id_pembayarans)
                                        ->update($data);

                if(request()->session()->get('halaman') != '')
                    $redirect_halaman    = request()->session()->get('halaman');
                else
                    $redirect_halaman  = 'dashboard/pembayaran';
                
                return redirect($redirect_halaman);
            }
            else
                return redirect('dashboard/pembayaran');
        }
        else
            return redirect('dashboard/pembayaran');
    }

    public function hapus($id_pembayarans=0)
    {
        $link_pembayaran = 'pembayaran';
        if(Yeah::hakAkses($link_pembayaran,'hapus') == 'true')
        {
            if (!is_numeric($id_pembayarans))
                $id_pembayarans = 0;
            $cek_pembayarans = \App\Models\Master_pembayaran::where('id_pembayarans',$id_pembayarans)->count();
            if($cek_pembayarans != 0)
            {
            	$pembayarans_data = [
                    'users_id'              => Auth::user()->id,
            		'status_hapus_pembayarans'	=> 1
            	];
            	\App\Models\Master_pembayaran::where('id_pembayarans',$id_pembayarans)
            								->update($pembayarans_data);
            	return response()->json(["sukses" => "sukses"], 200);
            }
            else
                return redirect('dashboard/pembayaran');
        }
        else
            return redirect('dashboard/pembayaran');
    }
}