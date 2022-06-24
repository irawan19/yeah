@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<strong>Baca Ticket</strong>
				</div>
				<div class="card-body">
					<table class="table table-responsive-sm table-striped table-sm">
						<tr>
							<th width="150px">Event</th>
							<th width="1px">:</th>
							<td>{{$baca_tickets->nama_events}}</td>
						</tr>
						<tr>
							<th>Nama</th>
							<th>:</th>
							<td>{{$baca_tickets->nama_tickets}}</td>
						</tr>
						<tr>
							<th>Harga</th>
							<th>:</th>
							<td>{{Yeah::ubahDBKeHarga($baca_tickets->harga_tickets)}}</td>
						</tr>
						<tr>
							<th>Kuota</th>
							<th>:</th>
							<td>{{$baca_tickets->kuota_tickets}}</td>
						</tr>
						<tr>
							<th>Sisa Kuota</th>
							<th>:</th>
							<td>{{$baca_tickets->sisa_kuota_tickets}}</td>
						</tr>
						<tr>
							<th>Deskripsi</th>
							<th>:</th>
							<td>{!! $baca_tickets->deskripsi_tickets !!}</td>
						</tr>
						<tr>
							<th>Keterangan</th>
							<th>:</th>
							<td>{!! nl2br($baca_tickets->keterangan_tickets) !!}</td>
						</tr>
						<tr>
							<th>Oleh</th>
							<th>:</th>
							<td>{{$baca_tickets->name}}</td>
						</tr>
						<tr>
							<th>Dibuat</th>
							<th>:</th>
							<td>{{Yeah::ubahDBKeTanggalwaktu($baca_tickets->created_at)}}</td>
						</tr>
						<tr>
							<th>Diperbarui</th>
							<th>:</th>
							<td>{{Yeah::ubahDBKeTanggalwaktu($baca_tickets->updated_at)}}</td>
						</tr>
					</table>
				</div>
				<div class="card-footer right-align">
					@if(request()->session()->get('halaman') != '')
						@php($ambil_kembali = request()->session()->get('halaman'))
					@else
						@php($ambil_kembali = URL('dashboard/ticket'))
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