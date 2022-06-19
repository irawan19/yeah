@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<strong>Baca Event</strong>
				</div>
				<div class="card-body">
                    <div class="center-align">
                        <a data-fancybox="gallery" href="{{URL::asset($baca_events->gambar_events)}}">
							<img src="{{ URL::asset($baca_events->gambar_events) }}" width="108">
						</a>
                    </div>
                    <hr/>
					<table class="table table-responsive-sm table-striped table-sm">
						<tr>
							<th width="150px">Tanggal</th>
							<th width="1px">:</th>
							<td>{{Yeah::ubahDBKeTanggalwaktu($baca_events->tanggal_events)}}</td>
						</tr>
						<tr>
							<th>Nama</th>
							<th>:</th>
							<td>{{$baca_events->nama_events}}</td>
						</tr>
						<tr>
							<th>Lokasi</th>
							<th>:</th>
							<td>{{$baca_events->lokasi_events}}</td>
						</tr>
						<tr>
							<th>Registrasi</th>
							<th>:</th>
							<td>{{Yeah::ubahDBKeTanggalwaktu($baca_events->mulai_registrasi_events).' sampai '.Yeah::ubahDBKeTanggalwaktu($baca_events->selesai_registrasi_events)}}</td>
						</tr>
						<tr>
							<th>Deskripsi</th>
							<th>:</th>
							<td>{!! $baca_events->deskripsi_events !!}</td>
						</tr>
						<tr>
							<th>Disclaimer</th>
							<th>:</th>
							<td>{!! $baca_events->disclaimer_events !!}</td>
						</tr>
						<tr>
							<th>Dibuat</th>
							<th>:</th>
							<td>{{Yeah::ubahDBKeTanggalwaktu($baca_events->created_at)}}</td>
						</tr>
						<tr>
							<th>Diperbarui</th>
							<th>:</th>
							<td>{{Yeah::ubahDBKeTanggalwaktu($baca_events->updated_at)}}</td>
						</tr>
					</table>
				</div>
				<div class="card-footer right-align">
					@if(request()->session()->get('halaman') != '')
						@php($ambil_kembali = request()->session()->get('halaman'))
					@else
						@php($ambil_kembali = URL('dashboard/event'))
					@endif
					<a class="btn btn-sm btn-danger" href="{{ $ambil_kembali }}">
						<svg class="c-icon" style="margin-right:5px;">
							<use xlink:href="{{URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-ban')}}"></use>
						</svg> Kembali
					</a>
				</div>
			</div>
		</div>
	</div>

@endsection