@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-sm-6">
							<strong>Event</strong>
						</div>
						<div class="col-sm-6">
							<div class="right-align">
								{{ Yeah::tambah($link_event,'dashboard/event/tambah') }}
							</div>
						</div>
					</div>
				</div>
				<div class="card-body">
					<form method="GET" action="{{ URL('dashboard/event/cari') }}">
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
				    				@if(Yeah::totalHakAkses($link_event) != 0)
					    				<th class="nowrap" width="5px"></th>
					    			@endif
				    				<th class="nowrap" width="50px">No</th>
				    				<th class="nowrap">Tanggal</th>
				    				<th class="nowrap">Nama</th>
				    				<th class="nowrap">Lokasi</th>
				    				<th class="nowrap">Mulai Registrasi</th>
				    				<th class="nowrap">Selesai Registrasi</th>
									<th class="nowrap">Ticket</th>
									<th class="nowrap">Promo</th>
				    			</tr>
				    		</thead>
				    		<tbody>
				    			@if(!$lihat_events->isEmpty())
					    			@php($no = 1)
		            				@foreach($lihat_events as $events)
								    	<tr>
					    					@if(Yeah::totalHakAkses($link_event) != 0)
					    						<td class="nowrap">
											      	<div class="dropdown">
										            	<button class="btn btn-sm btn-success dropdown-toggle" id="dropdownMenu2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
										            	<div class="dropdown-menu" aria-labelledby="dropdownMenu2" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 34px, 0px); top: 0px; left: 0px; will-change: transform;">
										            		{{Yeah::baca($link_event,'dashboard/event/baca/'.$events->id_events)}}
										            		<div class="dropdown-divider"></div>
										            		{{Yeah::edit($link_event,'dashboard/event/edit/'.$events->id_events)}}
										            		<div class="dropdown-divider"></div>
										            		{{Yeah::hapus($link_event,'dashboard/event/hapus/'.$events->id_events, $events->nama_events)}}
										            	</div>
										            </div>
											    </td>
									    	@endif
								    		<td class="nowrap">{{$no}}</td>
								    		<td class="nowrap">{{Yeah::ubahDBKeTanggalwaktu($events->tanggal_events)}}</td>
								    		<td class="nowrap">{{$events->nama_events}}</td>
								    		<td class="nowrap">{{$events->lokasi_events}}</td>
								    		<td class="nowrap">{{Yeah::ubahDBKeTanggalwaktu($events->mulai_registrasi_events)}}</td>
								    		<td class="nowrap">{{Yeah::ubahDBKeTanggalwaktu($events->selesai_registrasi_events)}}</td>
								    		<td class="nowrap">
												@php($ambil_total_tickets = \App\Models\Master_ticket::where('events_id',$events->id_events)->count())
												<a href="{{URL('dashboard/ticket/cari?cari_kata='.$events->nama_events)}}">Ada {{$ambil_total_tickets}} Ticket</a>
											</td>
								    		<td class="nowrap">
												@php($ambil_total_promos = \App\Models\Master_promo::where('events_id',$events->id_events)
																									->orWhere('events_id',0)
																									->count())
												<a href="{{URL('dashboard/promo/cari?cari_kata='.$events->nama_events)}}">Ada {{$ambil_total_promos}} Promo</a>
											</td>
								    	</tr>
								    	@php($no++)
								    @endforeach
								@else
									<tr>
										@if(Yeah::totalHakAkses($link_event) != 0)
											<td colspan="9" class="center-align">Tidak ada data ditampilkan</td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
										@else
											<td colspan="8" class="center-align">Tidak ada data ditampilkan</td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
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