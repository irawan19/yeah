@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-6 row-center">
			<div class="card">
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/konfigurasi_profil/prosesedit') }}" enctype="multipart/form-data" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Konfigurasi Profil</strong>
					</div>
					<div class="card-body">
						@if (Session::get('setelah_simpan.alert') == 'sukses')
				        	{{ Yeah::pesanSuksesForm(Session::get('setelah_simpan.text')) }}
				        @endif
						<div class="form-group">
							<label class="form-col-form-label" for="userfile_foto_user">Foto <b style="color:red">*</b></label>
							<br/>
							<div class="form-group center-align">
								@if(Auth::user()->profile_photo_path != null)
									<a data-fancybox="gallery" href="{{URL::asset(Auth::user()->profile_photo_path)}}">
										<img src="{{URL::asset(Auth::user()->profile_photo_path)}}" width="108">
									</a>
								@else
									<a data-fancybox="gallery" href="{{Auth::user()->profile_photo_url}}">
										<img src="{{ Auth::user()->profile_photo_url }}" width="108">
									</a>
								@endif
							</div>
				            <input id="userfile_foto_user" type="file" name="userfile_foto_user">
							{{Yeah::pesanErorForm($errors->first('userfile_foto_user'))}}
				        </div>
						<div class="form-group">
							<label class="form-col-form-label" for="name">Nama <b style="color:red">*</b></label>
							<input class="form-control {{ Yeah::validForm($errors->first('name')) }}" id="name" type="text" name="name" value="{{Request::old('name') == '' ? Auth::user()->name : Request::old('name')}}">
							{{Yeah::pesanErorForm($errors->first('name'))}}
						</div>
					</div>
				    <div class="card-footer right-align">
				        <button class="btn btn-sm btn-primary" type="submit">
				        	<svg class="c-icon" style="margin-right:5px;">
	                          	<use xlink:href="{{URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-pencil')}}"></use>
	                        </svg> Perbarui
	                    </button>
				    </div>
				</form>
			</div>
		</div>
	</div>

@endsection