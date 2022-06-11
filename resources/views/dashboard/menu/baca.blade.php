@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<strong>Baca Menu</strong>
				</div>
				<div class="card-body">
					<table class="table-responsive-sm table-sm">
						<tr>
							<th width="100px">Nama</th>
							<th width="1px">:</th>
							<td>{{$baca_menus->nama_menus}}</td>
						</tr>
					</table>
					<hr/>
					@if($baca_sub_menus != null)
				    	<table class="table table-responsive-sm table-bordered table-striped table-sm">
							<thead>
								<tr>
									<th>Menu</th>
									<th width="5px">Icon</th>
									<th>Sub Menu</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>{{ $baca_menus->nama_menus }}</td>
									<td>
										<svg class="c-sidebar-nav-icon">
										  	<use xlink:href="{{URL::asset('public/template/back/assets/icons/coreui/free.svg#'.$baca_menus->icon_menus)}}"></use>
										</svg>
									</td>
									<td></td>
								</tr>
								@php($no=1)
								@foreach($baca_sub_menus as $sub_menus)
									<tr>
										<td></td>
										<td>
											<svg class="c-sidebar-nav-icon">
									          	<use xlink:href="{{URL::asset('public/template/back/assets/icons/coreui/free.svg#'.$sub_menus->icon_menus)}}"></use>
									        </svg>
										</td>
										<td>{{ $no++ }} {{ $sub_menus->nama_menus }}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					@else
						<table class="table table-responsive-sm table-bordered table-striped table-sm">
							<thead>
								<tr>
									<th>Menu</th>
									<th width="5px">Icon</th>
									<th>Sub Menu</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>{{ $baca_menus->nama_menus }}</td>
									<td>
										<svg class="c-sidebar-nav-icon">
										  	<use xlink:href="{{URL::asset('public/template/back/assets/icons/coreui/free.svg#'.$baca_menus->icon_menus)}}"></use>
										</svg>
									</td>
									<td></td>
								</tr>
							</tbody>
						</table>
				    @endif
				</div>
				<div class="card-footer right-align">
				  	@if(request()->session()->get('halaman') != '')
		           		@php($ambil_kembali = request()->session()->get('halaman'))
	               	@else
	               		@php($ambil_kembali = URL('dashboard/menu'))
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