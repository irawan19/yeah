<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Yeah;
use Auth;
use DB;

class LevelSistemController extends Controller
{
    public function index(Request $request)
    {
        $link_level_sistem = 'level_sistem';
        if(Yeah::hakAkses($link_level_sistem,'lihat') == 'true')
        {
            $data['link_level_sistem']      = $link_level_sistem;
            $url_sekarang                   = $request->fullUrl();
            $data['hasil_kata']             = '';
        	$data['lihat_level_sistems']    = \App\Models\Master_level_sistem::get();
            session()->forget('halaman');
            session()->forget('hasil_kata');
            session(['halaman'                          => $url_sekarang]);
        	return view('dashboard.level_sistem.lihat', $data);
        }
        else
            return redirect('dashboard');
    }

    public function cari(Request $request)
    {
        $link_level_sistem = 'level_sistem';
        if(Yeah::hakAkses($link_level_sistem,'lihat') == 'true')
        {
            $data['link_level_sistem']          = $link_level_sistem;
            $url_sekarang                       = $request->fullUrl();
            $hasil_kata                         = $request->cari_kata;
            $data['hasil_kata']                 = $hasil_kata;
            $data['lihat_level_sistems']        = \App\Models\Master_level_sistem::where('nama_level_sistems', 'LIKE', '%'.$hasil_kata.'%')
                                                                            ->get();
            session(['halaman'                  => $url_sekarang]);
            session(['hasil_kata'               => $hasil_kata]);
            return view('dashboard.level_sistem.lihat', $data);
        }
        else
            return redirect('dashboard');
    }

    public function tambah()
    {
        $link_level_sistem = 'level_sistem';
        if(Yeah::hakAkses($link_level_sistem,'tambah') == 'true')
        {
            $data['tambah_menus']  = \App\Models\Master_menu::where('sub_menus_id',0)
                                                    ->orderBy('order_menus')
                                                    ->get();
            return view('dashboard.level_sistem.tambah',$data);
        }
        else
            return redirect('level_sistem');
    }

