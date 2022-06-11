<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Yeah;
use Auth;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class KonfigurasiAplikasiController extends Controller
{
    public function index()
    {
        $link_konfigurasi_aplikasi = 'konfigurasi_aplikasi';
        if(Yeah::hakAkses($link_konfigurasi_aplikasi, 'lihat') == 'true')
        {
            $data['lihat_konfigurasi_aplikasis']       = \App\Models\Master_konfigurasi_aplikasi::first();
            session()->forget('halaman');
            return view('dashboard.konfigurasi_aplikasi.lihat', $data);
        }
        else
            return redirect('dashboard');
    }

    public function prosesedit(Request $request)
    {
        $link_konfigurasi_aplikasi = 'konfigurasi_aplikasi';
        if (Yeah::hakAkses($link_konfigurasi_aplikasi, 'lihat') == 'true')
        {
            $aturan = [
                'nama_konfigurasi_aplikasis'                => 'required',
                'deskripsi_konfigurasi_aplikasis'           => 'required',
                'keywords_konfigurasi_aplikasis'            => 'required',
            ];
            $error_pesan = [
                'nama_konfigurasi_aplikasis.required'       => 'Form Email Harus Diisi.',
                'deskripsi_konfigurasi_aplikasis.required'  => 'Form Deskripsi Harus Diisi.',
                'keywords_konfigurasi_aplikasis.required'   => 'Form Keywords Harus Diisi.',
            ];
            $this->validate($request, $aturan, $error_pesan);

            $konfigurasi_aplikasi_data = [
                'nama_konfigurasi_aplikasis'                    => $request->nama_konfigurasi_aplikasis,
                'deskripsi_konfigurasi_aplikasis'               => $request->deskripsi_konfigurasi_aplikasis,
                'keywords_konfigurasi_aplikasis'                => $request->keywords_konfigurasi_aplikasis,
                'updated_at'                                    => date('Y-m-d H:i:s'),
            ];
            \App\Models\Master_konfigurasi_aplikasi::query()->update($konfigurasi_aplikasi_data);

            $setelah_simpan = [
                'alert'                     => 'sukses',
                'text'                      => 'Data berhasil diperbarui',
            ];
            return redirect()->back()->with('setelah_simpan', $setelah_simpan);
        }
        else
            return redirect('dashboard');
    }

    public function proseseditlogo(Request $request)
    {
        $link_konfigurasi_aplikasi = 'konfigurasi_aplikasi';
        if(Yeah::hakAkses($link_konfigurasi_aplikasi, 'lihat') == 'true')
        {
            $aturan = [
                'userfile_logo'     => 'required|mimes:png,jpg,jpeg,svg',
            ];
            $error_pesan = [
                'userfile_logo.required'   => 'Form Logo Harus Diisi.',
            ];
            $this->validate($request, $aturan, $error_pesan);

            $ambil_konfigurasi_aplikasis = \App\Models\Master_konfigurasi_aplikasi::first();

            $foto_logo_lama        = $ambil_konfigurasi_aplikasis->logo_konfigurasi_aplikasis;
            if (file_exists($foto_logo_lama))
                unlink($foto_logo_lama);

            $nama_logo = date('Ymd').date('His').str_replace(')','',str_replace('(','',str_replace(' ','-',$request->file('userfile_logo')->getClientOriginalName())));
            $path_logo = './public/uploads/logo/';
            $request->file('userfile_logo')->move(
                base_path() . '/public/uploads/logo/', $nama_logo
            );

            $data = [
                'logo_konfigurasi_aplikasis'    => $path_logo.$nama_logo,
                'updated_at'                    => date('Y-m-d H:i:s'),
            ];

            \App\Models\Master_konfigurasi_aplikasi::query()->update($data);

            $setelah_simpan_logo = [
                'alert'                     => 'sukses',
                'text'                      => 'Logo berhasil diperbarui',
            ];
            return redirect()->back()->with('setelah_simpan_logo', $setelah_simpan_logo);
        }
        else
            return redirect('dashboard');
    }

    public function prosesediticon(Request $request)
    {
        $link_konfigurasi_aplikasi = 'konfigurasi_aplikasi';
        if(Yeah::hakAkses($link_konfigurasi_aplikasi, 'lihat') == 'true')
        {
            $aturan = [
                'userfile_icon'             => 'required|mimes:png,jpg,jpeg,svg',
            ];
            $error_pesan = [
                'userfile_icon.required'    => 'Form Icon Harus Diisi.',
            ];
            $this->validate($request, $aturan, $error_pesan);

            $foto_icon_lama        = $ambil_konfigurasi_aplikasis->icon_konfigurasi_aplikasis;
            if (file_exists($foto_icon_lama))
                unlink($foto_icon_lama);

            $nama_icon = date('Ymd').date('His').str_replace(')','',str_replace('(','',str_replace(' ','-',$request->file('userfile_icon')->getClientOriginalName())));
            $path_icon = './public/uploads/logo/';
            $request->file('userfile_icon')->move(
                base_path() . '/public/uploads/logo/', $nama_icon
            );

            $data = [
                'icon_konfigurasi_aplikasis'    => $path_icon.$nama_icon,
                'updated_at'                    => date('Y-m-d H:i:s'),
            ];

            \App\Models\Master_konfigurasi_aplikasi::query()->update($data);

            $setelah_simpan_icon = [
                'alert'                     => 'sukses',
                'text'                      => 'Icon berhasil diperbarui',
            ];
            return redirect()->back()->with('setelah_simpan_icon', $setelah_simpan_icon);
        }
        else
            return redirect('dashboard');
    }

    public function proseseditlogotext(Request $request)
    {
        $link_konfigurasi_aplikasi = 'konfigurasi_aplikasi';
        if(Yeah::hakAkses($link_konfigurasi_aplikasi, 'lihat') == 'true')
        {
            $aturan = [
                'userfile_logo_text'            => 'required|mimes:png,jpg,jpeg,svg',
            ];
            $error_pesan = [
                'userfile_logo_text.required'   => 'Form Logo Text Harus Diisi.',
            ];
            $this->validate($request, $aturan, $error_pesan);

            $foto_logo_text_lama        = $ambil_konfigurasi_aplikasis->logo_text_konfigurasi_aplikasis;
            if (file_exists($foto_logo_text_lama))
                unlink($foto_logo_text_lama);

            $nama_logo_text = date('Ymd').date('His').str_replace(')','',str_replace('(','',str_replace(' ','-',$request->file('userfile_logo_text')->getClientOriginalName())));
            $path_logo_text = './public/uploads/logo/';
            $request->file('userfile_logo_text')->move(
                base_path() . '/public/uploads/logo/', $nama_logo_text
            );

            $data = [
                'logo_text_konfigurasi_aplikasis'   => $path_logo_text.$nama_logo_text,
                'updated_at'                        => date('Y-m-d H:i:s'),
            ];

            \App\Models\Master_konfigurasi_aplikasi::query()->update($data);

            $setelah_simpan_logo_text = [
                'alert'                     => 'sukses',
                'text'                      => 'Logo Text berhasil diperbarui',
            ];
            return redirect()->back()->with('setelah_simpan_logo_text', $setelah_simpan_logo_text);
        }
        else
            return redirect('dashboard');
    }
}