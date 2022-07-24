@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" enctype="multipart/form-data" action="{{ URL('dashboard/promo/prosestambah') }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Tambah Promo</strong>
					</div>
					<div class="card-body">
						@if (Session::get('setelah_simpan.alert') == 'sukses')
					    	{{ Yeah::pesanSuksesForm(Session::get('setelah_simpan.text')) }}
					    @endif
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
									<label class="form-col-form-label" for="userfile_gambar_promo">Gambar <b style="color:red">*</b></label>
									<br/>
			                        <input id="userfile_gambar_promo" type="file" name="userfile_gambar_promo">
			                    </div>
								{{Yeah::pesanErorFormFile($errors->first('userfile_gambar_promo'))}}
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-col-form-label" for="nama_promos">Nama <b style="color:red">*</b></label>
                                    <input class="form-control {{ Yeah::validForm($errors->first('nama_promos')) }}" id="nama_promos" type="text" name="nama_promos" value="{{Request::old('nama_promos')}}">
                                    {{Yeah::pesanErorForm($errors->first('nama_promos'))}}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-col-form-label" for="events_id">Event</label>
                                    <select class="form-control select2" id="events_id" name="events_id">
										<option value="0">Semua Event</option>
                                        @foreach($tambah_events as $events)
                                            <option value="{{$events->id_events}}" {{ Request::old('events_id') == $events->id_events ? $select='selected' : $select='' }}>{{$events->nama_events}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-col-form-label" for="tanggal_promos">Tanggal <b style="color:red">*</b></label>
                                    <input readonly class="form-control getStartEndDateTime {{ Yeah::validForm($errors->first('tanggal_promos')) }}" id="tanggal_promos" type="text" name="tanggal_promos" value="{{Request::old('tanggal_promos') == '' ? Yeah::ubahDBKeTanggalWaktu(date('Y-m-d H:i:00')).' sampai '.Yeah::ubahDBKeTanggalWaktu(date('Y-m-d H:i:00', strtotime(date('Y-m-d H:i:00'). ' + 1 days'))) : Request::old('tanggal_promos')}}">
                                    {{Yeah::pesanErorForm($errors->first('tanggal_promos'))}}
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-col-form-label" for="deskripsi_promos">Deskripsi <b style="color:red">*</b></label>
                                    <textarea class="form-control {{ Yeah::validForm($errors->first('deskripsi_promos')) }}" id="editor2" name="deskripsi_promos" rows="5">{{Request::old('deskripsi_promos')}}</textarea>
                                    {{Yeah::pesanErorForm($errors->first('deskripsi_promos'))}}
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
	                    	@php($ambil_kembali = URL('dashboard/promo'))
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