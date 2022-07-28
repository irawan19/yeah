@php($lihat_konfigurasi_aplikasis 	= \App\Models\Master_konfigurasi_aplikasi::first())
@php($ambil_level_sistems 			= \App\Models\Master_level_sistem::where('id_level_sistems',Auth::user()->level_sistems_id)
																	->first())
@php($tanggal_sekarang				= date('Y-m-d'))
<button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
	<svg class="c-icon c-icon-lg">
		<use xlink:href="{{URL::asset('public/template/back/vendors/@coreui/icons/svg/free.svg#cil-menu')}}"></use>
	</svg>
</button>
<a class="c-header-brand d-lg-none c-header-brand-sm-up-center" href="#">
	<img class="c-header-brand-minimized c-d-dark-none" src="{{URL::asset($lihat_konfigurasi_aplikasis->logo_text_konfigurasi_aplikasis)}}" width="46" alt="{{$lihat_konfigurasi_aplikasis->nama_konfigurasi_aplikasis}}">
</a>
<b class="jam">{{Yeah::ubahDBKeTanggal($tanggal_sekarang)}}, <onload="timeJavascript()" id="output"></b>
<ul class="c-header-nav ml-auto"></ul>
<ul class="c-header-nav">
	<li class="c-header-nav-item dropdown d-md-down-none mx-2"><a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
   		@php($registrasi_hari_ini 				= \App\Models\Registrasi_event_detail::join('registrasi_events','registrasi_events_id','=','registrasi_events.id_registrasi_events')
                                                                                        ->join('master_tickets','tickets_id','=','master_tickets.id_tickets')
                                                                                        ->join('master_events','events_id','=','master_events.id_events')
                                                                                        ->where('status_hapus_events',0)
                                                                                        ->where('status_hapus_tickets',0)
																						->whereRaw("date(registrasi_event_details.created_at) = '".date('Y-m-d')."'"))
		@php($total_notifikasi 					= $registrasi_hari_ini->count())
   		<svg class="c-icon">
   		  	<use xlink:href="{{URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-bell')}}"></use>
   		</svg><span class="badge badge-pill badge-success">{{$total_notifikasi}}</span></a>
   		<div class="dropdown-menu dropdown-menu-right dropdown-menu-lg pt-0" style="width:250px">
   			<div class="dropdown-header bg-light">
   				<strong>Ada {{$total_notifikasi}} Notifikasi</strong>
   			</div>
			@foreach($registrasi_hari_ini->get() as $registrasi_hari_ini)
				<a class="dropdown-item" href="{{URL('dashboard/registrasi_event')}}">
					<svg class="c-icon mr-2 text-success">
						<use xlink:href="{{URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-user')}}"></use>
					</svg> {{$registrasi_hari_ini->no_registrasi_events.' - '.$registrasi_hari_ini->nama_registrasi_event_details}}
				</a>
			@endforeach
   		</div>
    </li>
	<li class="c-header-nav-item dropdown mr-3">
		<a class="c-header-nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
	    	<div class="c-avatar">
	    		@if(Auth::user()->profile_photo_path == null)
		    		<img class="c-avatar-img" src="{{ Auth::user()->profile_photo_url }}" alt="{{Auth::user()->email}}">
		    	@else
		    		<img class="c-avatar-img" src="{{ URL::asset(Auth::user()->profile_photo_path) }}" alt="{{Auth::user()->email}}">
		    	@endif
	    	</div>&nbsp;&nbsp;<b class="namalogin">{{Auth::user()->name}}</b>
	  	</a>
		<div class="dropdown-menu dropdown-menu-right pt-0">
		  	<div class="dropdown-header py-2" style="background-color: #f7d20c; color: #fff">
		  		<strong>{{$ambil_level_sistems->nama_level_sistems}}</strong>
		  	</div>
		  	<div class="dropdown-header py-2" style="background-color: #edc20f; color: #fff">
		  		<strong>
			  		{{$lihat_konfigurasi_aplikasis->nama_konfigurasi_aplikasis}}
		  		</strong>
		  	</div>
		  	<div class="dropdown-header bg-light py-2">
		  		<strong>Konfigurasi</strong>
		  	</div>
		  	<a class="dropdown-item" href="{{URL('dashboard/konfigurasi_profil')}}">
		  	    <svg class="c-icon mr-2">
		  	      <use xlink:href="{{URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-child')}}"></use>
		  	    </svg> Profil
		  	</a>
		  	<a class="dropdown-item" href="{{URL('dashboard/konfigurasi_akun')}}">
		  	    <svg class="c-icon mr-2">
		  	      <use xlink:href="{{URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-contact')}}"></use>
		  	    </svg> Akun
		  	</a>
		  	<div class="dropdown-divider"></div>
			<a class="dropdown-item" href="{{URL('dashboard/logout')}}">
			    <svg class="c-icon mr-2">
			      <use xlink:href="{{URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-task')}}"></use>
			    </svg> Logout
			</a>
		</div>
	</li>
</ul>
<script type="text/javascript">
	window.setTimeout("timeJavascript()",1000);
    function timeJavascript()
	{     
        var dateNow = new Date().toLocaleTimeString("en-US",{timeZone: "Asia/Jakarta", hour12: false});
        setTimeout("timeJavascript()",1000);
        document.getElementById("output").innerHTML = dateNow;
	}
</script>