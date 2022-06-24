@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<strong>Baca Promo</strong>
				</div>
				<div class="card-body">
                    <div class="center-align">
                        <a data-fancybox="gallery" href="{{URL::asset($baca_promos->gambar_promos)}}">
							<img src="{{ URL::asset($baca_promos->gambar_promos) }}" width="108">
						</a>
                    </div>
                    <hr/>
					<table class="table table-responsive-sm table-striped table-sm">
						<tr>
							<th width="150px">Event</th>
							<th width="1px">:</th>
							<td>
								@if($baca_promos->events_id != 0)
									{{$baca_promos->nama_events}}
								@else
									Semua Event
								@endif
							</td>
						</tr>
						<tr>
							<th>Mulai</th>
							<th>:</th>
							<td>{{Yeah::ubahDBKeTanggalwaktu($baca_promos->mulai_promos)}}</td>
						</tr>
						<tr>
							<th>Selesai</th>
							<th>:</th>
							<td>{{Yeah::ubahDBKeTanggalwaktu($baca_promos->selesai_promos)}}</td>
						</tr>
						<tr>
							<th>Nama</th>
							<th>:</th>
							<td>{{$baca_promos->nama_promos}}</td>
						</tr>
						<tr>
							<th>Deskripsi</th>
							<th>:</th>
							<td>{!! $baca_promos->deskripsi_promos !!}</td>
						</tr>
						<tr>
							<th>Oleh</th>
							<th>:</th>
							<td>{{$baca_promos->name}}</td>
						</tr>
						<tr>
							<th>Dibuat</th>
							<th>:</th>
							<td>{{Yeah::ubahDBKeTanggalwaktu($baca_promos->tanggal_promos)}}</td>
						</tr>
						<tr>
							<th>Diperbarui</th>
							<th>:</th>
							<td>{{Yeah::ubahDBKeTanggalwaktu($baca_promos->update_promos)}}</td>
						</tr>
					</table>
				</div>
				<div class="card-footer right-align">
					@if(request()->session()->get('halaman') != '')
						@php($ambil_kembali = request()->session()->get('halaman'))
					@else
						@php($ambil_kembali = URL('dashboard/promo'))
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