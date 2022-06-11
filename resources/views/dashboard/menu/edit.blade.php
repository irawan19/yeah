@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/menu/prosesedit/'.$edit_menus->id_menus) }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Edit Menu</strong>
					</div>
					<div class="card-body">
						<div class="form-group">
							<label class="form-col-form-label" for="icon_menus">Icon <b style="color:red">*</b></label>
					        <select class="form-control select2" id="icon_menus" name="icon_menus">
					        	@foreach($lihat_icons as $icons)
					        		@php($selected = '')
			                        @if(Request::old('icon_menus') == '')
			                        	@if($icons == $edit_menus->icon_menus)
			                        		@php($selected = 'selected')
			                        	@endif
			                        @else
			                        	@if($icons == Request::old('icon_menus'))
			                        		@php($selected = 'selected')
			                        	@endif
			                        @endif
									<option value="{{$icons}}" {{ $selected }}>{{$icons}}</option>
								@endforeach
					        </select>
			            </div>
						<div class="form-group">
							<label class="form-col-form-label" for="nama_menus">Nama <b style="color:red">*</b></label>
							<input class="form-control {{ Yeah::validForm($errors->first('nama_menus')) }}" id="nama_menus" type="text" name="nama_menus" value="{{Request::old('nama_menus') == '' ? $edit_menus->nama_menus : Request::old('nama_menus')}}">
							{{Yeah::pesanErorForm($errors->first('nama_menus'))}}
						</div>
					</div>
			        <div class="card-footer right-align">
			            <button class="btn btn-sm btn-primary" type="submit">
				        	<svg class="c-icon" style="margin-right:5px;">
	                          	<use xlink:href="{{URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-pencil')}}"></use>
	                        </svg> Perbarui
	                    </button>
			          	@if(request()->session()->get('halaman') != '')
		            		@php($ambil_kembali = request()->session()->get('halaman'))
	                    @else
	                    	@php($ambil_kembali = URL('dashboard/menu'))
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