<?php

namespace App\Helpers;

use DB;
use Auth;
use Datetime;
use Request;
use URL;
use Str;

class Yeah
{
	//Hak Akses
		public static function hakAkses($link_menus = '', $nama_fiturs = '')
		{
			$id_user 				= Auth::user()->id;
			$query_cek_akses 		= \App\Models\Master_menu::join('master_fiturs','master_menus.id_menus','=','master_fiturs.menus_id')
		                                                        ->join('master_akses','master_fiturs.id_fiturs','=','master_akses.fiturs_id')
		                                                        ->join('master_level_sistems','master_akses.level_sistems_id','=','master_level_sistems.id_level_sistems')
		                                                        ->join('users','master_level_sistems.id_level_sistems','=','users.level_sistems_id')
																->where('users.id', $id_user)
																->where('master_menus.link_menus', $link_menus)
																->where('master_fiturs.nama_fiturs', $nama_fiturs)
																->groupBy('nama_menus')
			                                           			->groupBy('nama_menus','id_menus','id_fiturs','master_akses.id_akses','master_akses.level_sistems_id','master_akses.fiturs_id','master_level_sistems.id_level_sistems','users.id')
																->orderBy('order_menus')
																->count();

			$hasil = 'false';
			if ($query_cek_akses != 0)
				$hasil = 'true';

			return $hasil;
		}

		public static function totalHakAkses($link_akses = '')
		{
			$total_lihat 	= 0;
			$total_baca 	= 0;
			$total_edit 	= 0;
			$total_hapus 	= 0;
			if (Yeah::hakAkses($link_akses, 'lihat') == 'true')
				$total_lihat = 1;

			if (Yeah::hakAkses($link_akses, 'baca') == 'true')
				$total_baca = 1;

			if (Yeah::hakAkses($link_akses, 'edit') == 'true')
				$total_edit = 1;

			if (Yeah::hakAkses($link_akses, 'hapus') == 'true')
				$total_hapus = 1;

			return $total_lihat + $total_baca + $total_edit + $total_hapus;
		}
	//Hak Akses

	//Generate No Registrasi
	public static function noRegistrasi($id_tickets=0)
	{
		$ambil_tickets 				= \App\Models\Master_ticket::join('master_events','events_id','=','master_events.id_events')
																->where('id_tickets',$id_tickets)
																->first();
		if(!empty($ambil_tickets))
			$kode_tickets 	= $ambil_tickets->kode_tickets.$ambil_tickets->kode_events;
		else
			$kode_tickets 	= 'N/A';

		$ambil_registrasi_events 	= \App\Models\Registrasi_event::select('no_registrasi_events')
																	->whereRaw('MONTH(created_at) = "'.date('m').'"')
																	->whereRaw('YEAR(created_at) = "'.date('Y').'"')
																	->orderByRaw('CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(no_registrasi_events,"-",2),"-",-1) AS SIGNED) desc')
																	->first();
		if(!empty($ambil_registrasi_events))
		{
			$no_registrasi_events 				= $ambil_registrasi_events->no_registrasi_events;
			$explode_no 						= explode('-', $no_registrasi_events);
			if(!empty($explode_no[1]))
			{
				$no_registrasi_events_new 			= (int)$explode_no[1] + 1;
				$format_no_registrasi_events_new 	= sprintf('%04d', $no_registrasi_events_new);
				$format_registrasi_events_new 		= $kode_tickets.'-'.$format_no_registrasi_events_new.'-'.date('m').'-'.date('Y');
			}
			else
				$format_registrasi_events_new 	= $kode_tickets.'-0001-'.date('m').'-'.date('Y');
		}
		else
			$format_registrasi_events_new 	= $kode_tickets.'-0001-'.date('m').'-'.date('Y');

		return $format_registrasi_events_new;
	}
	//Generate No Registrasi

	//Auto Increment
		public static function autoIncrementKey($table='',$id='')
		{
			$autoincrement 		= DB::table($table)->max($id);
			$id_auto_increment 	= $autoincrement + 1;
			return $id_auto_increment;
		}
	//Auto Increment

	//Notifikasi
		public static function pesanErorForm($form_input='')
		{
			if($form_input != '')
				echo '<div class="errorform">'.$form_input.'</div>';
		}

		public static function pesanErorFormFile($form_input='')
		{
			if($form_input != '')
				echo '<div class="errorformfile">'.$form_input.'</div>';
		}

		public static function pesanSuksesForm($form_input='')
		{
			if($form_input != '')
				echo '<div class="alert alert-success" role="alert">'.$form_input.'</div>';
		}

		public static function pesanFlashErorForm($form_input = '')
		{
			if ($form_input != '')
				echo '<div class="alert alert-danger" role="alert">' . $form_input . '</div>';
		}

		public static function validForm($alert="")
		{
			if($alert != '')
				echo 'is-invalid';
		}
	//Notifikasi

	//Tombol
		public static function tambah($link_menus = '', $link = '')
		{
			if (Yeah::hakAkses($link_menus, 'tambah') == 'true') {
				echo 	'<a href="' . URL($link) . '" class="btn btn-sm btn-success">
								<svg class="c-icon" style="margin-right:5px;">
		                          	<use xlink:href="' . URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-plus') . '"></use>
		                        </svg> Tambah
							</a>';
			}
		}

