<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Yeah;
use Auth;

class SosialMediaController extends Controller
{

    public function index(Request $request)
    {
        $link_sosial_media = 'sosial_media';
        if(Yeah::hakAkses($link_sosial_media,'lihat') == 'true')
        {
            $data['link_sosial_media']          = $link_sosial_media;
            $data['hasil_kata']                 = '';
            $url_sekarang                       = $request->fullUrl();
        	$data['lihat_sosial_medias']    	= \App\Models\Master_sosial_media::get();
            session()->forget('halaman');
            session()->forget('hasil_kata');
            session(['halaman'              => $url_sekarang]);
        	return view('dashboard.sosial_media.lihat', $data);
        }
        else
            return redirect('dashboard');
    }

    public function cari(Request $request)
    {
        $link_sosial_media = 'sosial_media';
        if(Yeah::hakAkses($link_sosial_media,'lihat') == 'true')
        {
            $data['link_sosial_media']          = $link_sosial_media;
            $url_sekarang                       = $request->fullUrl();
            $hasil_kata                         = $request->cari_kata;
            $data['hasil_kata']                 = $hasil_kata;
            $data['lihat_sosial_medias']        = \App\Models\Master_sosial_media::where('nama_sosial_medias', 'LIKE', '%'.$hasil_kata.'%')
                                                                                ->get();
            session(['halaman'              => $url_sekarang]);
            session(['hasil_kata'		    => $hasil_kata]);
            return view('dashboard.sosial_media.lihat', $data);
        }
        else
            return redirect('dashboard/sosial_media');
    }

    public function tambah()
    {
        $link_sosial_media = 'sosial_media';
        if(Yeah::hakAkses($link_sosial_media,'tambah') == 'true')
        {
            $data['tambah_list_sosial_medias']  = Yeah::sosialMedia();
            return view('dashboard.sosial_media.tambah',$data);
        }
        else
            return redirect('dashboard/sosial_media');
    }

    public function prosestambah(Request $request)
    {
        $link_sosial_media = 'sosial_media';
        if(Yeah::hakAkses($link_sosial_media,'tambah') == 'true')
        {
            $aturan = [
                'sosial_medias'                     => 'required',
                'url_sosial_medias'                 => 'required',
            ];
            $error_pesan = [
                'sosial_medias.required'            => 'Form Sosial Media Harus Diisi.',
                'url_sosial_medias.required'        => 'Form Url Harus Diisi.',
            ];
            $this->validate($request, $aturan, $error_pesan);

            $ambil_sosial_media = $request->sosial_medias;
            $pisah_sosial_media = explode('_',$ambil_sosial_media);

            $data = [
                'id_sosial_medias'      	=> Yeah::autoIncrementKey('master_sosial_medias','id_sosial_medias'),
                'nama_sosial_medias'        => $pisah_sosial_media[1],
                'url_sosial_medias'         => $request->url_sosial_medias,
                'icon_sosial_medias'        => $pisah_sosial_media[0],
                'created_at'                => date('Y-m-d H:i:s'),
                'updated_at'                => date('Y-m-d H:i:s'),
            ];
            \App\Models\Master_sosial_media::insert($data);

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
                    $redirect_halaman  = 'dashboard/sosial_media';

                return redirect($redirect_halaman);
            }
        }
        else
            return redirect('dashboard/sosial_media');
    }

    public function edit($id_sosial_medias=0)
    {
        $link_sosial_media = 'sosial_media';
        if(Yeah::hakAkses($link_sosial_media,'edit') == 'true')
        {
            if (!is_numeric($id_sosial_medias))
                $id_sosial_medias = 0;
            $cek_sosial_medias = \App\Models\Master_sosial_media::where('id_sosial_medias',$id_sosial_medias)->count();
            if($cek_sosial_medias != 0)
            {
                $data['edit_list_sosial_medias']    = Yeah::sosialMedia();
                $data['edit_sosial_medias']         = \App\Models\Master_sosial_media::where('id_sosial_medias',$id_sosial_medias)
                                                                      ->first();
                return view('dashboard.sosial_media.edit',$data);
            }
            else
                return redirect('dashboard/sosial_media');
        }
        else
            return redirect('dashboard/sosial_media');
    }

    public function prosesedit($id_sosial_medias=0, Request $request)
    {
        $link_sosial_media = 'sosial_media';
        if(Yeah::hakAkses($link_sosial_media,'edit') == 'true')
        {
            if (!is_numeric($id_sosial_medias))
                $id_sosial_medias = 0;
            $cek_sosial_medias = \App\Models\Master_sosial_media::where('id_sosial_medias',$id_sosial_medias)->first();
            if(!empty($cek_sosial_medias))
            {
                $aturan = [
                    'sosial_medias'                     => 'required',
                    'url_sosial_medias'                 => 'required',
                ];
                $error_pesan = [
                    'sosial_medias.required'            => 'Form Sosial Media Harus Diisi.',
                    'url_sosial_medias.required'        => 'Form Url Harus Diisi.',
                ];
                $this->validate($request, $aturan, $error_pesan);

                $ambil_sosial_media = $request->sosial_medias;
            	$pisah_sosial_media = explode('_',$ambil_sosial_media);

                $data = [
		        	'icon_sosial_medias'	=> $pisah_sosial_media[0],
		        	'nama_sosial_medias'	=> $pisah_sosial_media[1],
                    'updated_at'            => date('Y-m-d H:i:s')
                ];
                \App\Models\Master_sosial_media::where('id_sosial_medias', $id_sosial_medias)
                                        ->update($data);

                if(request()->session()->get('halaman') != '')
                    $redirect_halaman    = request()->session()->get('halaman');
                else
                    $redirect_halaman  = 'dashboard/sosial_media';
                
                return redirect($redirect_halaman);
            }
            else
                return redirect('dashboard/sosial_media');
        }
        else
            return redirect('dashboard/sosial_media');
    }

    public function hapus($id_sosial_medias=0)
    {
        $link_sosial_media = 'sosial_media';
        if(Yeah::hakAkses($link_sosial_media,'hapus') == 'true')
        {
            if (!is_numeric($id_sosial_medias))
                $id_sosial_medias = 0;
            $cek_sosial_medias = \App\Models\Master_sosial_media::where('id_sosial_medias',$id_sosial_medias)->first();
            if(!empty($cek_sosial_medias))
            {
                \App\Models\Master_sosial_media::where('id_sosial_medias',$id_sosial_medias)
                                                ->delete();
                return response()->json(["sukses" => "sukses"], 200);
            }
            else
                return redirect('dashboard/sosial_media');
        }
        else
            return redirect('dashboard/sosial_media');
    }

}