<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Yeah;
use Auth;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class MetaTagController extends Controller
{
    public function index()
    {
        $link_meta_tag = 'meta_tag';
        if(Yeah::hakAkses($link_meta_tag, 'lihat') == 'true')
        {
            $data['lihat_meta_tags']       = \App\Models\Master_meta_tag::get();
            session()->forget('halaman');
            return view('dashboard.meta_tag.lihat', $data);
        }
        else
            return redirect('dashboard');
    }

    public function prosesedit($id_meta_tags=0, Request $request)
    {
        $link_meta_tag = 'meta_tag';
        if (Yeah::hakAkses($link_meta_tag, 'lihat') == 'true')
        {
            $aturan = [
                'nama_meta_tags.*'                => 'required',
                'konten_meta_tags.*'              => 'required',
            ];
            $error_pesan = [
                'nama_meta_tags.*.required'       => 'Form Email Harus Diisi.',
                'konten_meta_tas.*.required'      => 'Form Konten Harus Diisi.',
            ];
            $this->validate($request, $aturan, $error_pesan);
            $meta_tag_data = [
                'nama_meta_tags'    => $request->nama_meta_tags[$id_meta_tags],
                'konten_meta_tags'  => $request->konten_meta_tags[$id_meta_tags],
                'updated_at'        => date('Y-m-d H:i:s'),
            ];
            \App\Models\Master_meta_tag::where('id_meta_tags',$id_meta_tags)->update($meta_tag_data);

            $setelah_simpan = [
                'alert'                     => 'sukses',
                'text'                      => 'Data berhasil diperbarui',
            ];
            return redirect()->back()->with('setelah_simpan'.$id_meta_tags, $setelah_simpan);
        }
        else
            return redirect('dashboard');
    }
}