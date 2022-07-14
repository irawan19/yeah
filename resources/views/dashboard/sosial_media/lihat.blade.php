@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-sm-6">
							<strong>Sosial Media</strong>
						</div>
						<div class="col-sm-6">
							<div class="right-align">
								{{ Yeah::tambah($link_sosial_media,'dashboard/sosial_media/tambah') }}
							</div>
						</div>
					</div>
				</div>
				<div class="card-body">
					<form method="GET" action="{{ URL('dashboard/sosial_media/cari') }}">
						@csrf
	                	<div class="input-group">
	                		<input class="form-control" id="input2-group2" type="text" name="cari_kata" placeholder="Cari" value="{{$hasil_kata}}">
	                		<span class="input-group-append">
	                		  	<button class="btn btn-primary" type="submit"> Cari</button>
	                		</span>
	                	</div>
	                </form>
	            	<br/>
	            	<div class="scrolltable">
                        <table id="tablesort" class="table table-responsive-sm table-bordered table-striped table-sm">
				    		<thead>
				    			<tr>
				    				@if(Yeah::totalHakAkses($link_sosial_media) != 0)
						    			<th width="5px"></th>
						    		@endif
				    				<th class="nowrap">Nama</th>
				    				<th class="nowrap">URL</th>
				    			</tr>
				    		</thead>
				    		<tbody>
				    			@if(!$lihat_sosial_medias->isEmpty())
		            				@foreach($lihat_sosial_medias as $sosial_medias)
								    	<tr>
								    		@if(Yeah::totalHakAkses($link_sosial_media) != 0)
								    			<td class="nowrap">
											      	<div class="dropdown">
										            	<button class="btn btn-sm btn-primary dropdown-toggle" id="dropdownMenu2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
										            	<div class="dropdown-menu" aria-labelledby="dropdownMenu2" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 34px, 0px); top: 0px; left: 0px; will-change: transform;">
										            		{{Yeah::edit($link_sosial_media,'dashboard/sosial_media/edit/'.$sosial_medias->id_sosial_medias)}}
										            		<div class="dropdown-divider"></div>
										            		{{Yeah::hapus($link_sosial_media,'dashboard/sosial_media/hapus/'.$sosial_medias->id_sosial_medias, $sosial_medias->id_sosial_medias.' - '.$sosial_medias->nama_sosial_medias)}}
										            	</div>
										            </div>
											    </td>
								    		@endif
								    		<td class="nowrap">{{$sosial_medias->nama_sosial_medias}}</td>
								    		<td class="nowrap">
								    			<a href="{{$sosial_medias->url_sosial_medias}}" target="_blank">Klik untuk melihat {{$sosial_medias->nama_sosial_medias}}</a>
								    		</td>
								    	</tr>
								    @endforeach
								@else
									<tr>
										@if(Yeah::totalHakAkses($link_sosial_media) != 0)
											<td colspan="3" class="center-align">Tidak ada data ditampilkan</td>
											<td style="display:none"></td>
											<td style="display:none"></td>
										@else
											<td colspan="2" class="center-align">Tidak ada data ditampilkan</td>
											<td style="display:none"></td>
										@endif
									</tr>
								@endif
				    		</tbody>
				    	</table>
				    </div>
				</div>
			</div>
		</div>
	</div>

@endsection