@if(!$edit_registrasi_event_details->isEmpty())
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
@else
    @php($get_total_form = $max_pemesanan_tickets)
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
                        @if($get_total_form == 1)
                            <button type="button" onclick="kosongkanForm({{$total_form}})" class="btn btn-danger btn-md buttonkosongkan" id="buttonkosongkanform{{$total_form}}" style="display: none; margin-left: 20px;">Kosongkan</button>
                        @else
                            @if($total_form != 0)
                                <button type="button" onclick="kosongkanForm({{$total_form}})" class="btn btn-danger btn-md buttonkosongkan" id="buttonkosongkanform{{$total_form}}" style="margin-left:20px">Kosongkan</button>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endfor
@endif