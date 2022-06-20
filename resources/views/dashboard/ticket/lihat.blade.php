@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-sm-6">
							<strong>Ticket</strong>
						</div>
						<div class="col-sm-6">
							<div class="right-align">
								{{ Yeah::tambah($link_ticket,'dashboard/ticket/tambah') }}
							</div>
						</div>
					</div>
				</div>
				<div class="card-body">
					<form method="GET" action="{{ URL('ticket/cari') }}">
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
				    				@if(Yeah::totalHakAkses($link_ticket) != 0)
					    				<th class="nowrap" width="5px"></th>
					    			@endif
				    				<th class="nowrap" width="50px">No</th>
				    				<th class="nowrap">Event</th>
				    				<th class="nowrap">Nama</th>
				    				<th class="nowrap">Harga</th>
				    				<th class="nowrap">Kuota</th>
				    				<th class="nowrap">Sisa Kuota</th>
				    			</tr>
				    		</thead>
				    		<tbody>
				    			@if(!$lihat_tickets->isEmpty())
					    			@php($no = 1)
		            				@foreach($lihat_tickets as $tickets)
								    	<tr>
					    					@if(Yeah::totalHakAkses($link_ticket) != 0)
					    						<td class="nowrap">
											      	<div class="dropdown">
										            	<button class="btn btn-sm btn-success dropdown-toggle" id="dropdownMenu2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
										            	<div class="dropdown-menu" aria-labelledby="dropdownMenu2" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 34px, 0px); top: 0px; left: 0px; will-change: transform;">
										            		{{Yeah::baca($link_ticket,'dashboard/ticket/baca/'.$tickets->id_tickets)}}
										            		<div class="dropdown-divider"></div>
										            		{{Yeah::edit($link_ticket,'dashboard/ticket/edit/'.$tickets->id_tickets)}}
										            		<div class="dropdown-divider"></div>
										            		{{Yeah::hapus($link_ticket,'dashboard/ticket/hapus/'.$tickets->id_tickets, $tickets->nama_tickets)}}
										            	</div>
										            </div>
											    </td>
									    	@endif
								    		<td class="nowrap">{{$no}}</td>
								    		<td class="nowrap">{{$tickets->nama_events}}</td>
								    		<td class="nowrap">{{$tickets->nama_tickets}}</td>
								    		<td class="nowrap right-align">{{Yeah::ubahDBKeHarga($tickets->harga_tickets)}}</td>
								    		<td class="nowrap">{{$tickets->kuota_tickets}}</td>
								    		<td class="nowrap">{{$tickets->sisa_kuota_tickets}}</td>
								    	</tr>
								    	@php($no++)
								    @endforeach
								@else
									<tr>
										@if(Yeah::totalHakAkses($link_ticket) != 0)
											<td colspan="7" class="center-align">Tidak ada data ditampilkan</td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
										@else
											<td colspan="6" class="center-align">Tidak ada data ditampilkan</td>
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