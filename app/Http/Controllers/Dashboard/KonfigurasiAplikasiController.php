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

            $id_konfigurasi_aplikasi        = 1;
            $client_cdn                     = new Client(['http_errors' => false]);
            $request_cdn                    = $client_cdn->request(
                                                                      'POST',
                                                                      Yeah::urlcdn().'api/v1/upload/logo',
                                                                      [
                                                                          'multipart' => [
                                                                              [
                                                                                  'name'          => 'id_konfigurasi_aplikasi',
                                                                                  'contents'      => $id_konfigurasi_aplikasi,
                                                                              ],
                                                                              [
                                                                                  'name'          => 'file_logo',
                                                                                  'filename'      => $request->file('userfile_logo')->getClientOriginalName(),
                                                                                  'Mime-Type'     => $request->file('userfile_logo')->getmimeType(),
                                                                                  'contents'      => fopen($request->file('userfile_logo')->path(), 'r'),
                                                                              ],
                                                                          ],
                                                                      ]
                                                                  );
            $data = [
                'updated_at'                 => date('Y-m-d H:i:s'),
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

            $id_konfigurasi_aplikasi        = 1;
            $client_cdn                     = new Client(['http_errors' => false]);
            $request_cdn                    = $client_cdn->request(
                                                                      'POST',
                                                                      Yeah::urlcdn().'api/v1/upload/icon',
                                                                      [
                                                                          'multipart' => [
                                                                              [
                                                                                  'name'          => 'id_konfigurasi_aplikasi',
                                                                                  'contents'      => $id_konfigurasi_aplikasi,
                                                                              ],
                                                                              [
                                                                                  'name'          => 'file_icon',
                                                                                  'filename'      => $request->file('userfile_icon')->getClientOriginalName(),
                                                                                  'Mime-Type'     => $request->file('userfile_icon')->getmimeType(),
                                                                                  'contents'      => fopen($request->file('userfile_icon')->path(), 'r'),
                                                                              ],
                                                                          ],
                                                                      ]
                                                                  );

            $data = [
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

            $id_konfigurasi_aplikasi        = 1;
            $client_cdn                     = new Client(['http_errors' => false]);
            $request_cdn                    = $client_cdn->request(
                                                                      'POST',
                                                                      Yeah::urlcdn().'api/v1/upload/logotext',
                                                                      [
                                                                          'multipart' => [
                                                                              [
                                                                                  'name'          => 'id_konfigurasi_aplikasi',
                                                                                  'contents'      => $id_konfigurasi_aplikasi,
                                                                              ],
                                                                              [
                                                                                  'name'          => 'file_icon',
                                                                                  'filename'      => $request->file('userfile_logo_text')->getClientOriginalName(),
                                                                                  'Mime-Type'     => $request->file('userfile_logo_text')->getmimeType(),
                                                                                  'contents'      => fopen($request->file('userfile_logo_text')->path(), 'r'),
                                                                              ],
                                                                          ],
                                                                      ]
                                                                  );

            $data = [
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