		public static function downloadTemplate($link_menus = '', $link = '')
		{
			if (Yeah::hakAkses($link_menus, 'tambah') == 'true') {
				echo 	'<a href="' . URL($link) . '" class="btn btn-sm btn-success">
								<svg class="c-icon" style="margin-right:5px;">
		                          	<use xlink:href="' . URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-cloud-download') . '"></use>
		                        </svg> Download Template
							</a>';
			}
		}

		public static function aturAbsensi($link_menus = '', $link = '')
		{
			if (Yeah::hakAkses($link_menus, 'tambah') == 'true') {
				echo 	'<a href="' . URL($link) . '" class="btn btn-sm btn-secondary">
								<svg class="c-icon" style="margin-right:5px;">
		                          	<use xlink:href="' . URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-pencil') . '"></use>
		                        </svg> Atur Absensi
							</a>';
			}
		}

		public static function cetak($link_menus = '', $link = '')
		{
			if (Yeah::hakAkses($link_menus, 'cetak') == 'true') {
				echo 	'<a target="_blank" href="' . URL($link) . '" class="btn btn-sm btn-success">
								<svg class="c-icon" style="margin-right:5px;">
		                          	<use xlink:href="' . URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-print') . '"></use>
		                        </svg> Cetak
							</a>';
			}
		}

		public static function cetakexcel($link_menus = '', $link = '')
		{
			if (Yeah::hakAkses($link_menus, 'cetak') == 'true') {
				echo 	'<a href="' . URL($link) . '" class="btn btn-sm btn-success">
								<svg class="c-icon" style="margin-right:5px;">
		                          	<use xlink:href="' . URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-cloud-download') . '"></use>
		                        </svg> Cetak Excel
							</a>';
			}
		}

		public static function cetakButton($link_menus = '', $link = '')
		{
			if (Yeah::hakAkses($link_menus, 'cetak') == 'true') {
				echo 	'<a href="' . URL($link) . '" class="btn btn-sm btn-success">
								<svg class="c-icon" style="margin-right:5px;">
		                          	<use xlink:href="' . URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-print') . '"></use>
		                        </svg> Cetak
							</a>';
			}
		}

		public static function cetakButtonNonAktif($link_menus = '')
		{
			if (Yeah::hakAkses($link_menus, 'cetak') == 'true') {
				echo 	'<button class="btn btn-sm btn-success" disabled>
								<svg class="c-icon" style="margin-right:5px;">
		                          	<use xlink:href="' . URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-print') . '"></use>
		                        </svg> Cetak
							</button>';
			}
		}

		public static function cetakPDFButton($link_menus = '', $link = '')
		{
			if (Yeah::hakAkses($link_menus, 'cetak') == 'true') {
				echo 	'<a target="_blank" href="' . URL($link) . '" class="btn btn-sm btn-danger">
								<svg class="c-icon" style="margin-right:5px;">
		                          	<use xlink:href="' . URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-print') . '"></use>
		                        </svg> Cetak PDF
							</a>';
			}
		}

		public static function bacaButton($link_menus = '', $link = '')
		{
			if (Yeah::hakAkses($link_menus, 'baca') == 'true') {
				echo 	'<a href="' . URL($link) . '" class="btn btn-sm btn-warning">
								<svg class="c-icon" style="margin-right:5px;">
		                          	<use xlink:href="' . URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-folder-open') . '"></use>
		                        </svg> Baca
							</a>';
			}
		}

		public static function detailButton($link_menus = '', $link = '')
		{
			if (Yeah::hakAkses($link_menus, 'lihat') == 'true') {
				echo 	'<a href="' . URL($link) . '" class="btn btn-sm btn-warning">
								<svg class="c-icon" style="margin-right:5px;">
		                          	<use xlink:href="' . URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-folder-open') . '"></use>
		                        </svg> Detail
							</a>';
			}
		}

		public static function urutan($link_menus = '', $link = '')
		{
			if (Yeah::hakAkses($link_menus, 'lihat') == 'true') {
				echo 	'<a href="' . URL($link) . '" class="btn btn-sm btn-secondary">
								<svg class="c-icon" style="margin-right:5px;">
		                          	<use xlink:href="' . URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-list-numbered') . '"></use>
		                        </svg> Urutan
							</a>';
			}
		}

		public static function subMenu($link_menus = '', $link = '')
		{
			if (Yeah::hakAkses($link_menus, 'lihat') == 'true') {
				echo 	'<a class="dropdown-item" href="' . URL($link) . '" style="color:green">
								<svg class="c-icon" style="margin-right:5px;margin-top:-3px">
		                          	<use xlink:href="' . URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-menu') . '"></use>
		                        </svg> Sub Menu
							</a>';
			}
		}

		public static function baca($link_menus = '', $link = '')
		{
			if (Yeah::hakAkses($link_menus, 'baca') == 'true') {
				echo 	'<a class="dropdown-item" href="' . URL($link) . '" style="color:orange">
								<svg class="c-icon" style="margin-right:5px;margin-top:-3px">
		                          	<use xlink:href="' . URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-folder-open') . '"></use>
		                        </svg> Baca
							</a>';
			}
		}

