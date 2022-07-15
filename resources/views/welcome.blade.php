@php($ambil_konfigurasi_aplikasis = \App\Models\Master_konfigurasi_aplikasi::first())
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <meta name="description" content="{{$ambil_konfigurasi_aplikasis->deskripsi_konfigurasi_aplikasis}}">
        <meta name="author" content="{{$ambil_konfigurasi_aplikasis->nama_konfigurasi_aplikasis}}">
        <meta name="keyword" content="{{$ambil_konfigurasi_aplikasis->keywords_konfigurasi_aplikasis}}">
        <title>{{$ambil_konfigurasi_aplikasis->nama_konfigurasi_aplikasis}}</title>
        <link rel="icon" type="image/png" href="{{URL::asset($ambil_konfigurasi_aplikasis->icon_konfigurasi_aplikasis)}}" sizes="any" />
		<link rel="stylesheet" href="{{URL::asset('public/template/front/assets/css/main.css')}}" />
		<noscript><link rel="stylesheet" href="{{URL::asset('public/template/front/assets/css/noscript.css')}}" /></noscript>
	</head>
	<body class="is-preload">
		<div id="page-wrapper">
			<div id="wrapper">
			    <section class="panel banner right">
			    	<div class="content color0 span-3-75">
			    		<h1 class="major">Selamat Datang</h1>
			    		<p>Di Halaman <strong>YEAH</strong></p>
			    		<ul class="actions">
			    			<li><a href="#first" class="button primary color1 circle icon solid fa-angle-right">Next</a></li>
			    		</ul>
			    	</div>
			    	<div class="image filtered span-1-75" data-position="25% 25%">
			    		<img src="{{URL::asset('public/template/front/yeah.png')}}" alt="" />
			    	</div>
			    </section>

			    <section class="panel spotlight medium right" id="first">
			    	<div class="content">
			    		<h2 style="text-align:center">Yeah</h2>
			    		<p style="text-align:center">Datang untuk memasuki era sosial baru.<br/>
			    		    Saatnya untuk meningkatkan kehidupan sosial Anda, bergabunglah dengan kami untuk menjadi bagian dari hal besar berikutnya.
                            <br/>
                            <img src="{{URL::asset('public/template/front/app.png')}}" width="450px">
                        </p>
                        <div style="text-align:center">
                        <a href="https://yeah.biz.id" target="_blank" class="button primary color1 circle icon solid fa-gem"></a>
                            @php($ambil_sosial_medias = \App\Models\Master_sosial_media::get())
                            @if(!$ambil_sosial_medias->isEmpty())
                                @foreach($ambil_sosial_medias as $sosial_medias)
                                    <a href="{{$sosial_medias->url_sosial_medias}}" target="_blank" class="button primary color1 circle icon brands solid fa-{{$sosial_medias->icon_sosial_medias}}"></a>
                                @endforeach
                            @endif
                        </div>
			    	</div>
			    	<div class="image filtered tinted" data-position="top left">
			    		<img src="{{URL::asset('public/template/front/images/pic02.jpg')}}" alt="" />
			    	</div>
			    </section>

			    <section class="panel color1">
			    	<div class="intro joined">
			    		<h2 class="major">Dashboard</h2>
			    		<p>Dashboard untuk memonitoring dan mengkonfigurasi semua pengaturan website<br/>
                            <a href="{{URL('/login')}}" class="button primary color2">Login</a>
                        </p>
			    	</div>
			    	<div class="inner">
                        <img src="{{URL::asset('public/template/front/dashboard.png')}}" width="800px">
			    	</div>
			    </section>

			    <section class="panel spotlight large left">
			    	<div class="content span-5">
			    		<h2 class="major">API</h2>
			    		<p>Kami mempunyai API yang dapat diintegrasikan bersama<br/>
                            <a target="_blank" href="https://api.yeah.biz.id" class="button primary color2">API</a>
                        </p>
			    	</div>
			    	<div class="image filtered tinted" data-position="top right">
			    		<img src="{{URL::asset('public/template/front/images/pic03.jpg')}}" alt="" />
			    	</div>
			    	<div class="inner" style="margin-left:-150px">
                        <img src="{{URL::asset('public/template/front/api.png')}}" width="800px">
			    	</div>
			    </section>
			    <div class="copyright" style="color:black !important">{{date('Y')}} &copy; <a href="https://yeah.biz.id">{{$ambil_konfigurasi_aplikasis->nama_konfigurasi_aplikasis}}</a>.</div>
			</div>
		</div>

		<script src="{{URL::asset('public/template/front/assets/js/jquery.min.js')}}"></script>
		<script src="{{URL::asset('public/template/front/assets/js/browser.min.js')}}"></script>
		<script src="{{URL::asset('public/template/front/assets/js/breakpoints.min.js')}}"></script>
		<script src="{{URL::asset('public/template/front/assets/js/main.js')}}"></script>
	</body>
</html>