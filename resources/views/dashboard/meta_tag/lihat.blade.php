@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
        @if(!$lihat_meta_tags->isEmpty())
            @foreach($lihat_meta_tags as $meta_tags)
                @php($id_meta_tags = $meta_tags->id_meta_tags)
                <div class="col-sm-6">
                    <div class="card">
                        <form class="form-horizontal m-t-40" action="{{ URL('dashboard/meta_tag/prosesedit/'.$id_meta_tags) }}" method="POST">
                            {{ csrf_field() }}
                            <div class="card-header">
                                <strong>Meta Tag {{$meta_tags->nama_meta_tags}}</strong>
                            </div>
                            <div class="card-body">
                                @if (Session::get('setelah_simpan'.$id_meta_tags.'.alert') == 'sukses')
                                    {{ Yeah::pesanSuksesForm(Session::get('setelah_simpan'.$id_meta_tags.'.text')) }}
                                @endif
                                <div class="form-group">
                                    <label class="form-col-form-label" for="nama_meta_tags{{$id_meta_tags}}">Nama <b style="color:red">*</b></label>
                                    <input class="form-control {{ Yeah::validForm($errors->first('nama_meta_tags.'.$id_meta_tags)) }}" id="nama_meta_tags{{$id_meta_tags}}" type="text" name="nama_meta_tags[{{$id_meta_tags}}]" value="{{Request::old('nama_meta_tags.'.$id_meta_tags) == '' ? $meta_tags->nama_meta_tags : Request::old('nama_meta_tags.'.$id_meta_tags)}}">
                                    {{Yeah::pesanErorForm($errors->first('nama_meta_tags.'.$id_meta_tags))}}
                                </div>
                                <div class="form-group">
                                    <label class="form-col-form-label" for="konten_meta_tags{{$id_meta_tags}}">Konten <b style="color:red">*</b></label>
                                    <textarea class="form-control code-html {{ Yeah::validForm($errors->first('konten_meta_tags.'.$id_meta_tags)) }}" id="konten_meta_tags{{$id_meta_tags}}" name="konten_meta_tags[{{$id_meta_tags}}]" rows="5">{{Request::old('konten_meta_tags.'.$id_meta_tags) == '' ? $meta_tags->konten_meta_tags : Request::old('konten_meta_tags.'.$id_meta_tags)}}</textarea>
                                    {{Yeah::pesanErorForm($errors->first('konten_meta_tags.'.$id_meta_tags))}}
                                </div>
                            </div>
                            <div class="card-footer right-align">
                                <button class="btn btn-sm btn-primary" type="submit">
                                    <svg class="c-icon" style="margin-right:5px;">
                                        <use xlink:href="{{URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-pencil')}}"></use>
                                    </svg> Perbarui
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <script type="text/javascript">
        jQuery(document).ready(function () {
            var code_type = '';
            $('.code-html').each(function(index) {
                $(this).attr('id', 'konten_meta_tags' + index);
                CodeMirror.fromTextArea(document.getElementById('konten_meta_tags' + index), {
                        mode: "xml",
                        htmlMode: true,
                        lineNumbers: true,
                        tabMode: "indent"
                    }
                );

            });
        });
    </script>

@endsection