		public static function edit($link_menus = '', $link = '')
		{
			if (Yeah::hakAkses($link_menus, 'edit') == 'true') {
				echo 	'<a class="dropdown-item" href="' . URL($link) . '" style="color:purple">
								<svg class="c-icon" style="margin-right:5px;margin-top:-3px">
		                          	<use xlink:href="' . URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-pencil') . '"></use>
		                        </svg> Edit
							</a>';
			}
		}

		public static function proses($link_menus = '', $link = '')
		{
			if (Yeah::hakAkses($link_menus, 'edit') == 'true') {
				echo 	'<a class="dropdown-item" href="' . URL($link) . '" style="color:green">
								<svg class="c-icon" style="margin-right:5px;margin-top:-3px">
		                          	<use xlink:href="' . URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-check') . '"></use>
		                        </svg> Proses
							</a>';
			};
		}

		public static function aktif($link_menus = '', $link = '')
		{
			if (Yeah::hakAkses($link_menus, 'edit') == 'true') {
				echo 	'<a href="' . URL($link) . '" class="btn btn-sm btn-success">
								<svg class="c-icon" style="margin-right:5px;">
		                          	<use xlink:href="' . URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-check') . '"></use>
		                        </svg> Aktif
							</a>';
			}
		}

		public static function nonaktif($link_menus = '', $link = '')
		{
			if (Yeah::hakAkses($link_menus, 'edit') == 'true') {
				echo 	'<a href="' . URL($link) . '" class="btn btn-sm btn-danger">
								<svg class="c-icon" style="margin-right:5px;">
		                          	<use xlink:href="' . URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-ban') . '"></use>
		                        </svg> Non Aktif
							</a>';
			}
		}

		public static function default($link_menus = '', $link = '')
		{
			if (Yeah::hakAkses($link_menus, 'edit') == 'true') {
				echo 	'<a href="' . URL($link) . '" class="btn btn-sm btn-danger">
								<svg class="c-icon" style="margin-right:5px;">
		                          	<use xlink:href="' . URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-check') . '"></use>
		                        </svg> Default
							</a>';
			}
		}

		public static function editButton($link_menus = '', $link = '')
		{
			if (Yeah::hakAkses($link_menus, 'edit') == 'true') {
				echo 	'<a href="' . URL($link) . '" class="btn btn-sm btn-warning">
								<svg class="c-icon" style="margin-right:5px;">
		                          	<use xlink:href="' . URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-pencil') . '"></use>
		                        </svg> Edit
							</a>';
			}
		}

		public static function hapus($link_menus = '', $link = '', $label = '')
		{
			if (Yeah::hakAkses($link_menus, 'hapus') == 'true') {
				echo 	'<button type="button" class="dropdown-item showModalHapus" style="color:red" data-link="' . URL($link) . '" data-nama="' . $label . '">
								<svg class="c-icon" style="margin-right:5px;margin-top:-3px">
		                          	<use xlink:href="' . URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-trash') . '"></use>
		                        </svg> Hapus
							</button>';
			}
		}

		public static function hapusButton($link_menus = '', $link = '', $label = '')
		{
			if (Yeah::hakAkses($link_menus, 'hapus') == 'true') {
				echo 	'<button type="button" class="btn btn-brand btn-sm btn-danger showModalHapus" style="color:white" data-link="' . URL($link) . '" data-nama="' . $label . '">
								<svg class="c-icon" style="margin-right:5px;margin-top:-3px">
		                          	<use xlink:href="' . URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-trash') . '"></use>
		                        </svg> Hapus
							</button>';
			}
		}

		public static function hapusCustom1($link_menus = '', $link = '', $label = '')
		{
			if (Yeah::hakAkses($link_menus, 'lihat') == 'true') {
				echo 	'<button type="button" class="btn btn-brand btn-sm btn-danger showModalHapus" style="color:white" data-link="' . URL($link) . '" data-nama="' . $label . '">
								<svg class="c-icon" style="margin-right:5px;margin-top:-3px">
		                          	<use xlink:href="' . URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-trash') . '"></use>
		                        </svg> Hapus
							</button>';
			}
		}

		public static function aktifNonUrl()
		{
			echo '<button type="button" class="btn btn-brand btn-sm btn-success" style="margin-bottom: 4px" disabled>
					    <span>Aktif</span>
					</button>';
		}

		public static function nonAktifNonUrl()
		{
			echo '<button type="button" class="btn btn-brand btn-sm btn-danger" style="margin-bottom: 4px" disabled>
					    <span>Non Aktif</span>
					</button>';
		}

		public static function expiredNonUrl()
		{
			echo '<button type="button" class="btn btn-brand btn-sm btn-danger" style="margin-bottom: 4px" disabled>
					    <span>Expired</span>
					</button>';
		}
	//Tombol

	//Library
		public static function selisihWaktu($start='', $end='')
		{
			$starttime 	= new Datetime($start);
			$endtime 	= new Datetime($end);
			$duration 	= $endtime->diff($starttime);
			return 24*$duration->format('%d') + $duration->format('%H') . "." . $duration->format('%I');
		}

