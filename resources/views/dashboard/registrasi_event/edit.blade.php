@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" enctype="multipart/form-data" action="{{ URL('dashboard/registrasi_event/prosesedit/'.$edit_registrasi_events->id_registrasi_events) }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Edit Registrasi Event</strong>
					</div>
					<div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-col-form-label" for="tickets_id">Ticket Event <b style="color:red">*</b></label>
                                    <select class="form-control select2" id="tickets_id" name="tickets_id">
                                        @foreach($edit_tickets as $tickets)
                                            @php($selected = '')
					                        @if(Request::old('tickets_id') == '')
					                        	@if($tickets->id_tickets == $edit_registrasi_events->tickets_id)
					                        		@php($selected = 'selected')
					                        	@endif
					                        @else
					                        	@if($tickets->id_tickets == Request::old('tickets_id'))
					                        		@php($selected = 'selected')
					                        	@endif
					                        @endif
                                            <option value="{{$tickets->id_tickets}}" data-maxpemesanan="{{$tickets->max_pemesanan_tickets}}" data-harga="{{Yeah::ubahDBKeHarga($tickets->harga_tickets)}}" {{ $selected }}>{{$tickets->nama_events.' - '.$tickets->nama_tickets.' ('.$tickets->sisa_kuota_tickets.')'}}</option>
                                        @endforeach
                                    </select>
                                </div>
								<div class="form-group">
									<label class="form-col-form-label" for="harga_tickets">Harga <b style="color:red">*</b></label>
									<input class="form-control {{ Yeah::validForm($errors->first('harga_tickets')) }}" id="harga_tickets" type="text" name="harga_tickets" value="{{Yeah::ubahDBKeHarga($tickets->harga_registrasi_events)}}" readonly>
									{{Yeah::pesanErorForm($errors->first('harga_tickets'))}}
								</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-col-form-label" for="pembayarans_id">Pembayaran<b style="color:red">*</b></label>
                                    <select class="form-control select2" id="pembayarans_id" name="pembayarans_id">
                                        @foreach($edit_pembayarans as $pembayarans)
                                            @php($selected = '')
					                        @if(Request::old('pembayarans_id') == '')
					                        	@if($pembayarans->id_pembayarans == $edit_registrasi_events->pembayarans_id)
					                        		@php($selected = 'selected')
					                        	@endif
					                        @else
					                        	@if($pembayarans->id_pembayarans == Request::old('pembayarans_id'))
					                        		@php($selected = 'selected')
					                        	@endif
					                        @endif
                                            <option value="{{$pembayarans->id_pembayarans}}" {{ $selected }}>{{$pembayarans->nama_pembayarans}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-col-form-label" for="status_pembayarans_id">Status Pembayaran<b style="color:red">*</b></label>
                                    <select class="form-control select2" id="status_pembayarans_id" name="status_pembayarans_id">
                                        @foreach($edit_status_pembayarans as $status_pembayarans)
                                            @php($selected = '')
					                        @if(Request::old('status_pembayarans_id') == '')
					                        	@if($status_pembayarans->id_status_pembayarans == $edit_registrasi_events->status_pembayarans_id)
					                        		@php($selected = 'selected')
					                        	@endif
					                        @else
					                        	@if($status_pembayarans->id_status_pembayarans == Request::old('status_pembayarans_id'))
					                        		@php($selected = 'selected')
					                        	@endif
					                        @endif
                                            <option value="{{$status_pembayarans->id_status_pembayarans}}" {{ $selected }}>{{$status_pembayarans->nama_status_pembayarans}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
									<label class="form-col-form-label" for="userfile_bukti_pembayaran">Bukti Pembayaran</label>
									<br/>
                                    @if(!empty($edit_registrasi_events->bukti_pembayaran_registrasi_events) && $edit_registrasi_events->bukti_pembayaran_registrasi_events != $edit_registrasi_events->no_registrasi_events)
                                        <div class="form-group center-align">
                                            <a data-fancybox="gallery" href="{{URL::asset($edit_registrasi_events->bukti_pembayaran_registrasi_events)}}">
                                                <img src="{{URL::asset($edit_registrasi_events->bukti_pembayaran_registrasi_events)}}" width="108">
                                            </a>
                                        </div>
                                    @endif
			                        <input id="userfile_bukti_pembayaran" type="file" name="userfile_bukti_pembayaran">
			                    </div>
								{{Yeah::pesanErorFormFile($errors->first('userfile_bukti_pembayaran'))}}
                            </div>
                        </div>
                        @php($total_form = 0)
                        @foreach($edit_registrasi_event_details as $registrasi_event_details)
                            <div id="dynamicform{{$total_form}}" class="formregistrasi">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h4>{{$total_form+1}}<hr/></h4>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-col-form-label" for="nama_registrasi_event_details{{$total_form}}">Nama <b style="color:red">*</b></label>
                                            <input class="form-control {{ Yeah::validForm($errors->first('nama_registrasi_event_details.'.$total_form)) }}" id="nama_registrasi_event_details{{$total_form}}" type="text" name="nama_registrasi_event_details[]" value="{{Request::old('nama_registrasi_event_details.'.$total_form) == '' ? $registrasi_event_details->nama_registrasi_event_details : Request::old('nama_registrasi_event_details.'.$total_form)}}">
                                            {{Yeah::pesanErorForm($errors->first('nama_registrasi_event_details.'.$total_form))}}
                                        </div>
                                        <div class="form-group">
                                            <label class="form-col-form-label" for="email_registrasi_event_details0">Email <b style="color:red">*</b></label>
                                            <input class="form-control {{ Yeah::validForm($errors->first('email_registrasi_event_details.'.$total_form)) }}" id="email_registrasi_event_details{{$total_form}}" type="email" name="email_registrasi_event_details[]" value="{{Request::old('email_registrasi_event_details.'.$total_form) == '' ? $registrasi_event_details->email_registrasi_event_details : Request::old('email_registrasi_event_details.'.$total_form)}}">
                                            {{Yeah::pesanErorForm($errors->first('email_registrasi_event_details.'.$total_form))}}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-col-form-label" for="jenis_kelamins_id{{$total_form}}">Jenis Kelamin <b style="color:red">*</b></label>
                                                    <select class="form-control select2" id="jenis_kelamins_id{{$total_form}}" name="jenis_kelamins_id[]">
                                                        @foreach($edit_jenis_kelamins as $jenis_kelamins)
                                                            @php($selected = '')
                                                            @if(Request::old('jenis_kelamins_id') == '')
                                                                @if($jenis_kelamins->id_jenis_kelamins == $registrasi_event_details->jenis_kelamins_id)
                                                                    @php($selected = 'selected')
                                                                @endif
                                                            @else
                                                                @if($jenis_kelamins->id_jenis_kelamins == Request::old('jenis_kelamins_id'))
                                                                    @php($selected = 'selected')
                                                                @endif
                                                            @endif
                                                            <option value="{{$jenis_kelamins->id_jenis_kelamins}}" {{ $selected }}>{{$jenis_kelamins->nama_jenis_kelamins}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-col-form-label" for="tanggal_lahir_registrasi_event_details{{$total_form}}">Tanggal Lahir <b style="color:red">*</b></label>
                                                    <input class="form-control {{ Yeah::validForm($errors->first('tanggal_lahir_registrasi_event_details.'.$total_form)) }}" id="tanggal_lahir_registrasi_event_details{{$total_form}}" type="date" name="tanggal_lahir_registrasi_event_details[]" value="{{Request::old('tanggal_lahir_registrasi_event_details.'.$total_form) == '' ? $registrasi_event_details->tanggal_lahir_registrasi_event_details : Request::old('tanggal_lahir_registrasi_event_details.'.$total_form)}}">
                                                    {{Yeah::pesanErorForm($errors->first('tanggal_lahir_registrasi_event_details.'.$total_form))}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-col-form-label" for="telepon_registrasi_event_details{{$total_form}}">Telepon <b style="color:red">*</b></label>
                                            <input class="form-control {{ Yeah::validForm($errors->first('telepon_registrasi_event_details.'.$total_form)) }}" id="telepon_registrasi_event_details{{$total_form}}" type="number" name="telepon_registrasi_event_details[]" value="{{Request::old('telepon_registrasi_event_details.'.$total_form) == '' ? $registrasi_event_details->telepon_registrasi_event_details : Request::old('telepon_registrasi_event_details.'.$total_form)}}">
                                            {{Yeah::pesanErorForm($errors->first('telepon_registrasi_event_details.'.$total_form))}}
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <h4><hr/></h4>
                                    </div>
                                    <div class="col-12 col-center text-center">
                                        <div class="form-group" style="margin-top: 35px;">
                                            @if($total_form != 0)
                                                <button type="button" onclick="kosongkanForm({{$total_form}})" class="btn btn-danger btn-md buttonkosongkan" id="buttonkosongkanform{{$total_form}}" style="margin-left:20px">Kosongkan</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php($total_form++)
                        @endforeach
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
	                    	@php($ambil_kembali = URL('dashboard/registrasi_event'))
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
        function kosongkanForm(idForm)
        {
            $('#jenis_kelamins_id'+idForm).val(1).trigger('change');
            $('#nama_registrasi_event_details'+idForm).val("");
            $('#email_registrasi_event_details'+idForm).val("");
            $('#tanggal_lahir_registrasi_event_details'+idForm).val("");
            $('#telepon_registrasi_event_details'+idForm).val("");
        }
    </script>

@endsection