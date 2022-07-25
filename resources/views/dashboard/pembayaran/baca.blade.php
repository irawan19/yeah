@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<strong>Baca Pembayaran</strong>
				</div>
				<div class="card-body">
                    <div class="center-align">
                        <a data-fancybox="gallery" href="{{URL::asset($baca_pembayarans->logo_pembayarans)}}">
							<img src="{{ URL::asset($baca_pembayarans->logo_pembayarans) }}" width="108">
						</a>
                    </div>
                    <hr/>
					<table class="table table-responsive-sm table-striped table-sm">
						<tr>
							<th width="150px">Tipe</th>
							<th width="1px">:</th>
							<td>{{$baca_pembayarans->nama_tipe_pembayarans}}</td>
						</tr>
						<tr>
							<th>Nama</th>
							<th>:</th>
							<td>{{$baca_pembayarans->nama_pembayarans}}</td>
						</tr>
						<tr>
							<th>Rekening</th>
							<th>:</th>
							<td>{{$baca_pembayarans->nama_rekening_pembayarans}}</td>
						</tr>
						<tr>
							<th>No Rekening</th>
							<th>:</th>
							<td>{{$baca_pembayarans->no_rekening_pembayarans}}</td>
						</tr>
						<tr>
							<th>Dibuat</th>
							<th>:</th>
							<td>{{Yeah::ubahDBKeTanggalwaktu($baca_pembayarans->created_at)}}</td>
						</tr>
						<tr>
							<th>Diperbarui</th>
							<th>:</th>
							<td>{{Yeah::ubahDBKeTanggalwaktu($baca_pembayarans->updated_at)}}</td>
						</tr>
					</table>
				</div>
				<div class="card-footer right-align">
					@if(request()->session()->get('halaman') != '')
						@php($ambil_kembali = request()->session()->get('halaman'))
					@else
						@php($ambil_kembali = URL('dashboard/pembayaran'))
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