    public function prosestambah(Request $request)
    {
        $link_level_sistem = 'level_sistem';
        if(Yeah::hakAkses($link_level_sistem,'tambah') == 'true')
        {
            $aturan = [
                'nama_level_sistems'           => 'required',
            ];
            $error_pesan = [
                'nama_level_sistems.required'   => 'Form Nama Harus Diisi.',
            ];
            $this->validate($request, $aturan, $error_pesan);

            $id_level_sistems = Yeah::autoIncrementKey('master_level_sistems','id_level_sistems');
            $data = [
            	'id_level_sistems'      => $id_level_sistems,
                'nama_level_sistems'    => $request->nama_level_sistems,
                'created_at'            => date('Y-m-d H:i:s'),
                'updated_at'            => date('Y-m-d H:i:s')
            ];
            \App\Models\Master_level_sistem::insert($data);

            foreach ($request->fiturs_id as $fiturs_id)
            {
                $akses_data = [
                    'id_akses'              => Yeah::autoIncrementKey('master_akses','id_akses'),
                    'level_sistems_id'      => $id_level_sistems,
                    'fiturs_id'             => $fiturs_id
                ];
                \App\Models\Master_akses::insert($akses_data);
            }
            
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
                    $redirect_halaman  = 'level_sistem';

                return redirect($redirect_halaman);
            }
        }
        else
            return redirect('level_sistem');
    }

    public function baca($id_level_sistems=0)
    {
        $link_level_sistem = 'level_sistem';
        if(Yeah::hakAkses($link_level_sistem,'baca') == 'true')
        {
            if (!is_numeric($id_level_sistems))
                $id_level_sistems = 0;
            $cek_level_sistems = \App\Models\Master_level_sistem::where('id_level_sistems',$id_level_sistems)->count();
            if($cek_level_sistems != 0)
            {
            	$data['baca_admins']			= \App\Models\User::where('level_sistems_id',$id_level_sistems)
		                												->where('user_statuses_id','!=',3)
		                												->get();
                $data['baca_menus']             = \App\Models\Master_menu::where('sub_menus_id',0)
                                                                ->orderBy('order_menus')
                                                                ->get();
                $data['baca_level_sistems']     = \App\Models\Master_level_sistem::where('id_level_sistems',$id_level_sistems)
                                                                ->first();
                return view('dashboard.level_sistem.baca',$data);
            }
            else
                return redirect('level_sistem');
        }
        else
            return redirect('level_sistem');
    }

    public function edit($id_level_sistems=0)
    {
        $link_level_sistem = 'level_sistem';
        if(Yeah::hakAkses($link_level_sistem,'edit') == 'true')
        {
            if (!is_numeric($id_level_sistems))
                $id_level_sistems = 0;
            $cek_level_sistems = \App\Models\Master_level_sistem::where('id_level_sistems',$id_level_sistems)->count();
            if($cek_level_sistems != 0)
            {
                $data['edit_menus']          = \App\Models\Master_menu::where('sub_menus_id',0)
                                                                ->orderBy('order_menus')
                                                                ->get();
                $data['edit_level_sistems']  = \App\Models\Master_level_sistem::where('id_level_sistems',$id_level_sistems)
                                                                      ->first();
                return view('dashboard.level_sistem.edit',$data);
            }
            else
                return redirect('level_sistem');
        }
        else
            return redirect('level_sistem');
    }

    public function prosesedit($id_level_sistems=0, Request $request)
    {
        $link_level_sistem = 'level_sistem';
        if(Yeah::hakAkses($link_level_sistem,'edit') == 'true')
        {
            if (!is_numeric($id_level_sistems))
                $id_level_sistems = 0;
            $cek_level_sistems = \App\Models\Master_level_sistem::where('id_level_sistems',$id_level_sistems)->count();
            if($cek_level_sistems != 0)
            {
                $aturan = [
                    'nama_level_sistems'           => 'required',
                ];
                $error_pesan = [
                    'nama_level_sistems.required'   => 'Form Nama Harus Diisi.',
                ];
                $this->validate($request, $aturan, $error_pesan);

                $data = [
                    'nama_level_sistems'    => $request->nama_level_sistems,
                    'updated_at'            => date('Y-m-d H:i:s'),
                ];
                \App\Models\Master_level_sistem::where('id_level_sistems', $id_level_sistems)
                                        ->update($data);
                
                \App\Models\Master_akses::where('level_sistems_id',$id_level_sistems)->delete();
                foreach ($request->fiturs_id as $fiturs_id)
                {
                    $akses_data = [
                        'id_akses'              => Yeah::autoIncrementKey('master_akses','id_akses'),
                        'level_sistems_id'      => $id_level_sistems,
                        'fiturs_id'             => $fiturs_id
                    ];
                    \App\Models\Master_akses::insert($akses_data);
                }

                if(request()->session()->get('halaman') != '')
                    $redirect_halaman    = request()->session()->get('halaman');
                else
                    $redirect_halaman  = 'level_sistem';
                
                return redirect($redirect_halaman);
            }
            else
                return redirect('level_sistem');
        }
        else
            return redirect('level_sistem');
    }

    public function hapus($id_level_sistems=0)
    {
        $link_level_sistem = 'level_sistem';
        if(Yeah::hakAkses($link_level_sistem,'hapus') == 'true')
        {
            if (!is_numeric($id_level_sistems))
                $id_level_sistems = 0;
            $cek_level_sistems = \App\Models\Master_level_sistem::where('id_level_sistems',$id_level_sistems)->count();
            if($cek_level_sistems != 0)
            {
                if($id_level_sistems != 1)
                {
                    \App\Models\Master_akses::where('level_sistems_id',$id_level_sistems)
                                            ->delete();
                    \App\Models\Master_level_sistem::where('id_level_sistems',$id_level_sistems)
                                                    ->delete();
                    return response()->json(["sukses" => "sukses"], 200);
                }
                else
                    return redirect('level_sistem');
            }
            else
                return redirect('level_sistem');
        }
        else
            return redirect('level_sistem');
    }

}