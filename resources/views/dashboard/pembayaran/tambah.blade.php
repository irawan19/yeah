@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" enctype="multipart/form-data" action="{{ URL('dashboard/pembayaran/prosestambah') }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Tambah Pembayaran</strong>
					</div>
					<div class="card-body">
						@if (Session::get('setelah_simpan.alert') == 'sukses')
					    	{{ Yeah::pesanSuksesForm(Session::get('setelah_simpan.text')) }}
					    @endif
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
									<label class="form-col-form-label" for="userfile_logo_pembayaran">Logo <b style="color:red">*</b></label>
									<br/>
			                        <input id="userfile_logo_pembayaran" type="file" name="userfile_logo_pembayaran">
			                    </div>
								{{Yeah::pesanErorFormFile($errors->first('userfile_logo_pembayaran'))}}
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-col-form-label" for="events_id">Event <b style="color:red">*</b></label>
                                    <select class="form-control select2" id="events_id" name="events_id">
										<option value="0">Semua Event</option>
                                        @foreach($tambah_events as $events)
                                            <option value="{{$events->id_events}}" {{ Request::old('events_id') == $events->id_events ? $select='selected' : $select='' }}>{{$events->nama_events}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-col-form-label" for="tipe_pembayarans_id">Tipe <b style="color:red">*</b></label>
                                    <select class="form-control select2" id="tipe_pembayarans_id" name="tipe_pembayarans_id">
                                        @foreach($tambah_tipe_pembayarans as $tipe_pembayarans)
                                            <option value="{{$tipe_pembayarans->id_tipe_pembayarans}}" {{ Request::old('tipe_pembayarans_id') == $tipe_pembayarans->id_tipe_pembayarans ? $select='selected' : $select='' }}>{{$tipe_pembayarans->nama_tipe_pembayarans}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-col-form-label" for="nama_pembayarans">Nama <b style="color:red">*</b></label>
                                    <input class="form-control {{ Yeah::validForm($errors->first('nama_pembayarans')) }}" id="nama_pembayarans" type="text" name="nama_pembayarans" value="{{Request::old('nama_pembayarans')}}">
                                    {{Yeah::pesanErorForm($errors->first('nama_pembayarans'))}}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-col-form-label" for="no_rekening_pembayarans">No Rekening</label>
                                    <input class="form-control {{ Yeah::validForm($errors->first('no_rekening_pembayarans')) }}" id="no_rekening_pembayarans" type="text" name="no_rekening_pembayarans" value="{{Request::old('no_rekening_pembayarans')}}">
                                    {{Yeah::pesanErorForm($errors->first('no_rekening_pembayarans'))}}
                                </div>
                                <div class="form-group">
                                    <label class="form-col-form-label" for="nama_rekening_pembayarans">Nama Rekening</label>
                                    <input class="form-control {{ Yeah::validForm($errors->first('nama_rekening_pembayarans')) }}" id="nama_rekening_pembayarans" type="text" name="nama_rekening_pembayarans" value="{{Request::old('nama_rekening_pembayarans')}}">
                                    {{Yeah::pesanErorForm($errors->first('nama_rekening_pembayarans'))}}
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
	                    	@php($ambil_kembali = URL('dashboard/pembayaran'))
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