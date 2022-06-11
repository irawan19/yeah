@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-6">
			<div class="card">
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/konfigurasi_aplikasi/prosesedit') }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Konfigurasi Aplikasi</strong>
					</div>
					<div class="card-body">
						@if (Session::get('setelah_simpan.alert') == 'sukses')
							{{ Yeah::pesanSuksesForm(Session::get('setelah_simpan.text')) }}
					    @endif
						<div class="form-group">
							<label class="form-col-form-label" for="nama_konfigurasi_aplikasis">Nama <b style="color:red">*</b></label>
							<input class="form-control {{ Yeah::validForm($errors->first('nama_konfigurasi_aplikasis')) }}" id="nama_konfigurasi_aplikasis" type="text" name="nama_konfigurasi_aplikasis" value="{{Request::old('nama_konfigurasi_aplikasis') == '' ? $lihat_konfigurasi_aplikasis->nama_konfigurasi_aplikasis : Request::old('nama_konfigurasi_aplikasis')}}">
							{{Yeah::pesanErorForm($errors->first('nama_konfigurasi_aplikasis'))}}
						</div>
						<div class="form-group">
							<label class="form-col-form-label" for="deskripsi_konfigurasi_aplikasis">Deskripsi <b style="color:red">*</b></label>
							<input class="form-control {{ Yeah::validForm($errors->first('deskripsi_konfigurasi_aplikasis')) }}" id="deskripsi_konfigurasi_aplikasis" type="text" name="deskripsi_konfigurasi_aplikasis" value="{{Request::old('deskripsi_konfigurasi_aplikasis') == '' ? $lihat_konfigurasi_aplikasis->deskripsi_konfigurasi_aplikasis : Request::old('deskripsi_konfigurasi_aplikasis')}}">
							{{Yeah::pesanErorForm($errors->first('deskripsi_konfigurasi_aplikasis'))}}
						</div>
						<div class="form-group">
							<label class="form-col-form-label" for="keywords_konfigurasi_aplikasis">Keywords <b style="color:red">*</b></label>
							<input class="form-control {{ Yeah::validForm($errors->first('keywords_konfigurasi_aplikasis')) }}" id="keywords_konfigurasi_aplikasis" type="text" name="keywords_konfigurasi_aplikasis" value="{{Request::old('keywords_konfigurasi_aplikasis') == '' ? $lihat_konfigurasi_aplikasis->keywords_konfigurasi_aplikasis : Request::old('keywords_konfigurasi_aplikasis')}}">
							{{Yeah::pesanErorForm($errors->first('keywords_konfigurasi_aplikasis'))}}
						</div>
					</div>
	                <div class="card-footer right-align">
	                    <button class="btn btn-sm btn-primary" type="submit">
	                      	<svg class="c-icon" style="margin-right:5px;">
	                          	<use xlink:href="{{URL::asset('template/back/assets/icons/coreui/free.svg#cil-pencil')}}"></use>
	                        </svg> Perbarui
	                  	</button>
	                </div>
	            </form>
			</div>
		</div>

		<div class="col-sm-6">
			<div class="card">
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/konfigurasi_aplikasi/proseseditlogo') }}" enctype="multipart/form-data" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Logo</strong>
					</div>
					<div class="card-body">
						@if (Session::get('setelah_simpan_logo.alert') == 'sukses')
							{{ Yeah::pesanSuksesForm(Session::get('setelah_simpan_logo.text')) }}
					    @endif
						<div class="form-group center-align">
							<a data-fancybox="gallery" href="{{URL::asset($lihat_konfigurasi_aplikasis->logo_konfigurasi_aplikasis)}}">
								<img src="{{URL::asset($lihat_konfigurasi_aplikasis->logo_konfigurasi_aplikasis)}}" width="108">
							</a>
						</div>
						<div class="form-group row">
	                        <div class="col-md-12 center-align">
	                          	<input id="userfile_logo" type="file" name="userfile_logo">
								{{Yeah::pesanErorFormFile($errors->first('userfile_logo'))}}
	                        </div>
	                    </div>
					</div>
	                <div class="card-footer right-align">
	                    <button class="btn btn-sm btn-primary" type="submit">
	                      	<svg class="c-icon" style="margin-right:5px;">
	                          	<use xlink:href="{{URL::asset('template/back/assets/icons/coreui/free.svg#cil-pencil')}}"></use>
	                        </svg> Perbarui Logo
	                  	</button>
	                </div>
				</form>
			</div>

			<div class="card">
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/konfigurasi_aplikasi/prosesediticon') }}" enctype="multipart/form-data" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Icon</strong>
					</div>
					<div class="card-body">
						@if (Session::get('setelah_simpan_icon.alert') == 'sukses')
							{{ Yeah::pesanSuksesForm(Session::get('setelah_simpan_icon.text')) }}
					    @endif
						<div class="form-group center-align">
							<a data-fancybox="gallery" href="{{URL::asset($lihat_konfigurasi_aplikasis->icon_konfigurasi_aplikasis)}}">
								<img src="{{URL::asset($lihat_konfigurasi_aplikasis->icon_konfigurasi_aplikasis)}}" width="50">
							</a>
						</div>
						<div class="form-group row">
	                        <div class="col-md-12 center-align">
	                          	<input id="userfile_icon" type="file" name="userfile_icon">
								{{Yeah::pesanErorFormFile($errors->first('userfile_icon'))}}
	                        </div>
	                    </div>
					</div>
	                <div class="card-footer right-align">
	                    <button class="btn btn-sm btn-primary" type="submit">
	                      	<svg class="c-icon" style="margin-right:5px;">
	                          	<use xlink:href="{{URL::asset('template/back/assets/icons/coreui/free.svg#cil-pencil')}}"></use>
	                        </svg> Perbarui Icon
	                  	</button>
	                </div>
				</form>
			</div>

			<div class="card">
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/konfigurasi_aplikasi/proseseditlogotext') }}" enctype="multipart/form-data" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Logo Text</strong>
					</div>
					<div class="card-body">
						@if (Session::get('setelah_simpan_logo_text.alert') == 'sukses')
							{{ Yeah::pesanSuksesForm(Session::get('setelah_simpan_logo_text.text')) }}
					    @endif
						<div class="form-group center-align">
							<a data-fancybox="gallery" href="{{URL::asset($lihat_konfigurasi_aplikasis->logo_text_konfigurasi_aplikasis)}}">
								<img src="{{URL::asset($lihat_konfigurasi_aplikasis->logo_text_konfigurasi_aplikasis)}}" width="108">
							</a>
						</div>
						<div class="form-group row">
	                        <div class="col-md-12 center-align">
	                          	<input id="userfile_logo_text" type="file" name="userfile_logo_text">
								{{Yeah::pesanErorFormFile($errors->first('userfile_logo_text'))}}
	                        </div>
	                    </div>
					</div>
	                <div class="card-footer right-align">
	                    <button class="btn btn-sm btn-primary" type="submit">
	                      	<svg class="c-icon" style="margin-right:5px;">
	                          	<use xlink:href="{{URL::asset('template/back/assets/icons/coreui/free.svg#cil-pencil')}}"></use>
	                        </svg> Perbarui Logo Text
	                  	</button>
	                </div>
				</form>
			</div>
		</div>
	</div>

@endsection