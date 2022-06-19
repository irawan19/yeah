@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" enctype="multipart/form-data" action="{{ URL('dashboard/event/prosestambah') }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Tambah Event</strong>
					</div>
					<div class="card-body">
						@if (Session::get('setelah_simpan.alert') == 'sukses')
					    	{{ Yeah::pesanSuksesForm(Session::get('setelah_simpan.text')) }}
					    @endif
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
									<label class="form-col-form-label" for="userfile_gambar_event">Gambar <b style="color:red">*</b></label>
									<br/>
			                        <input id="userfile_gambar_event" type="file" name="userfile_gambar_event">
			                    </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-col-form-label" for="tanggal_events">Tanggal <b style="color:red">*</b></label>
                                    <input readonly class="form-control getDateTime {{ Yeah::validForm($errors->first('tanggal_events')) }}" id="tanggal_events" type="text" name="tanggal_events" value="{{Request::old('tanggal_events') == '' ? Yeah::ubahDBKeTanggalwaktu(date('Y-m-d')) : Request::old('tanggal_events')}}">
                                    {{Yeah::pesanErorForm($errors->first('tanggal_events'))}}
                                </div>
                                <div class="form-group">
                                    <label class="form-col-form-label" for="nama_events">Nama <b style="color:red">*</b></label>
                                    <input class="form-control {{ Yeah::validForm($errors->first('nama_events')) }}" id="nama_events" type="text" name="nama_events" value="{{Request::old('nama_events')}}">
                                    {{Yeah::pesanErorForm($errors->first('nama_events'))}}
                                </div>
                                <div class="form-group">
                                    <label class="form-col-form-label" for="deskripsi_events">Deskripsi <b style="color:red">*</b></label>
                                    <textarea class="form-control {{ Yeah::validForm($errors->first('deskripsi_events')) }}" id="editor2" name="deskripsi_events" rows="5">{{Request::old('deskripsi_events')}}</textarea>
                                    {{Yeah::pesanErorForm($errors->first('deskripsi_events'))}}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-col-form-label" for="tanggal_registrasi_events">Tanggal Registrasi <b style="color:red">*</b></label>
                                    <input readonly class="form-control getStartEndDateTime {{ Yeah::validForm($errors->first('tanggal_registrasi_events')) }}" id="tanggal_registrasi_events" type="text" name="tanggal_registrasi_events" value="{{Request::old('tanggal_registrasi_events') == '' ? Yeah::ubahDBKeTanggalWaktu(date('Y-m-d H:i:00')).' sampai '.Yeah::ubahDBKeTanggalWaktu(date('Y-m-d H:i:00', strtotime(date('Y-m-d H:i:00'). ' + 1 days'))) : Request::old('tanggal_registrasi_events')}}">
                                    {{Yeah::pesanErorForm($errors->first('tanggal_registrasi_events'))}}
                                </div>
                                <div class="form-group">
                                    <label class="form-col-form-label" for="lokasi_events">Lokasi <b style="color:red">*</b></label>
                                    <input class="form-control {{ Yeah::validForm($errors->first('lokasi_events')) }}" id="lokasi_events" type="text" name="lokasi_events" value="{{Request::old('lokasi_events')}}">
                                    {{Yeah::pesanErorForm($errors->first('lokasi_events'))}}
                                </div>
                                <div class="form-group">
                                    <label class="form-col-form-label" for="disclaimer_events">Disclaimer <b style="color:red">*</b></label>
                                    <textarea class="form-control {{ Yeah::validForm($errors->first('disclaimer_events')) }}" id="editor1" name="disclaimer_events" rows="5">{{Request::old('disclaimer_events')}}</textarea>
                                    {{Yeah::pesanErorForm($errors->first('disclaimer_events'))}}
                                </div>
                            </div>
                        </div>
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
			          	@if(request()->session()->get('halaman') != '')
		            		@php($ambil_kembali = request()->session()->get('halaman'))
	                    @else
	                    	@php($ambil_kembali = URL('dashboard/event'))
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