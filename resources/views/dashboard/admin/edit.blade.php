@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" enctype="multipart/form-data" action="{{ URL('dashboard/admin/prosesedit/'.$edit_admins->id) }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Edit Admin</strong>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label class="form-col-form-label" for="userfile_foto_user">Foto</label>
									<br/>
									<div class="form-group center-align">
										@if($edit_admins->profile_photo_path != null)
											<a data-fancybox="gallery" href="{{URL::asset($edit_admins->profile_photo_path)}}">
												<img src="{{URL::asset($edit_admins->profile_photo_path)}}" width="108">
											</a>
										@else
											<a data-fancybox="gallery" href="{{URL::asset($edit_admins->profile_photo_url)}}">
												<img src="{{ $edit_admins->profile_photo_url }}" width="108">
											</a>
										@endif
									</div>
			                        <input id="userfile_foto_user" type="file" name="userfile_foto_user">
			                    </div>
								{{Yeah::pesanErorFormFile($errors->first('userfile_foto_user'))}}
								<div class="form-group">
									<label class="form-col-form-label" for="name">Nama <b style="color:red">*</b></label>
									<input class="form-control {{ Yeah::validForm($errors->first('name')) }}" id="name" type="text" name="name" value="{{Request::old('name') == '' ? $edit_admins->name : Request::old('name')}}">
									{{Yeah::pesanErorForm($errors->first('name'))}}
								</div>
								<div class="form-group">
									<label class="form-col-form-label" for="username">Username <b style="color:red">*</b></label>
									<input class="form-control {{ Yeah::validForm($errors->first('username')) }}" id="username" type="text" name="username" value="{{Request::old('username') == '' ? $edit_admins->username : Request::old('username')}}">
									{{Yeah::pesanErorForm($errors->first('username'))}}
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="form-col-form-label" for="level_sistems_id">Level Sistem <b style="color:red">*</b></label>
				                    <select class="form-control select2" id="level_sistems_id" name="level_sistems_id">
				                    	@foreach($edit_level_sistems as $level_sistems)
				                    		@php($selected = '')
					                        @if(Request::old('level_sistems_id') == '')
					                        	@if($level_sistems->id_level_sistems == $edit_admins->level_sistems_id)
					                        		@php($selected = 'selected')
					                        	@endif
					                        @else
					                        	@if($level_sistems->id_level_sistems == Request::old('level_sistems_id'))
					                        		@php($selected = 'selected')
					                        	@endif
					                        @endif
										    <option value="{{$level_sistems->id_level_sistems}}" {{ $selected }}>{{$level_sistems->nama_level_sistems}}</option>
				                    	@endforeach
				                    </select>
		                      	</div>
								<div class="form-group">
									<label class="form-col-form-label" for="email">Email <b style="color:red">*</b></label>
									<input class="form-control {{ Yeah::validForm($errors->first('email')) }}" id="email" type="email" name="email" value="{{Request::old('email') == '' ? $edit_admins->email : Request::old('email')}}">
									{{Yeah::pesanErorForm($errors->first('email'))}}
								</div>
		                      	<div class="center-align">
									<label style="color:#1a425a">Kosongi password jika tidak ingin mengganti.</label>
								</div>
								<div class="form-group">
									<label class="form-col-form-label" for="password">Password</label>
									<input class="form-control {{ Yeah::validForm($errors->first('password')) }}" id="password" type="password" name="password" value="{{Request::old('password')}}">
									{{Yeah::pesanErorForm($errors->first('password'))}}
								</div>
								<div class="form-group">
									<label class="form-col-form-label" for="password_confirmation">Konfirmasi Password</label>
									<input class="form-control {{ Yeah::validForm($errors->first('password_confirmation')) }}" id="password_confirmation" type="password" name="password_confirmation" value="{{Request::old('password_confirmation')}}">
									{{Yeah::pesanErorForm($errors->first('password_confirmation'))}}
								</div>
								<div class="form-group">
									<label>
	                                	<input type="checkbox" name="lihat_password" id="lihat_password" value="1" {{ Request::old('lihat_password') == 1 ? $checked='checked' : $checked='' }}> Lihat Password
			                    	</label>
								</div>
							</div>
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
	                    	@php($ambil_kembali = URL('dashboard/admin'))
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

	<script type="text/javascript">
        $(document).ready(function(){
        	var isChecked = $('#lihat_password').prop('checked');
            if (isChecked)
            {
                $('#password').attr('type','text');
                $('#password_confirmation').attr('type','text');
            }
            else
            {
                $('#password').attr('type','Password');
                $('#password_confirmation').attr('type','Password');
            }
            $('#lihat_password').on('change',function(){
                var isChecked = $(this).prop('checked');
                if (isChecked)
                {
                    $('#password').attr('type','text');
                    $('#password_confirmation').attr('type','text');
                }
                else
                {
                    $('#password').attr('type','Password');
                    $('#password_confirmation').attr('type','Password');
                }
            });
        });
    </script>

@endsection