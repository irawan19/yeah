@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<strong>Baca Sub Menu {{$baca_menus->nama_menus}}</strong>
				</div>
				<div class="card-body">
					<table class="table table-responsive-sm table-striped table-sm">
						<tr>
							<th width="100px">Icon</th>
							<th width="1%">:</th>
							<td>{{ $baca_sub_menus->icon_menus }}</td>
						</tr>
						<tr>
							<th>Name</th>
							<th>:</th>
							<td>{{ $baca_sub_menus->nama_menus }}</td>
						</tr>
						<tr>
							<th>Link</th>
							<th>:</th>
							<td>{{ $baca_sub_menus->link_menus }}</td>
						</tr>
					</table>
					<hr/>
					<table class="table table-bordered table-responsive-sm table-striped table-sm">
						<tr>
							<th width="10%" class="center-align">Lihat</th>
							<th width="10%" class="center-align">Tambah</th>
							<th width="10%" class="center-align">Baca</th>
							<th width="10%" class="center-align">Edit</th>
							<th width="10%" class="center-align">Hapus</th>
							<th width="10%" class="center-align">Cetak</th>
						</tr>
						<tr>
							@php($id_sub_menus = $baca_sub_menus->id_menus)
							@php($get_fitur_lihat = \App\Models\Master_fitur::where('menus_id',$id_sub_menus)->where('nama_fiturs','lihat')->count())
							@php($checked_fitur_lihat = '')
							@if($get_fitur_lihat != 0)
								@php($checked_fitur_lihat = 'checked')
							@endif

							@php($get_fitur_tambah = \App\Models\Master_fitur::where('menus_id',$id_sub_menus)->where('nama_fiturs','tambah')->count())
							@php($checked_fitur_tambah = '')
							@if($get_fitur_tambah != 0)
								@php($checked_fitur_tambah = 'checked')
							@endif

							@php($get_fitur_baca = \App\Models\Master_fitur::where('menus_id',$id_sub_menus)->where('nama_fiturs','baca')->count())
							@php($checked_fitur_baca = '')
							@if($get_fitur_baca != 0)
								@php($checked_fitur_baca = 'checked')
							@endif

							@php($get_fitur_edit = \App\Models\Master_fitur::where('menus_id',$id_sub_menus)->where('nama_fiturs','edit')->count())
							@php($checked_fitur_edit = '')
							@if($get_fitur_edit != 0)
								@php($checked_fitur_edit = 'checked')
							@endif

							@php($get_fitur_hapus = \App\Models\Master_fitur::where('menus_id',$id_sub_menus)->where('nama_fiturs','hapus')->count())
							@php($checked_fitur_hapus = '')
							@if($get_fitur_hapus != 0)
								@php($checked_fitur_hapus = 'checked')
							@endif

							@php($get_fitur_cetak = \App\Models\Master_fitur::where('menus_id',$id_sub_menus)->where('nama_fiturs','cetak')->count())
							@php($checked_fitur_cetak = '')
							@if($get_fitur_cetak != 0)
								@php($checked_fitur_cetak = 'checked')
							@endif
							<td class="center-align">
								<label>
	                            	<input type="checkbox" name="nama_fiturs[]" id="fitur_lihat" value="lihat" {{ $checked_fitur_lihat }} disabled="disabled">
								</label>
							</td>
							<td class="center-align">
								<label>
	                            	<input type="checkbox" name="nama_fiturs[]" id="fitur_tambah" value="tambah" {{ $checked_fitur_tambah }} disabled="disabled">
								</label>
							</td>
							<td class="center-align">
								<label>
	                            	<input type="checkbox" name="nama_fiturs[]" id="fitur_baca" value="baca" {{ $checked_fitur_baca }} disabled="disabled">
								</label>
							</td>
							<td class="center-align">
								<label>
	                            	<input type="checkbox" name="nama_fiturs[]" id="fitur_edit" value="edit" {{ $checked_fitur_edit }} disabled="disabled">
								</label>
							</td>
							<td class="center-align">
								<label>
	                            	<input type="checkbox" name="nama_fiturs[]" id="fitur_hapus" value="hapus" {{ $checked_fitur_hapus }} disabled="disabled">
								</label>
							</td>
							<td class="center-align">
								<label>
	                            	<input type="checkbox" name="nama_fiturs[]" id="fitur_cetak" value="cetak" {{ $checked_fitur_cetak }} disabled="disabled">
								</label>
							</td>
						</tr>
					</table>
				</div>
				<div class="card-footer right-align">
				  	@if(request()->session()->get('halaman2') != '')
		           		@php($ambil_kembali = request()->session()->get('halaman2'))
	               	@else
	                    @php($ambil_kembali = URL('dashboard/menu/submenu/'.$lihat_menus->id_menus))
	               	@endif
		           	<a class="btn btn-sm btn-danger" href="{{ $ambil_kembali }}">
		           		<svg class="c-icon" style="margin-right:5px;">
	               	      	<use xlink:href="{{URL::asset('template/back/assets/icons/coreui/free.svg#cil-ban')}}"></use>
	               	    </svg> Kembali
	               	</a>
				</div>
			</div>
		</div>
	</div>

@endsection