@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/sosial_media/prosestambah') }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Tambah Sosial Media</strong>
					</div>
					<div class="card-body">
						@if (Session::get('setelah_simpan.alert') == 'sukses')
					    	{{ Yeah::pesanSuksesForm(Session::get('setelah_simpan.text')) }}
					    @endif
						<div class="form-group">
							<label class="form-col-form-label" for="sosial_medias">Sosial Media <b style="color:red">*</b></label>
				            <select class="form-control select2" id="sosial_medias" name="sosial_medias">
				                 @foreach($tambah_list_sosial_medias as $list_sosial_medias)
				                    <option value="{{ $list_sosial_medias['icon'].'_'.$list_sosial_medias['nama'] }}" {{ Request::old('sosial_medias') == $list_sosial_medias['icon'].'_'.$list_sosial_medias['nama'] ? $select='selected' : $select='' }}>{{ $list_sosial_medias['nama'] }}</option>
				                @endforeach
	                        </select>
		                </div>
						<div class="form-group">
							<label class="form-col-form-label" for="url_sosial_medias">URL <b style="color:red">*</b></label>
							<input class="form-control {{ Yeah::validForm($errors->first('url_sosial_medias')) }}" id="url_sosial_medias" type="text" name="url_sosial_medias" value="{{Request::old('url_sosial_medias')}}">
							{{Yeah::pesanErorForm($errors->first('url_sosial_medias'))}}
						</div>
					</div>
			        <div class="card-footer right-align">
			        	<button class="btn btn-sm btn-success" type="submit" name="simpan" value="simpan">
			            	<svg class="c-icon" style="margin-right:5px;">
	                          	<use xlink:href="{{URL::asset('public/template/back/assets/icons/coreui/free-symbol-defs.svg#cui-plus')}}"></use>
	                        </svg> Simpan
			            </button>
			            <button class="btn btn-sm btn-success active" type="submit" name="simpan_kembali" value="simpan_kembali">
			            	<svg class="c-icon" style="margin-right:5px;">
	                          	<use xlink:href="{{URL::asset('public/template/back/assets/icons/coreui/free-symbol-defs.svg#cui-reload')}}"></use>
	                        </svg> Simpan Kembali
			            </button>
			          	@if(request()->session()->get('halaman') != '')
		            		@php($ambil_kembali = request()->session()->get('halaman'))
	                    @else
	                    	@php($ambil_kembali = URL('dashboard/sosial_media'))
	                    @endif
		                <a class="btn btn-sm btn-danger" href="{{ $ambil_kembali }}">
		                	<svg class="c-icon" style="margin-right:5px;">
	                          	<use xlink:href="{{URL::asset('public/template/back/assets/icons/coreui/free-symbol-defs.svg#cui-ban')}}"></use>
	                        </svg> Batal
	                    </a>
			        </div>
				</form>
			</div>
		</div>
	</div>

@endsection