		public static function jumlahHari($start='', $end='')
		{
			$dt1 	= new DateTime($start);
			$dt2 	= new DateTime($end);
			$total 	= $dt1->diff($dt2)->d;
			return $total;
		}

		public static function parseDataFingerprint($data='',$p1='',$p2='')
		{
			$data 	= " ".$data;
			$hasil 	= "";
			$awal 	= strpos($data,$p1);
			if($awal!="")
			{
				$akhir 	= strpos(strstr($data,$p1),$p2);
				if($akhir!="")
					$hasil=substr($data,$awal+strlen($p1),$akhir-strlen($p1));
			}
			return $hasil;
		}

		public static function tanggalKemarin($tanggal='')
		{
			$pecah_tanggal 	= explode('-',$tanggal);
			$hari 			= $pecah_tanggal[2];
			$bulan 			= $pecah_tanggal[1];
			$tahun 			= $pecah_tanggal[0];
			$tanggal_kemarin= mktime(0, 0, 0, $bulan, $hari-1, $tahun);
			return date("Y-m-d", $tanggal_kemarin);
		}

		public static function jumlahtanggal($date1='',$date2='')
		{
			$hitungtanggal 	= strtotime($date1) - strtotime($date2);
			return round($hitungtanggal / (60*60*24));
		}

		public static function jumlahwaktu($time1='', $time2='')
		{
			$secs 			= strtotime($time2) - strtotime('00:00:00');
			$jumlah_waktu 	= date('H:i:s', strtotime($time1) + $secs);
			return $jumlah_waktu;
		}

		public static function jumlahtanggalwaktu($datetime='', $time='')
		{
			$secs 					= strtotime($time) - strtotime('00:00:00');
			$jumlah_tanggal_waktu 	= date('Y-m-d H:i:s', strtotime($datetime) + $secs);
			return $jumlah_tanggal_waktu;
		}

		public static function potongText($text='')
		{
			return Str::limit(strip_tags($text),100);
		}

		public static function angkaAlphabet($number=1)
		{
		    $number = intval($number);
		    if ($number <= 0) {
		       return '';
		    }
		    $alphabet = '';
		    while($number != 0) {
		       $p = ($number - 1) % 26;
		       $number = intval(($number - $p) / 26);
		       $alphabet = chr(65 + $p) . $alphabet;
		   }
		   return $alphabet;
		  }

		public static function tampilHari($hari)
		{
			switch($hari){
			 	case 'Sun':
			  		$getHari = "minggu";
			 	break;
			 	case 'Mon': 
			  		$getHari = "senin";
			 	break;
			 	case 'Tue':
			  		$getHari = "selasa";
			 	break;
			 	case 'Wed':
			  		$getHari = "rabu";
			 	break;
			 	case 'Thu':
			  		$getHari = "kamis";
			 	break;
			 	case 'Fri':
			  		$getHari = "jumat";
			 	break;
			 	case 'Sat':
			  		$getHari = "sabtu";
			 	break;
			 	default:
			  		$getHari = "salah"; 
			 	break;
			}
		 
			return $getHari;
		}
		
		public static function sosialMedia()
		{
			$sosial_media_data = array(
				array(
					'nama' 	=> 'Facebook',
					'icon'	=> 'facebook'
				),
				array(
					'nama'	=> 'Youtube',
					'icon'	=> 'youtube'
				),
				array(
					'nama' 	=> 'Twitter',
					'icon'	=> 'twitter'
				),
				array(
					'nama' 	=> 'Instagram',
					'icon'	=> 'instagram'
				),
				array(
					'nama' 	=> 'Website',
					'icon'	=> 'wordpress'
				),
			);
			return $sosial_media_data;
		}

		public static function randomWarna()
		{
			$rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
    		$color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
    		return $color;
		}
			
		public static function konversiNilai($nilai = 0)
		{
			if ($nilai >= 1000000000000)
				$hasil = round(($nilai / 1000000000000), 2);
			elseif ($nilai >= 1000000000)
				$hasil = round(($nilai / 1000000000), 2);
			elseif ($nilai >= 1000000)
				$hasil = round($nilai / 1000000, 2);
			elseif ($nilai >= 1000)
				$hasil = round(($nilai / 1000), 2);
			else
				$hasil = $nilai;

			return $hasil;
		}

		public static function konversiNilaiString($nilai = 0)
		{
			if ($nilai >= 1000000000000)
				$hasil = 'T';
			elseif ($nilai >= 1000000000)
				$hasil = 'M';
			elseif ($nilai >= 1000000)
				$hasil = 'Jt';
			elseif ($nilai >= 1000)
				$hasil = 'Rb';
			else
				$hasil = '&nbsp;';

			echo $hasil;
		}

		public static function ambilBulanKemaren($bulan = '', $tahun = '')
		{
			$hasil_bulan_kemaren = date('m', strtotime(date($tahun . '-' . $bulan) . '- 1 month'));
			return $hasil_bulan_kemaren;
		}

		public static function ambilTahunKemaren($bulan = '', $tahun = '')
		{
			$hasil_tahun_kemaren = date('Y', strtotime(date($tahun . '-' . $bulan) . '- 1 month'));
			return $hasil_tahun_kemaren;
		}

