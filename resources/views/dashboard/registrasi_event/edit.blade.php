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
                                    @if(!empty($edit_registrasi_events->bukti_pembayaran_registrasi_events))
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
                        <div class="formeventregistrasidetails"></div>
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
        jQuery(document).ready(function () {
            maxpemesanantickets = $('#tickets_id :selected').data('maxpemesanan');
            $.ajax({
                headers: { 'X-CSRF-Token': $('meta[name=_token]').attr('content') },
                type: "POST",
                url: "{{URL('/dashboard/registrasi_event/ambilformregistrasidetails')}}",
                data: {max:maxpemesanantickets,id:"{{$edit_registrasi_events->id_registrasi_events}}"},
                success: function(data){
                    $('.formeventregistrasidetails').html(data)
                },
            });
            $('#harga_tickets').val($('#tickets_id :selected').data('harga'));
            $('#tickets_id').on('change',function(){
                maxpemesanantickets = $('#tickets_id :selected').data('maxpemesanan');
                $.ajax({
                    headers: { 'X-CSRF-Token': $('meta[name=_token]').attr('content') },
                    type: "POST",
                    url: "{{URL('/dashboard/registrasi_event/ambilformregistrasidetails')}}",
                    data: {max:maxpemesanantickets,id:"{{$edit_registrasi_events->id_registrasi_events}}"},
                    success: function(data){
                        $('.formeventregistrasidetails').html(data)
                    },
                });
                $('#harga_tickets').val($('#tickets_id :selected').data('harga'));
            });
        });
    </script>

@endsection