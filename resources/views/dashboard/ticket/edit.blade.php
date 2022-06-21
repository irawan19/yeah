@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/ticket/prosesedit/'.$edit_tickets->id_tickets) }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Edit Ticket</strong>
					</div>
					<div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-col-form-label" for="events_id">Event <b style="color:red">*</b></label>
                                <select class="form-control select2" id="events_id" name="events_id">
                                    @foreach($edit_events as $events)
                                        @php($selected = '')
					                    @if(Request::old('events_id') == '')
					                    	@if($events->id_events == $edit_tickets->events_id)
					                    		@php($selected = 'selected')
					                    	@endif
					                    @else
					                    	@if($events->id_events == Request::old('events_id'))
					                    		@php($selected = 'selected')
					                    	@endif
					                    @endif
                                        <option value="{{$events->id_events}}" {{ $selected }}>{{$events->nama_events}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-col-form-label" for="nama_tickets">Nama <b style="color:red">*</b></label>
                                <input class="form-control {{ Yeah::validForm($errors->first('nama_tickets')) }}" id="nama_tickets" type="text" name="nama_tickets" value="{{Request::old('nama_tickets') == '' ? $edit_tickets->nama_tickets : Request::old('nama_tickets')}}">
                                {{Yeah::pesanErorForm($errors->first('nama_tickets'))}}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-col-form-label" for="harga_tickets">Harga <b style="color:red">*</b></label>
                                <input class="form-control {{ Yeah::validForm($errors->first('harga_tickets')) }} price-format" id="harga_tickets" type="text" name="harga_tickets" value="{{Request::old('harga_tickets') == '' ? Yeah::ubahDBKeHarga($edit_tickets->harga_tickets) : Request::old('harga_tickets')}}">
                                {{Yeah::pesanErorForm($errors->first('harga_tickets'))}}
                            </div>
                            <div class="form-group">
                                <label class="form-col-form-label" for="kuota_tickets">Kuota <b style="color:red">*</b></label>
                                <input class="form-control {{ Yeah::validForm($errors->first('kuota_tickets')) }}" id="kuota_tickets" type="number" name="kuota_tickets" value="{{Request::old('kuota_tickets') == '' ? $edit_tickets->kuota_tickets : Request::old('kuota_tickets')}}">
                                {{Yeah::pesanErorForm($errors->first('kuota_tickets'))}}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-col-form-label" for="deskripsi_tickets">Deskripsi <b style="color:red">*</b></label>
                                <textarea class="form-control {{ Yeah::validForm($errors->first('deskripsi_tickets')) }}" id="editor2" name="deskripsi_tickets" rows="5">{{Request::old('deskripsi_tickets') == '' ? $edit_tickets->deskripsi_tickets : Request::old('deskripsi_tickets')}}</textarea>
                                {{Yeah::pesanErorForm($errors->first('deskripsi_tickets'))}}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-col-form-label" for="disclaimer_tickets">Disclaimer <b style="color:red">*</b></label>
                                <textarea class="form-control {{ Yeah::validForm($errors->first('disclaimer_tickets')) }}" id="editor1" name="disclaimer_tickets" rows="5">{{Request::old('disclaimer_tickets') == '' ? $edit_tickets->disclaimer_tickets : Request::old('disclaimer_tickets')}}</textarea>
                                {{Yeah::pesanErorForm($errors->first('disclaimer_tickets'))}}
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
	                    	@php($ambil_kembali = URL('dashboard/ticket'))
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