		public static function ambilBulanDepan($bulan = '', $tahun = '')
		{
			$hasil_bulan_kemaren = date('m', strtotime(date($tahun . '-' . $bulan) . '+ 1 month'));
			return $hasil_bulan_kemaren;
		}

		public static function ambilTahunDepan($bulan = '', $tahun = '')
		{
			$hasil_tahun_kemaren = date('Y', strtotime(date($tahun . '-' . $bulan) . '+ 1 month'));
			return $hasil_tahun_kemaren;
		}

		public static function timeElapsedString($datetime, $full = false)
		{
			$now = new DateTime;
			$ago = new DateTime($datetime);
			$diff = $now->diff($ago);

			$diff->w = floor($diff->d / 7);
			$diff->d -= $diff->w * 7;

			$string = array(
				'y' => 'year',
				'm' => 'month',
				'w' => 'week',
				'd' => 'day',
				'h' => 'hour',
				'i' => 'minute',
				's' => 'second',
			);
			foreach ($string as $k => &$v) {
				if ($diff->$k) {
					$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
				} else {
					unset($string[$k]);
				}
			}

			if (!$full) $string = array_slice($string, 0, 1);
			return $string ? implode(', ', $string) . ' ago' : 'just now';
		}

		public static function ubahDBKeTanggal($tanggal = '')
		{
			$data_bulan 	= array('', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des');
			$pecah_tanggal	= explode('-', $tanggal);
			$bulan 			= '';
			if ($tanggal != '0000-00-00') {
				for ($x = 1; $x <= 12; $x++) {
					if (intval($pecah_tanggal[1]) == $x) {
						$bulan = $x;
						break;
					}
				}
				return $pecah_tanggal[2] . ' ' . $data_bulan[$bulan] . ' ' . $pecah_tanggal[0];
			} else
				return Yeah::ubahDBKeTanggal(date('Y-m-d'));
		}

		public static function ubahTanggalKeDB($tanggal = '')
		{
			if ($tanggal != '') {
				$data_bulan 		= array('', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des');
				$pecah_tanggal  	= explode(' ', $tanggal);
				$bulan 				= '';
				for ($x = 1; $x <= 12; $x++) {
					if ($pecah_tanggal[1] == $data_bulan[$x]) {
						$bulan = $x;
						break;
					}
				}
				if ($bulan < 10)
					$bulan = '0' . $bulan;

				$result = $pecah_tanggal[2] . '-' . $bulan . '-' . $pecah_tanggal[0];
				return $result;
			} else
				return '';
		}

		public static function ubahDBKeTanggalwaktu($tanggal = '')
		{
			$tanggal_waktu = Yeah::ubahDBKeTanggal(date('Y-m-d', strtotime($tanggal))) . ' ' . date('H:i:s', strtotime($tanggal));
			return $tanggal_waktu;
		}

		public static function ubahTanggalCariKeDB($tanggal = '')
		{

			$date = str_replace('/', '-', $tanggal);
			$tanggal_waktu = date('Y-m-d', strtotime($date));
			return $tanggal_waktu;
		}

		public static function ubahWaktuDBKePukul($time = '')
		{

			$waktu = date('h:i a', strtotime($time));
			return $waktu;
		}

		public static function ubahTanggalwaktuKeDB($tanggal = '')
		{
			$pecah_tanggal 		= explode(' ', $tanggal);
			$tanggal 			= $pecah_tanggal[0] . ' ' . $pecah_tanggal[1] . ' ' . $pecah_tanggal[2];
			$waktu 				= $pecah_tanggal[3];
			$tanggal_waktu 		= Yeah::ubahTanggalKeDB($tanggal) . ' ' . $waktu;
			return $tanggal_waktu;
		}

		public static function ubahDBKeHarga($harga = 0)
		{
			$db_ke_harga = number_format($harga, 2, ',', '.');
			return $db_ke_harga;
		}

		public static function ubahHargaKeDB($harga = 0)
		{
			$harga_ke_db = preg_replace("/([^0-9\\.])/i", "", $harga);
			return $harga_ke_db;
		}

		public static function akhirBulan($bulan, $tahun)
		{
			$akhir_bulan = mktime(0, 0, 0, $bulan, 1, $tahun);
			return date('t', $akhir_bulan);
		}

		public static function ubahDBKeBulan($tanggal = '')
		{
			$bulan_data 	= array('', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des');
			$bulan 		= '';
			if ($tanggal != '00') {
				for ($x = 1; $x <= 12; $x++) {
					if (intval($tanggal) == $x) {
						$bulan = $x;
						break;
					}
				}
				return $bulan_data[$bulan];
			} else
				return date('m');
		}

		public static function ubahBulanKeDB($bulan = '')
		{
			if ($bulan != '') {
				$data_bulan 		= array('', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des');
				for ($x = 1; $x <= 12; $x++) {
					if ($bulan == $data_bulan[$x]) {
						$bulan = $x;
						break;
					}
				}
				if ($bulan < 10)
					$bulan = '0' . $bulan;

				return $bulan;
			} else
				return '';
		}

		public static function lihatBulan()
		{
			$bulan_data = array(
				'01' => 'Jan',
				'02' => 'Feb',
				'03' => 'Mar',
				'04' => 'Apr',
				'05' => 'Mei',
				'06' => 'Jun',
				'07' => 'Jul',
				'08' => 'Ags',
				'09' => 'Sep',
				'10' => 'Okt',
				'11' => 'Nov',
				'12' => 'Des',
			);
			return $bulan_data;
		}

		public static function iconMenus()
		{
			$icon_menus_data = array(
				"cil-3d",
				"cil-4k",
				"cil-account-logout",
				"cil-action-redo",
				"cil-action-undo",
				"cil-address-book",
				"cil-airplane-mode",
				"cil-airplane-mode-off",
				"cil-airplay",
				"cil-alarm",
				"cil-album",
				"cil-align-center",
				"cil-align-left",
				"cil-align-right",
				"cil-american-football",
				"cil-android",
				"cil-angular",
				"cil-animal",
				"cil-aperture",
				"cil-apple",
				"cil-applications",
				"cil-applications-settings",
				"cil-apps",
				"cil-apps-settings",
				"cil-arrow-bottom",
				"cil-arrow-circle-bottom",
				"cil-arrow-circle-left",
				"cil-arrow-circle-right",
				"cil-arrow-circle-top",
				"cil-arrow-left",
				"cil-arrow-right",
				"cil-arrow-thick-bottom",
				"cil-arrow-thick-from-bottom",
				"cil-arrow-thick-from-left",
				"cil-arrow-thick-from-right",
				"cil-arrow-thick-from-top",
				"cil-arrow-thick-left",
				"cil-arrow-thick-right",
				"cil-arrow-thick-to-bottom",
				"cil-arrow-thick-to-left",
				"cil-arrow-thick-to-right",
				"cil-arrow-thick-to-top",
				"cil-arrow-thick-top",
				"cil-arrow-top",
				"cil-assistive-listening-system",
				"cil-asterisk",
				"cil-asterisk-circle",
				"cil-at",
				"cil-audio",
				"cil-audio-description",
				"cil-audio-spectrum",
				"cil-av-timer",
				"cil-baby",
				"cil-baby-carriage",
				"cil-backspace",
				"cil-badge",
				"cil-balance-scale",
				"cil-ban",
				"cil-bank",
				"cil-bar-chart",
				"cil-barcode",
				"cil-baseball",
				"cil-basket",
				"cil-basketball",
				"cil-bath",
				"cil-bathroom",
				"cil-battery-0",
				"cil-battery-3",
				"cil-battery-5",
				"cil-battery-alert",
				"cil-battery-empty",
				"cil-battery-full",
				"cil-battery-slash",
				"cil-beach-access",
				"cil-beaker",
				"cil-bed",
				"cil-bell",
				"cil-bike",
				"cil-birthday-cake",
				"cil-blind",
				"cil-bluetooth",
				"cil-blur",
				"cil-blur-circular",
				"cil-blur-linear",
				"cil-boat-alt",
				"cil-bold",
				"cil-bolt",
				"cil-book",
				"cil-bookmark",
				"cil-bootstrap",
				"cil-border-all",
				"cil-border-bottom",
				"cil-border-clear",
				"cil-border-horizontal",
				"cil-border-inner",
				"cil-border-left",
				"cil-border-outer",
				"cil-border-right",
				"cil-border-style",
				"cil-border-top",
				"cil-border-vertical",
				"cil-bowling",
				"cil-braille",
				"cil-briefcase",
				"cil-brightness",
				"cil-british-pound",
				"cil-browser",
				"cil-brush",
				"cil-brush-alt",
				"cil-bug",
				"cil-building",
				"cil-bullhorn",
				"cil-burger",
				"cil-bus-alt",
				"cil-calculator",
				"cil-calendar",
				"cil-calendar-check",
				"cil-camera",
				"cil-camera-control",
				"cil-camera-roll",
				"cil-car-alt",
				"cil-caret-bottom",
				"cil-caret-left",
				"cil-caret-right",
				"cil-caret-top",
				"cil-cart",
				"cil-cash",
				"cil-casino",
				"cil-cast",
				"cil-cat",
				"cil-cc",
				"cil-center-focus",
				"cil-chart",
				"cil-chart-line",
				"cil-chart-pie",
				"cil-chat-bubble",
				"cil-check",
				"cil-chevron-bottom",
				"cil-chevron-circle-down-alt",
				"cil-chevron-circle-left-alt",
				"cil-chevron-circle-right-alt",
				"cil-chevron-circle-up-alt",
				"cil-chevron-double-down",
				"cil-chevron-double-left",
				"cil-chevron-double-right",
				"cil-chevron-double-up",
				"cil-chevron-double-up-alt",
				"cil-chevron-left",
				"cil-chevron-right",
				"cil-chevron-top",
				"cil-child",
				"cil-child-friendly",
				"cil-circle",
				"cil-clear-all",
				"cil-clipboard",
				"cil-clock",
				"cil-clone",
				"cil-closed-captioning",
				"cil-cloud",
				"cil-cloud-download",
				"cil-cloud-upload",
				"cil-cloudy",
				"cil-code",
				"cil-codepen",
				"cil-coffee",
				"cil-cog",
				"cil-color-border",
				"cil-color-fill",
				"cil-color-palette",
				"cil-columns",
				"cil-comment-bubble",
				"cil-comment-square",
				"cil-compass",
				"cil-compress",
				"cil-contact",
				"cil-contrast",
				"cil-control",
				"cil-copy",
				"cil-copyright",
				"cil-couch",
				"cil-credit-card",
				"cil-crop",
				"cil-crop-rotate",
				"cil-cursor",
				"cil-cursor-move",
				"cil-cut",
				"cil-data-transfer-down",
				"cil-data-transfer-up",
				"cil-deaf",
				"cil-delete",
				"cil-description",
				"cil-devices",
				"cil-dialpad",
				"cil-diamond",
				"cil-dinner",
				"cil-disabled",
				"cil-dog",
				"cil-dollar",
				"cil-door",
				"cil-double-quote-sans-left",
				"cil-double-quote-sans-right",
				"cil-drink",
				"cil-drink-alcohol",
				"cil-drop",
				"cil-drop1",
				"cil-eco",
				"cil-education",
				"cil-elevator",
				"cil-ellipses",
				"cil-ellipsis",
				"cil-envelope-closed",
				"cil-envelope-letter",
				"cil-envelope-open",
				"cil-equalizer",
				"cil-ethernet",
				"cil-euro",
				"cil-excerpt",
				"cil-exit-to-app",
				"cil-expand-down",
				"cil-expand-left",
				"cil-expand-right",
				"cil-expand-up",
				"cil-exposure",
				"cil-external-link",
				"cil-eyedropper",
				"cil-face",
				"cil-face-dead",
				"cil-facebook",
				"cil-factory",
				"cil-factory-slash",
				"cil-fastfood",
				"cil-fax",
				"cil-featured-playlist",
				"cil-file",
				"cil-filter",
				"cil-filter-frames",
				"cil-filter-photo",
				"cil-find-in-page",
				"cil-fingerprint",
				"cil-fire",
				"cil-flag-alt",
				"cil-flight-takeoff",
				"cil-flip",
				"cil-flip-to-back",
				"cil-flip-to-front",
				"cil-flower",
				"cil-folder",
				"cil-folder-open",
				"cil-font",
				"cil-football",
				"cil-fork",
				"cil-fridge",
				"cil-frown",
				"cil-fullscreen",
				"cil-fullscreen-exit",
				"cil-functions",
				"cil-functions-alt",
				"cil-gamepad",
				"cil-garage",
				"cil-gauge",
				"cil-gem",
				"cil-gif",
				"cil-gift",
				"cil-git",
				"cil-github",
				"cil-github-circle",
				"cil-gitlab",
				"cil-globe-alt",
				"cil-golf",
				"cil-golf-alt",
				"cil-gradient",
				"cil-grain",
				"cil-graph",
				"cil-grid",
				"cil-grid-slash",
				"cil-hamburger-menu",
				"cil-hand-point-down",
				"cil-hand-point-left",
				"cil-hand-point-right",
				"cil-hand-point-up",
				"cil-happy",
				"cil-hd",
				"cil-hdr",
				"cil-header",
				"cil-headphones",
				"cil-healing",
				"cil-heart",
				"cil-highlighter",
				"cil-highligt",
				"cil-history",
				"cil-home",
				"cil-hospital",
				"cil-hot-tub",
				"cil-house",
				"cil-https",
				"cil-image-broken",
				"cil-image-plus",
				"cil-image1",
				"cil-inbox",
				"cil-indent-decrease",
				"cil-indent-increase",
				"cil-industry",
				"cil-industry-slash",
				"cil-infinity",
				"cil-info",
				"cil-input",
				"cil-input-hdmi",
				"cil-input-power",
				"cil-instagram",
				"cil-institution",
				"cil-italic",
				"cil-justify-center",
				"cil-justify-left",
				"cil-justify-right",
				"cil-keyboard",
				"cil-lan",
				"cil-language",
				"cil-laptop",
				"cil-layers",
				"cil-leaf",
				"cil-lemon",
				"cil-level-down",
				"cil-level-up",
				"cil-library",
				"cil-library-add",
				"cil-library-building",
				"cil-life-ring",
				"cil-lightbulb",
				"cil-line-spacing",
				"cil-line-style",
				"cil-line-weight",
				"cil-link",
				"cil-link-alt",
				"cil-link-broken",
				"cil-linkedin",
				"cil-list",
				"cil-list-filter",
				"cil-list-high-priority",
				"cil-list-low-priority",
				"cil-list-numbered",
				"cil-list-rich",
				"cil-location-pin",
				"cil-lock-locked",
				"cil-lock-unlocked",
				"cil-locomotive",
				"cil-loop",
				"cil-loop-1",
				"cil-loop-circular",
				"cil-low-vision",
				"cil-magnifying-glass",
				"cil-map",
				"cil-media-eject",
				"cil-media-pause",
				"cil-media-play",
				"cil-media-record",
				"cil-media-skip-backward",
				"cil-media-skip-forward",
				"cil-media-step-backward",
				"cil-media-step-forward",
				"cil-media-stop",
				"cil-medical-cross",
				"cil-meh",
				"cil-memory",
				"cil-menu",
				"cil-mic",
				"cil-microphone",
				"cil-minus",
				"cil-mobile",
				"cil-mobile-landscape",
				"cil-money",
				"cil-monitor",
				"cil-mood-bad",
				"cil-mood-good",
				"cil-mood-very-bad",
				"cil-mood-very-good",
				"cil-moon",
				"cil-mouse",
				"cil-mouth-slash",
				"cil-move",
				"cil-movie",
				"cil-mug",
				"cil-mug-tea",
				"cil-music-note",
				"cil-newspaper",
				"cil-notes",
				"cil-object-group",
				"cil-object-ungroup",
				"cil-opacity",
				"cil-options",
				"cil-options-horizontal",
				"cil-paint",
				"cil-paint-bucket",
				"cil-paper-plane",
				"cil-paperclip",
				"cil-paragraph",
				"cil-paw",
				"cil-pen-alt",
				"cil-pen-nib",
				"cil-pencil",
				"cil-people",
				"cil-phone",
				"cil-pin",
				"cil-pizza",
				"cil-plant",
				"cil-playlist-add",
				"cil-plus",
				"cil-polymer",
				"cil-pool",
				"cil-power-standby",
				"cil-pregnant",
				"cil-print",
				"cil-pushchair",
				"cil-puzzle",
				"cil-qr-code",
				"cil-rain",
				"cil-react",
				"cil-rectangle",
				"cil-reddit",
				"cil-registered",
				"cil-reload",
				"cil-resize-both",
				"cil-resize-height",
				"cil-resize-width",
				"cil-restaurant",
				"cil-rights",
				"cil-room",
				"cil-rowing",
				"cil-rss",
				"cil-running",
				"cil-sad",
				"cil-satelite",
				"cil-save",
				"cil-school",
				"cil-screen-desktop",
				"cil-screen-smartphone",
				"cil-scrubber",
				"cil-search",
				"cil-send",
				"cil-settings",
				"cil-share",
				"cil-share-all",
				"cil-share-alt",
				"cil-share-boxed",
				"cil-shield-alt",
				"cil-short-text",
				"cil-shower",
				"cil-sign-language",
				"cil-signal-cellular-0",
				"cil-signal-cellular-3",
				"cil-signal-cellular-4",
				"cil-sim",
				"cil-sitemap",
				"cil-skype",
				"cil-smile",
				"cil-smile-plus",
				"cil-smoke",
				"cil-smoke-free",
				"cil-smoke-slash",
				"cil-smoking-room",
				"cil-snowflake",
				"cil-soccer",
				"cil-sofa",
				"cil-sort-alpha-down",
				"cil-sort-alpha-up",
				"cil-sort-ascending",
				"cil-sort-descending",
				"cil-sort-numeric-down",
				"cil-sort-numeric-up",
				"cil-spa",
				"cil-space-bar",
				"cil-speaker",
				"cil-speech",
				"cil-speedometer",
				"cil-spotify",
				"cil-spreadsheet",
				"cil-square",
				"cil-stackoverflow",
				"cil-star",
				"cil-star-half",
				"cil-storage",
				"cil-stream",
				"cil-strikethrough",
				"cil-sun",
				"cil-swap-horizontal",
				"cil-swap-vertical",
				"cil-swimming",
				"cil-sync",
				"cil-tablet",
				"cil-tag",
				"cil-tags",
				"cil-task",
				"cil-taxi",
				"cil-tennis",
				"cil-tennis-ball",
				"cil-terminal",
				"cil-terrain",
				"cil-text",
				"cil-text-shapes",
				"cil-text-size",
				"cil-text-square",
				"cil-text-strike",
				"cil-thumb-down",
				"cil-thumb-up",
				"cil-toggle-off",
				"cil-toilet",
				"cil-touch-app",
				"cil-trademark",
				"cil-transfer",
				"cil-translate",
				"cil-trash",
				"cil-triangle",
				"cil-truck",
				"cil-tv",
				"cil-twitter",
				"cil-underline",
				"cil-user",
				"cil-user-female",
				"cil-user-follow",
				"cil-user-unfollow",
				"cil-vector",
				"cil-vertical-align-bottom",
				"cil-vertical-align-bottom1",
				"cil-vertical-align-center",
				"cil-vertical-align-center1",
				"cil-vertical-align-top",
				"cil-vertical-align-top1",
				"cil-video",
				"cil-view-column",
				"cil-view-module",
				"cil-view-quilt",
				"cil-view-stream",
				"cil-voice-over-record",
				"cil-volume-high",
				"cil-volume-low",
				"cil-volume-off",
				"cil-vue",
				"cil-walk",
				"cil-wallet",
				"cil-wallpaper",
				"cil-warning",
				"cil-watch",
				"cil-wc",
				"cil-weightlifitng",
				"cil-wheelchair",
				"cil-wifi-signal-0",
				"cil-wifi-signal-1",
				"cil-wifi-signal-2",
				"cil-wifi-signal-4",
				"cil-wifi-signal-off",
				"cil-window",
				"cil-window-maximize",
				"cil-window-minimize",
				"cil-window-restore",
				"cil-wrap-text",
				"cil-x",
				"cil-x-circle",
				"cil-yen",
				"cil-zoom",
				"cil-zoom-in",
				"cil-zoom-out",
			);
			return $icon_menus_data;
		}
	//Library
}