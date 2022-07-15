@php($ambil_konfigurasi_aplikasis = \App\Models\Master_konfigurasi_aplikasi::first())
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="{{$ambil_konfigurasi_aplikasis->deskripsi_konfigurasi_aplikasis}}">
        <meta name="author" content="{{$ambil_konfigurasi_aplikasis->nama_konfigurasi_aplikasis}}">
        <meta name="keyword" content="{{$ambil_konfigurasi_aplikasis->keywords_konfigurasi_aplikasis}}">

	    <title>{{$ambil_konfigurasi_aplikasis->nama_konfigurasi_aplikasis}}</title>
        <link rel="icon" type="image/png" href="{{URL::asset($ambil_konfigurasi_aplikasis->icon_konfigurasi_aplikasis)}}" sizes="any" />

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ URL::asset('public/css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ URL::asset('public/js/app.js') }}" defer></script>
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>
    </body>
</html>
