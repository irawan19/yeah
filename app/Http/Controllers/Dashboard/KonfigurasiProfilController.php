<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Yeah;
use Auth;

class KonfigurasiProfilController extends Controller
{
    public function index()
    {
    	$data['lihat_level_sistems']	= \App\Models\Master_level_sistem::where('id_level_sistems',Auth::user()->level_sistems_id)->first();
        session()->forget('halaman');
       	return view('dashboard.konfigurasi_profil.lihat',$data);
    }

    public function prosesedit(Request $request)
    {
    	$id_user  	= Auth::user()->id;
        $ambil_foto_admin = $request->userfile_foto_admin;
        if($ambil_foto_admin != '')
        {
            $aturan = [
                'userfile_foto_admin'       => 'required|mimes:png,jpg,jpeg,svg',
                'name'                      => 'required',
            ];
            $error_pesan = [
                'userfile_foto_admin.required'  => 'Form Foto Harus Diisi.',
                'name.required'                 => 'Form Nama Harus Diisi.',
            ];
            $this->validate($request, $aturan, $error_pesan);

           $data = [
                'name'                  => $request->name,
                'updated_at'            => date('Y-m-d H:i:s'),
            ];
        }
        else
        {
            $aturan = [
                'name'                  => 'required',
            ];
            $error_pesan = [
                'name.required'                 => 'Form Nama Harus Diisi.',
            ];
            $this->validate($request, $aturan, $error_pesan);

            $data = [
                'name' 			     	=> $request->name,
                'updated_at'	     	=> date('Y-m-d H:i:s'),
            ];
        }

        \App\Models\User::where('id',$id_user)->update($data);

        $setelah_simpan = [
            'alert'  => 'sukses',
            'text'   => 'Profil berhasil diperbarui',
        ];
        return redirect()->back()->with('setelah_simpan', $setelah_simpan);
    }
}