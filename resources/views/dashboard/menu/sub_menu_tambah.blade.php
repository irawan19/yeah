@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/menu/prosestambah_submenu/'.$lihat_menus->id_menus) }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Tambah Sub Menu {{$lihat_menus->nama_menus}}</strong>
					</div>
					<div class="card-body">
						@if (Session::get('setelah_simpan.alert') == 'sukses')
					    	{{ Yeah::pesanSuksesForm(Session::get('setelah_simpan.text')) }}
					    @endif
						<div class="form-group">
							<label class="form-col-form-label" for="icon_menus">Icon <b style="color:red">*</b></label>
					        <select class="form-control select2" id="icon_menus" name="icon_menus">
					        	@foreach($lihat_icons as $icons)
									<option value="{{$icons}}" {{ Request::old('icon_menus') == $icons ? $selected='selected' : Request::old('icon_menus') }}>{{$icons}}</option>
								@endforeach
					        </select>
			            </div>
						<div class="form-group">
							<label class="form-col-form-label" for="nama_menus">Nama <b style="color:red">*</b></label>
							<input class="form-control {{ Yeah::validForm($errors->first('nama_menus')) }}" id="nama_menus" type="text" name="nama_menus" value="{{Request::old('nama_menus')}}">
							{{Yeah::pesanErorForm($errors->first('nama_menus'))}}
						</div>
						<div class="form-group">
							<label class="form-col-form-label" for="link_menus">Link <b style="color:red">*</b></label>
							<input class="form-control {{ Yeah::validForm($errors->first('link_menus')) }}" id="link_menus" type="text" name="link_menus" value="{{Request::old('link_menus')}}">
							{{Yeah::pesanErorForm($errors->first('link_menus'))}}
						</div>
						<table class="table table-responsive-sm table-bordered table-striped table-sm">
							<tr>
								<th width="10%" class="center-align">Lihat <i style="color:red">*</i></th>
								<th width="10%" class="center-align">Tambah</th>
								<th width="10%" class="center-align">Baca</th>
								<th width="10%" class="center-align">Edit</th>
								<th width="10%" class="center-align">Hapus</th>
								<th width="10%" class="center-align">Cetak</th>
							</tr>
							<tr>
								<td class="center-align">
									<label>
	                                	<input type="checkbox" name="nama_fiturs[]" id="fitur_lihat" value="lihat" {{ Request::old('nama_fiturs.0') == 'lihat' ? $checked='checked' : $checked='' }}>
									</label>
								</td>
								<td class="center-align">
									<label>
	                                	<input type="checkbox" name="nama_fiturs[]" id="fitur_tambah" value="tambah" disabled="disabled">
									</label>
								</td>
								<td class="center-align">
									<label>
	                                	<input type="checkbox" name="nama_fiturs[]" id="fitur_baca" value="baca" disabled="disabled">
									</label>
								</td>
								<td class="center-align">
									<label>
	                                	<input type="checkbox" name="nama_fiturs[]" id="fitur_edit" value="edit" disabled="disabled">
									</label>
								</td>
								<td class="center-align">
									<label>
	                                	<input type="checkbox" name="nama_fiturs[]" id="fitur_hapus" value="hapus" disabled="disabled">
									</label>
								</td>
								<td class="center-align">
									<label>
	                                	<input type="checkbox" name="nama_fiturs[]" id="fitur_cetak" value="cetak" disabled="disabled">
									</label>
								</td>
							</tr>
						</table>
	                    {{ Yeah::pesanErorForm($errors->first('nama_fiturs')) }}
					</div>
			        <div class="card-footer right-align">
			            <button class="btn btn-sm btn-success" type="submit" name="simpan" value="simpan">
			            	<svg class="c-icon" style="margin-right:5px;">
	                          	<use xlink:href="{{URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-plus')}}"></use>
	                        </svg> Simpan
			            </button>
			            <button class="btn btn-sm btn-success active" type="submit" name="simpan_kembali" value="simpan_kembali">
			            	<svg class="c-icon" style="margin-right:5px;">
	                          	<use xlink:href="{{URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-reload')}}"></use>
	                        </svg> Simpan Kembali
			            </button>
			          	@if(request()->session()->get('halaman2') != '')
		            		@php($ambil_kembali = request()->session()->get('halaman2'))
	                    @else
	                    	@php($ambil_kembali = URL('dashboard/menu/submenu/'.$lihat_menus->id_menus))
	                    @endif
		                <a class="btn btn-sm btn-danger" href="{{ $ambil_kembali }}">
		                	<svg class="c-icon" style="margin-right:5px;">
	                          	<use xlink:href="{{URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-ban')}}"></use>
	                        </svg> Batal
	                    </a>
			        </div>
				</form>
			</div>
		</div>
	</div>

@endsection