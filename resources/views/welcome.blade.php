@php($ambil_konfigurasi_aplikasis = \App\Models\Master_konfigurasi_aplikasi::first())
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="{{$ambil_konfigurasi_aplikasis->deskripsi_konfigurasi_aplikasis}}">
	    <meta name="author" content="{{$ambil_konfigurasi_aplikasis->nama_konfigurasi_aplikasis}}">
	    <meta name="keyword" content="{{$ambil_konfigurasi_aplikasis->keywords_konfigurasi_aplikasis}}">
        <title>{{$ambil_konfigurasi_aplikasis->nama_konfigurasi_aplikasis}}</title>
        <meta name="_token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="{{URL::asset($ambil_konfigurasi_aplikasis->icon_konfigurasi_aplikasis)}}" sizes="any" />

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <script src="{{URL::asset('public/template/back/vendors/jquery/js/jquery.min.js')}}"></script>

        <!-- Styles -->
        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--bg-opacity:1;background-color:#fff;background-color:rgba(255,255,255,var(--bg-opacity))}.bg-gray-100{--bg-opacity:1;background-color:#f7fafc;background-color:rgba(247,250,252,var(--bg-opacity))}.border-gray-200{--border-opacity:1;border-color:#edf2f7;border-color:rgba(237,242,247,var(--border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{box-shadow:0 1px 3px 0 rgba(0,0,0,.1),0 1px 2px 0 rgba(0,0,0,.06)}.text-center{text-align:center}.text-gray-200{--text-opacity:1;color:#edf2f7;color:rgba(237,242,247,var(--text-opacity))}.text-gray-300{--text-opacity:1;color:#e2e8f0;color:rgba(226,232,240,var(--text-opacity))}.text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.text-gray-500{--text-opacity:1;color:#a0aec0;color:rgba(160,174,192,var(--text-opacity))}.text-gray-600{--text-opacity:1;color:#718096;color:rgba(113,128,150,var(--text-opacity))}.text-gray-700{--text-opacity:1;color:#4a5568;color:rgba(74,85,104,var(--text-opacity))}.text-gray-900{--text-opacity:1;color:#1a202c;color:rgba(26,32,44,var(--text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--bg-opacity:1;background-color:#2d3748;background-color:rgba(45,55,72,var(--bg-opacity))}.dark\:bg-gray-900{--bg-opacity:1;background-color:#1a202c;background-color:rgba(26,32,44,var(--bg-opacity))}.dark\:border-gray-700{--border-opacity:1;border-color:#4a5568;border-color:rgba(74,85,104,var(--border-opacity))}.dark\:text-white{--text-opacity:1;color:#fff;color:rgba(255,255,255,var(--text-opacity))}.dark\:text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.dark\:text-gray-500{--tw-text-opacity:1;color:#6b7280;color:rgba(107,114,128,var(--tw-text-opacity))}}
        </style>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
            /* -- usable codes start -- */

            html,
            body,
            div,
            span,
            object,
            iframe,
            h1,
            h2,
            h3,
            h4,
            h5,
            h6,
            p,
            blockquote,
            pre,
            a,
            abbr,
            acronym,
            address,
            code,
            del,
            dfn,
            em,
            img,
            q,
            dl,
            dt,
            dd,
            ol,
            ul,
            li,
            fieldset,
            form,
            label,
            legend,
            table,
            caption,
            tbody,
            tfoot,
            thead,
            tr,
            th,
            td,
            article,
            aside,
            dialog,
            figure,
            footer,
            header,
            hgroup,
            nav,
            section {
                margin: 0;
                padding: 0;
                border: 0;
                font-weight: inherit;
                font-style: inherit;
                font-size: 100%;
                font-family: inherit;
                vertical-align: baseline;
                text-decoration: none;
                list-style: none;
            }
            img {
                width: 100%
            }
            .anim04c {
                -webkit-transition: all .4s cubic-bezier(.5, .35, .15, 1.4);
                transition: all .4s cubic-bezier(.5, .35, .15, 1.4);
            }

            html,
            body {
                width: 100%;
                height: 100%;
                font-family: 'Source Sans Pro', sans-serif;
                background: #eee;
                color: #666;
            }
            body {
                overflow-x: hidden;
                overflow-y: auto;
            }
            /*-----*/

            .outer {
                position: relative;
                top: 50%;
                z-index: 1;
                -webkit-transform: translateY(-50%);
                -moz-transform: translateY(-50%);
                -ms-transform: translateY(-50%);
                -o-transform: translateY(-50%);
                transform: translateY(-50%);
                cursor: pointer;
            }
            /*-----*/

            .signboard {
                width: 100px;
                height: 100px;
                margin: auto;
                color: #fff;
                border-radius: 10px;
            }
            /*-----*/

            .front {
                position: absolute;
                top: 0;
                left: 0;
                z-index: 3;
                background: #ff726b;
                text-align: center;
            }
            .right {
                position: absolute;
                right: : 0;
                z-index: 2;
                -webkit-transform: rotate(-10deg) translate(7px, 8px);
                -moz-transform: rotate(-10deg) translate(7px, 8px);
                -ms-transform: rotate(-10deg) translate(7px, 8px);
                -o-transform: rotate(-10deg) translate(7px, 8px);
                transform: rotate(-10deg) translate(7px, 8px);
                background: #EFC94C;
            }
            .left {
                position: absolute;
                left: 0;
                z-index: 1;
                -webkit-transform: rotate(5deg) translate(-4px, 4px);
                -moz-transform: rotate(5deg) translate(-4px, 4px);
                -ms-transform: rotate(5deg) translate(-4px, 4px);
                -o-transform: rotate(5deg) translate(-4px, 4px);
                transform: rotate(5deg) translate(-4px, 4px);
                background: #3498DB;
            }
            /*-----*/

            .outer:hover .inner {
                -webkit-transform: rotate(0) translate(0);
                -moz-transform: rotate(0) translate(0);
                -ms-transform: rotate(0) translate(0);
                -o-transform: rotate(0) translate(0);
                transform: rotate(0) translate(0);
            }
            /*-----*/

            .outer:active .inner {
                -webkit-transform: rotate(0) translate(0) scale(0.9);
                -moz-transform: rotate(0) translate(0) scale(0.9);
                -ms-transform: rotate(0) translate(0) scale(0.9);
                -o-transform: rotate(0) translate(0) scale(0.9);
                transform: rotate(0) translate(0) scale(0.9);
            }
            .outer:active .front .date {
                -webkit-transform: scale(2);
            }
            .outer:active .front .day,
            .outer:active .front .month {
                visibility: hidden;
                opacity: 0;
                -webkit-transform: scale(0);
                -moz-transform: scale(0);
                -ms-transform: scale(0);
                -o-transform: scale(0);
                transform: scale(0);
            }
            .outer:active .right {
                -webkit-transform: rotate(-5deg) translateX(80px) scale(0.9);
                -moz-transform: rotate(-5deg) translateX(80px) scale(0.9);
                -ms-transform: rotate(-5deg) translateX(80px) scale(0.9);
                -o-transform: rotate(-5deg) translateX(80px) scale(0.9);
                transform: rotate(-5deg) translateX(80px) scale(0.9);
            }
            .outer:active .left {
                -webkit-transform: rotate(5deg) translateX(-80px) scale(0.9);
                -moz-transform: rotate(5deg) translateX(-80px) scale(0.9);
                -ms-transform: rotate(5deg) translateX(-80px) scale(0.9);
                -o-transform: rotate(5deg) translateX(-80px) scale(0.9);
                transform: rotate(5deg) translateX(-80px) scale(0.9);
            }
            /*-----*/

            .outer:active .calendarMain {
                -webkit-transform: scale(1.8);
                opacity: 0;
                visibility: hidden;
            }
            .outer:active .clock {
                -webkit-transform: scale(1.4);
                opacity: 1;
                visibility: visible;
            }
            .outer:active .calendarNormal {
                bottom: -30px;
                opacity: 1;
                visibility: visible;
            }
            .outer:active .year {
                top: -30px;
                opacity: 1;
                visibility: visible;
                letter-spacing: 3px;
            }
            /*-----*/

            .calendarMain {
                width: 100%;
                height: 100%;
                position: absolute;
                opacity: 1;
            }
            .month,
            .day {
                font-size: 10px;
                line-height: 30px;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 3px;
            }
            .date {
                font-size: 40px;
                line-height: 40px;
                font-weight: 300;
                text-transform: uppercase;
                letter-spacing: 3px;
            }
            /*-----*/

            .clock {
                width: 100%;
                height: 100%;
                position: absolute;
                font-size: 40px;
                line-height: 100px;
                font-weight: 300;
                text-transform: uppercase;
                letter-spacing: 3px;
                text-align: center;
                opacity: 0;
                visibility: hidden;
            }
            /*-----*/

            .year {
                width: 100%;
                position: absolute;
                top: 0;
                font-size: 14px;
                line-height: 30px;
                font-weight: 300;
                text-transform: uppercase;
                letter-spacing: 0;
                text-align: center;
                opacity: 0;
                visibility: hidden;
                color: #ff726b;
            }
            .calendarNormal {
                width: 100%;
                position: absolute;
                bottom: 0;
                font-size: 14px;
                line-height: 30px;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 3px;
                text-align: center;
                opacity: 0;
                visibility: hidden;
            }
            .date2 {
                color: #ff726b;
            }
            .day2 {
                color: #3498DB;
            }
            .month2 {
                color: #EFC94C;
            }
            /* -- usable codes end -- */

            /* -- unusable codes (text, logo, etc.) -- */

            .info {
                width: 100%;
                height: 25%;
                position: absolute;
                top: 15%;
                text-align: center;
                opacity: 0;
            }
            .info li {
                width: 100%;
            }
            .hover,
            .click,
            .yeaa {
                font-size: 14px;
                line-height: 25px;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 2px;
                text-align: center;
                bottom: 0;
                opacity: 1;
            }
            .dribbble {
                position: absolute;
                top: -60px;
                font-size: 14px;
                opacity: 0;
            }
            em {
                color: #ed4988;
            }
            .designer {
                width: 100%;
                height: 50%;
                position: absolute;
                bottom: 0;
                text-align: center;
                opacity: 0;
            }
            .designer li {
                width: 100%;
                position: absolute;
                bottom: 30%;
            }
            .designer a {
                width: 30px;
                height: 30px;
                display: block;
                position: relative;
                border-radius: 100%;
                margin: auto;
                color: rgba(46, 204, 113, 0.55);
            }
            .designer a:after {
                content: "see designs";
                position: absolute;
                top: 0;
                left: 40px;
                font-size: 14px;
                line-height: 33px;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 2px;
                white-space: nowrap;
            }
            .designer a:hover:after {
                color: #2ecc71;
            }
            .designer img {
                display: block;
                border-radius: 100%;
            }
            body:hover .info,
            body:hover .designer {
                opacity: 1;
            }
            ::selection {
                background: transparent;
            }
            ::-moz-selection {
                background: transparent;
            }
            h1 {
                margin: 0;
                padding-bottom: 6rem;
                grid-column: 1;
                grid-row: 1;
                z-index: 1;
                font-family: 'Teko', sans-serif;
                font-size: 3rem;
                text-transform: uppercase;
                animation: glow 2s ease-in-out infinite alternate;
                text-align: center;
                color:#ed1651
            }
            a {
                font-family: 'Teko', sans-serif;
                color: #4db1bc;
                grid-column: 1;
                grid-row: 1;
                align-self: end;
                justify-self: center;
                padding-bottom: 1rem;
            }
            
            @keyframes glow {
                from {
                text-shadow: 0 0 20px #f67298;
                }
                to {
                text-shadow: 0 0 30px #f55b87, 0 0 10px #f55b87;
                }
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            <div class="row">
                <div class="col-sm-12">
                    <!-- main codes start -->
                        <div class="signboard outer">
                            <div class="signboard front inner anim04c">
                                <li class="year anim04c">
                                    <span></span>
                                </li>
                                <ul class="calendarMain anim04c">
                                    <li class="month anim04c">
                                        <span></span>
                                    </li>
                                    <li class="date anim04c">
                                        <span></span>
                                    </li>
                                    <li class="day anim04c">
                                        <span></span>
                                    </li>
                                </ul>
                                <li class="clock minute anim04c">
                                    <span></span>
                                </li>
                                <li class="calendarNormal date2 anim04c">
                                    <span></span>
                                </li>
                            </div>
                            <div class="signboard left inner anim04c">
                                <li class="clock hour anim04c">
                                    <span></span>
                                </li>
                                <li class="calendarNormal day2 anim04c">
                                    <span></span>
                                </li>
                            </div>
                            <div class="signboard right inner anim04c">
                                <li class="clock second anim04c">
                                    <span></span>
                                </li>
                                <li class="calendarNormal month2 anim04c">
                                    <span></span>
                                </li>
                            </div>
                        </div>
                        <!-- main codes end -->
                </div>
                <div class="col-sm-12">
                    <a href="{{ route('login') }}" class="textlogin">
                        <h1>
                            <span class='one'>L</span>
                            <span class='two'>O</span>
                            <span class='three'>G</span>
                            <span class='four'>I</span>
                            <span class='five'>N</span>
                        </h1>
                    </a>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                var monthNames = [ "Januariy", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember" ]; 
                var dayNames= [ "Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu" ];
                var newDate = new Date();
                newDate.setDate(newDate.getDate());
                setInterval( function() {
                    var hours = new Date().getHours();
                    $(".hour").html(( hours < 10 ? "0" : "" ) + hours);
                    var seconds = new Date().getSeconds();
                    $(".second").html(( seconds < 10 ? "0" : "" ) + seconds);
                    var minutes = new Date().getMinutes();
                    $(".minute").html(( minutes < 10 ? "0" : "" ) + minutes);
                    
                    $(".month span,.month2 span").text(monthNames[newDate.getMonth()]);
                    $(".date span,.date2 span").text(newDate.getDate());
                    $(".day span,.day2 span").text(dayNames[newDate.getDay()]);
                    $(".year span").html(newDate.getFullYear());
                }, 1000);	
                $(".outer").on({
                    mousedown:function(){
                        $(".dribbble").css("opacity","1");
                    },
                    mouseup:function(){
                        $(".dribbble").css("opacity","0");
                    }
                });
            });
        </script>
    </body>
</html>
