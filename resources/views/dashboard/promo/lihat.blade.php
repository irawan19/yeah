@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-sm-6">
							<strong>Promo</strong>
						</div>
						<div class="col-sm-6">
							<div class="right-align">
								{{ Yeah::tambah($link_promo,'dashboard/promo/tambah') }}
							</div>
						</div>
					</div>
				</div>
				<div class="card-body">
					<form method="GET" action="{{ URL('promo/cari') }}">
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
				    				@if(Yeah::totalHakAkses($link_promo) != 0)
					    				<th class="nowrap" width="5px"></th>
					    			@endif
				    				<th class="nowrap" width="50px">No</th>
				    				<th class="nowrap">Event</th>
				    				<th class="nowrap">Nama</th>
				    				<th class="nowrap">Mulai</th>
				    				<th class="nowrap">Selesai</th>
				    			</tr>
				    		</thead>
				    		<tbody>
				    			@if(!$lihat_promos->isEmpty())
					    			@php($no = 1)
		            				@foreach($lihat_promos as $promos)
								    	<tr>
					    					@if(Yeah::totalHakAkses($link_promo) != 0)
					    						<td class="nowrap">
											      	<div class="dropdown">
										            	<button class="btn btn-sm btn-success dropdown-toggle" id="dropdownMenu2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
										            	<div class="dropdown-menu" aria-labelledby="dropdownMenu2" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 34px, 0px); top: 0px; left: 0px; will-change: transform;">
										            		{{Yeah::baca($link_promo,'dashboard/promo/baca/'.$promos->id_promos)}}
										            		<div class="dropdown-divider"></div>
										            		{{Yeah::edit($link_promo,'dashboard/promo/edit/'.$promos->id_promos)}}
										            		<div class="dropdown-divider"></div>
										            		{{Yeah::hapus($link_promo,'dashboard/promo/hapus/'.$promos->id_promos, $promos->nama_promos)}}
										            	</div>
										            </div>
											    </td>
									    	@endif
								    		<td class="nowrap">{{$no}}</td>
								    		<td class="nowrap">
												@if($promos->events_id != 0)
													{{$promos->nama_events}}
												@else
													Semua Event
												@endif
											</td>
								    		<td class="nowrap">{{$promos->nama_promos}}</td>
								    		<td class="nowrap">{{Yeah::ubahDBKeTanggalwaktu($promos->mulai_promos)}}</td>
								    		<td class="nowrap">{{Yeah::ubahDBKeTanggalwaktu($promos->selesai_promos)}}</td>
								    	</tr>
								    	@php($no++)
								    @endforeach
								@else
									<tr>
										@if(Yeah::totalHakAkses($link_promo) != 0)
											<td colspan="6" class="center-align">Tidak ada data ditampilkan</td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
										@else
											<td colspan="5" class="center-align">Tidak ada data ditampilkan</td>
											<td style="display:none"></td>
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