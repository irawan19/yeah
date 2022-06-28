<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Yeah;
use DB;
use Auth;

class DashboardController extends Controller
{

    public function redirect()
    {
        return redirect('dashboard');
    }

    public function logout(Request $request)
    {
        $check_session = \App\Models\Session::where('user_id',Auth::user()->id)->count();
        if($check_session != 0)
            \App\Models\Session::where('user_id',Auth::user()->id)->delete();
        
        $users_data = [
          'remember_token'  => ''  
        ];
        \App\Models\User::where('id',Auth::user()->id)
                        ->update($users_data);
        
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('/login');
    }

    public function index()
    {
        $data['lihat_konfigurasi_aplikasis']        = \App\Models\Master_konfigurasi_aplikasi::first();
        $data['total_event']                        = \App\Models\Master_event::count();
        $data['total_ticket']                       = \App\Models\Master_ticket::count();
        $data['total_promo']                        = \App\Models\Master_promo::count();
        $data['total_registrasi']                   = \App\Models\Registrasi_event_detail::count();
        return view('dashboard.dashboard.lihat',$data);
    }

}