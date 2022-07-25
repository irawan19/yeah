@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-sm-6">
							<strong>Pembayaran</strong>
						</div>
						<div class="col-sm-6">
							<div class="right-align">
								{{ Yeah::tambah($link_pembayaran,'dashboard/pembayaran/tambah') }}
							</div>
						</div>
					</div>
				</div>
				<div class="card-body">
					<form method="GET" action="{{ URL('dashboard/pembayaran/cari') }}">
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
				    				@if(Yeah::totalHakAkses($link_pembayaran) != 0)
					    				<th class="nowrap" width="5px"></th>
					    			@endif
				    				<th class="nowrap" width="50px">No</th>
				    				<th class="nowrap">Tipe</th>
				    				<th class="nowrap">Logo</th>
				    				<th class="nowrap">Nama</th>
				    			</tr>
				    		</thead>
				    		<tbody>
				    			@if(!$lihat_pembayarans->isEmpty())
					    			@php($no = 1)
		            				@foreach($lihat_pembayarans as $pembayarans)
								    	<tr>
					    					@if(Yeah::totalHakAkses($link_pembayaran) != 0)
					    						<td class="nowrap">
											      	<div class="dropdown">
										            	<button class="btn btn-sm btn-success dropdown-toggle" id="dropdownMenu2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
										            	<div class="dropdown-menu" aria-labelledby="dropdownMenu2" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 34px, 0px); top: 0px; left: 0px; will-change: transform;">
										            		{{Yeah::baca($link_pembayaran,'dashboard/pembayaran/baca/'.$pembayarans->id_pembayarans)}}
										            		<div class="dropdown-divider"></div>
										            		{{Yeah::edit($link_pembayaran,'dashboard/pembayaran/edit/'.$pembayarans->id_pembayarans)}}
                                                            @if($pembayarans->id_pembayarans != 1)
                                                                <div class="dropdown-divider"></div>
                                                                {{Yeah::hapus($link_pembayaran,'dashboard/pembayaran/hapus/'.$pembayarans->id_pembayarans, $pembayarans->nama_pembayarans)}}
                                                            @endif
                                                        </div>
										            </div>
											    </td>
									    	@endif
								    		<td class="nowrap">{{$no}}</td>
								    		<td class="nowrap">{{$pembayarans->nama_tipe_pembayarans}}</td>
								    		<td class="nowrap">
                                                <a data-fancybox="gallery" href="{{URL::asset($pembayarans->logo_pembayarans)}}">
                                                    <img src="{{ URL::asset($pembayarans->logo_pembayarans) }}" width="50">
                                                </a>
                                            </td>
								    		<td class="nowrap">{{$pembayarans->nama_pembayarans}}</td>
								    	</tr>
								    	@php($no++)
								    @endforeach
								@else
									<tr>
										@if(Yeah::totalHakAkses($link_pembayaran) != 0)
											<td colspan="5" class="center-align">Tidak ada data ditampilkan</td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
										@else
											<td colspan="4" class="center-align">Tidak ada data ditampilkan</td>
											<td style="display:none"></td>
											<td style="display:none"></td>
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