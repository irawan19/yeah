@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/registrasi_event/prosesedit/'.$edit_registrasi_events->id_registrasi_events) }}" method="POST">
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
                                            <option value="{{$tickets->id_tickets}}" data-harga="{{Yeah::ubahDBKeHarga($tickets->harga_tickets)}}" {{ $selected }}>{{$tickets->nama_events.' - '.$tickets->nama_tickets.' ('.$tickets->sisa_kuota_tickets.')'}}</option>
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
                                    <label class="form-col-form-label" for="bukti_pembayaran_registrasi_events">Bukti Pembayaran <b style="color:red">*</b></label>
                                    <input class="form-control {{ Yeah::validForm($errors->first('bukti_pembayaran_registrasi_events')) }}" id="bukti_pembayaran_registrasi_events" type="text" name="bukti_pembayaran_registrasi_events" value="{{Request::old('bukti_pembayaran_registrasi_events') == '' ? $edit_registrasi_events->bukti_pembayaran_registrasi_events : Request::old('bukti_pembayaran_registrasi_events')}}">
                                    {{Yeah::pesanErorForm($errors->first('bukti_pembayaran_registrasi_events'))}}
                                </div>
                            </div>
                        </div>
                        @if(empty(Request::old('nama_registrasi_event_details')))
                            @php($total_form = 0)
							@if(!$edit_registrasi_event_details->isEmpty())
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
													@if($total_form == (count($edit_registrasi_event_details) - 1))
												    	<button type="button" onclick="tambahForm({{$total_form}})" class="btn btn-primary btn-md buttontambah" id="buttontambahform{{$total_form}}">Tambah</button>
												    @else
												    	<button type="button" onclick="tambahForm({{$total_form}})" class="btn btn-primary btn-md buttontambah" id="buttontambahform{{$total_form}}" style="display: none">Tambah</button>
												    @endif

												    <button type="button" onclick="hapusForm({{$total_form}})" class="btn btn-danger btn-md buttonhapus" id="buttonhapusform{{$total_form}}">Hapus</button>
												</div>
                                            </div>
                                        </div>
                                    </div>
                                    @php($total_form++)
                                @endforeach
                            @endif
                        @else
                            @php($get_total_form = count(Request::old('nama_registrasi_event_details')))
				            @for($total_form = 0; $total_form < $get_total_form; $total_form++)
                                <div id="dynamicform{{$total_form}}" class="formregistrasi">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h4>{{$total_form+1}}<hr/></h4>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-col-form-label" for="nama_registrasi_event_details{{$total_form}}">Nama <b style="color:red">*</b></label>
                                                <input class="form-control {{ Yeah::validForm($errors->first('nama_registrasi_event_details.'.$total_form)) }}" id="nama_registrasi_event_details{{$total_form}}" type="text" name="nama_registrasi_event_details[]" value="{{Request::old('nama_registrasi_event_details.'.$total_form)}}">
                                                {{Yeah::pesanErorForm($errors->first('nama_registrasi_event_details.'.$total_form))}}
                                            </div>
                                            <div class="form-group">
                                                <label class="form-col-form-label" for="email_registrasi_event_details0">Email <b style="color:red">*</b></label>
                                                <input class="form-control {{ Yeah::validForm($errors->first('email_registrasi_event_details.'.$total_form)) }}" id="email_registrasi_event_details{{$total_form}}" type="email" name="email_registrasi_event_details[]" value="{{Request::old('email_registrasi_event_details.'.$total_form)}}">
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
                                                                <option value="{{$jenis_kelamins->id_jenis_kelamins}}" {{ Request::old('jenis_kelamins_id.'.$total_form) == $jenis_kelamins->id_jenis_kelamins ? $select='selected' : $select='' }}>{{$jenis_kelamins->nama_jenis_kelamins}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-col-form-label" for="tanggal_lahir_registrasi_event_details{{$total_form}}">Tanggal Lahir <b style="color:red">*</b></label>
                                                        <input class="form-control {{ Yeah::validForm($errors->first('tanggal_lahir_registrasi_event_details.'.$total_form)) }}" id="tanggal_lahir_registrasi_event_details{{$total_form}}" type="date" name="tanggal_lahir_registrasi_event_details[]" value="{{Request::old('tanggal_lahir_registrasi_event_details.'.$total_form)}}">
                                                        {{Yeah::pesanErorForm($errors->first('tanggal_lahir_registrasi_event_details.'.$total_form))}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-col-form-label" for="telepon_registrasi_event_details{{$total_form}}">Telepon <b style="color:red">*</b></label>
                                                <input class="form-control {{ Yeah::validForm($errors->first('telepon_registrasi_event_details.'.$total_form)) }}" id="telepon_registrasi_event_details{{$total_form}}" type="number" name="telepon_registrasi_event_details[]" value="{{Request::old('telepon_registrasi_event_details.'.$total_form)}}">
                                                {{Yeah::pesanErorForm($errors->first('telepon_registrasi_event_details.'.$total_form))}}
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <h4><hr/></h4>
                                        </div>
                                        <div class="col-12 col-center text-center">
                                            <div class="form-group" style="margin-top: 35px;">
												@if($total_form == $get_total_form - 1)
											    	<button type="button" onclick="tambahForm({{$total_form}})" class="btn btn-primary btn-sm buttontambah" id="buttontambahform{{$total_form}}">Tambah</button>
											    @else
											    	<button type="button" onclick="tambahForm({{$total_form}})" class="btn btn-primary btn-sm buttontambah" id="buttontambahform{{$total_form}}" style="display: none;">Tambah</button>
											    @endif

											    @if($get_total_form == 1)
											    	<button type="button" onclick="hapusForm({{$total_form}})" class="btn btn-danger btn-sm buttonhapus" id="buttonhapusform{{$total_form}}" style="display: none; margin-left: 20px;">Hapus</button>
												@else
											    	<button type="button" onclick="hapusForm({{$total_form}})" class="btn btn-danger btn-sm buttonhapus" id="buttonhapusform{{$total_form}}" style="margin-left:20px">Hapus</button>
												@endif
											</div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        @endif
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
        function hapusForm(no_form)
        {
            var gettotalform 	= $('.formregistrasi').length;
            if(gettotalform != 1)
            {
                no_form_minus = no_form - 1;
                if(no_form_minus != 0)
                {
                    attr = $('#buttontambahform'+no_form).attr('style');
                    if (typeof attr !== typeof undefined && attr !== '') {
                        $('#buttontambahform'+no_form_minus).hide();
                    }
                    else
                        $('#buttontambahform'+no_form_minus).show();
                }
            }

            $('#dynamicform'+no_form).remove();
            var gettotalform 	= $('.formregistrasi').length;
            if(gettotalform == 1)
            {
                $('.buttonedit').show();
                $('.buttonhapus').hide();
            }
            else
            {
                var gettotaledit = $('.buttonedit').length;
                $('#buttontambahform'+(gettotaledit - 1)).show();
            }
        }

        function tambahForm(no_form){
            noform          = no_form + 2;
            no_form_plus 	= no_form + 1;
            var component_item = $('<div id="dynamicform'+no_form_plus+'" class="formregistrasi">'+
                                    '<div class="row">'+
                                        '<div class="col-sm-12">'+
                                            '<h4>'+noform+'<hr/></h4>'+
                                        '</div>'+
                                        '<div class="col-sm-6">'+
                                            '<div class="form-group">'+
                                                '<label class="form-col-form-label" for="nama_registrasi_event_details'+no_form_plus+'">Nama <b style="color:red">*</b></label>'+
                                                '<input class="form-control {{ Yeah::validForm($errors->first("nama_registrasi_event_details.'+no_form_plus+'")) }}" id="nama_registrasi_event_details'+no_form_plus+'" type="text" name="nama_registrasi_event_details[]" value="{{Request::old("nama_registrasi_event_details.'+no_form_plus+'")}}">'+
                                            '</div>'+
                                            '<div class="form-group">'+
                                                '<label class="form-col-form-label" for="email_registrasi_event_details'+no_form_plus+'">Email <b style="color:red">*</b></label>'+
                                                '<input class="form-control {{ Yeah::validForm($errors->first("email_registrasi_event_details.'+no_form_plus+'")) }}" id="email_registrasi_event_details'+no_form_plus+'" type="email" name="email_registrasi_event_details[]" value="{{Request::old("email_registrasi_event_details.'+no_form_plus+'")}}">'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="col-sm-6">'+
                                            '<div class="row">'+
                                                '<div class="col-sm-6">'+
                                                    '<div class="form-group">'+
                                                        '<label class="form-col-form-label" for="jenis_kelamins_id'+no_form_plus+'">Jenis Kelamin <b style="color:red">*</b></label>'+
                                                        '<select class="form-control select2" id="jenis_kelamins_id'+no_form_plus+'" name="jenis_kelamins_id[]">'+
                                                            @foreach($edit_jenis_kelamins as $jenis_kelamins)
                                                                '<option value="{{$jenis_kelamins->id_jenis_kelamins}}" {{ Request::old("jenis_kelamins_id.'+no_form_plus+'") == $jenis_kelamins->id_jenis_kelamins ? $select='selected' : $select='' }}>{{$jenis_kelamins->nama_jenis_kelamins}}</option>'+
                                                            @endforeach
                                                        '</select>'+
                                                    '</div>'+
                                                '</div>'+
                                                '<div class="col-sm-6">'+
                                                    '<div class="form-group">'+
                                                        '<label class="form-col-form-label" for="tanggal_lahir_registrasi_event_details'+no_form_plus+'">Tanggal Lahir <b style="color:red">*</b></label>'+
                                                        '<input class="form-control {{ Yeah::validForm($errors->first("tanggal_lahir_registrasi_event_details.'+no_form_plus+'")) }}" id="tanggal_lahir_registrasi_event_details'+no_form_plus+'" type="date" name="tanggal_lahir_registrasi_event_details[]" value="{{Request::old("tanggal_lahir_registrasi_event_details.'+no_form_plus+'")}}">'+
                                                    '</div>'+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="form-group">'+
                                                '<label class="form-col-form-label" for="telepon_registrasi_event_details'+no_form_plus+'">Telepon <b style="color:red">*</b></label>'+
                                                '<input class="form-control {{ Yeah::validForm($errors->first("telepon_registrasi_event_details.'+no_form_plus+'")) }}" id="telepon_registrasi_event_details'+no_form_plus+'" type="number" name="telepon_registrasi_event_details[]" value="{{Request::old("telepon_registrasi_event_details.'+no_form_plus+'")}}">'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="col-sm-12">'+
                                            '<h4><hr/></h4>'+
                                        '</div>'+
                                        '<div class="col-12 col-center text-center">'+
                                            '<div class="form-group" style="margin-top: 35px;">'+
                                                '<button type="button" onclick="tambahForm('+no_form_plus+')" class="btn btn-primary btn-md buttontambah" id="buttontambahform'+no_form_plus+'">Tambah</button>'+
                                                '<button type="button" onclick="hapusForm('+no_form_plus+')" class="btn btn-danger btn-md buttonhapus" id="buttonhapusform'+no_form_plus+'" style="margin-left:20px">Hapus</button>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>');
            component_item.find(".select2").select2({width:'100%'});
            component_item.insertAfter("#dynamicform"+no_form);
            $('#buttontambahform'+no_form).hide();
            $('#buttonhapusform'+no_form).show();
        }

        $('#harga_tickets').val($('#tickets_id :selected').data('harga'));
        jQuery(document).ready(function () {
            $('#tickets_id').on('change',function(){
                $('#harga_tickets').val($('#tickets_id :selected').data('harga'));
            });
        });
    </script>

@endsection