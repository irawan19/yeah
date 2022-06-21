@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" enctype="multipart/form-data" action="{{ URL('dashboard/promo/prosesedit/'.$edit_promos->id_promos) }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Edit Promo</strong>
					</div>
					<div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
									<label class="form-col-form-label" for="userfile_gambar_promo">Gambar <b style="color:red">*</b></label>
									<br/>
									<div class="form-group center-align">
										<a data-fancybox="gallery" href="{{URL::asset($edit_promos->gambar_promos)}}">
											<img src="{{URL::asset($edit_promos->gambar_promos)}}" width="108">
										</a>
									</div>
			                        <input id="userfile_gambar_promo" type="file" name="userfile_gambar_promo">
			                    </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-col-form-label" for="events_id">Event <b style="color:red">*</b></label>
                                    <select class="form-control select2" id="events_id" name="events_id">
                                        @foreach($edit_events as $events)
                                            @php($selected = '')
                                            @if(Request::old('events_id') == '')
                                                @if($events->id_events == $edit_promos->events_id)
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
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-col-form-label" for="nama_promos">Nama <b style="color:red">*</b></label>
                                    <input class="form-control {{ Yeah::validForm($errors->first('nama_promos')) }}" id="nama_promos" type="text" name="nama_promos" value="{{Request::old('nama_promos') == '' ? $edit_promos->nama_promos : Request::old('nama_promos')}}">
                                    {{Yeah::pesanErorForm($errors->first('nama_promos'))}}
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-col-form-label" for="deskripsi_promos">Deskripsi <b style="color:red">*</b></label>
                                    <textarea class="form-control {{ Yeah::validForm($errors->first('deskripsi_promos')) }}" id="editor2" name="deskripsi_promos" rows="5">{{Request::old('deskripsi_promos') == '' ? $edit_promos->deskripsi_promos : Request::old('deskripsi_promos')}}</textarea>
                                    {{Yeah::pesanErorForm($errors->first('deskripsi_promos'))}}
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