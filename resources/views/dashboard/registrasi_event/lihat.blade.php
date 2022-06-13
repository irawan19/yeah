@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-sm-6">
							<strong>Registrasi Event</strong>
						</div>
						<div class="col-sm-6">
							<div class="right-align">
								{{ Yeah::tambah($link_registrasi_event,'dashboard/registrasi_event/tambah') }}
								{{ Yeah::cetakexcel($link_registrasi_event,'dashboard/registrasi_event/cetakexcel') }}
							</div>
						</div>
					</div>
				</div>
				<div class="card-body">
					<form method="GET" action="{{ URL('dashboard/registrasi_event/cari') }}">
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
				    				@if(Yeah::totalHakAkses($link_registrasi_event) != 0)
					    				<th class="nowrap" width="5px"></th>
					    			@endif
				    				<th class="nowrap" width="50px">No</th>
				    				<th class="nowrap">Tanggal</th>
				    				<th class="nowrap">No Reg.</th>
				    				<th class="nowrap">Event</th>
				    				<th class="nowrap">Ticket</th>
				    				<th class="nowrap">Email</th>
				    				<th class="nowrap">Telp</th>
				    				<th class="nowrap">Nama</th>
				    				<th class="nowrap">Jenis Kelamin</th>
				    				<th class="nowrap">Umur</th>
				    				<th class="nowrap">Status</th>
				    			</tr>
				    		</thead>
				    		<tbody>
				    			@if(!$lihat_registrasi_events->isEmpty())
					    			@php($no = 1)
		            				@foreach($lihat_registrasi_events as $registrasi_events)
								    	<tr>
					    					@if(Yeah::totalHakAkses($link_registrasi_event) != 0)
					    						<td class="nowrap">
											      	<div class="dropdown">
										            	<button class="btn btn-sm btn-success dropdown-toggle" id="dropdownMenu2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
										            	<div class="dropdown-menu" aria-labelledby="dropdownMenu2" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 34px, 0px); top: 0px; left: 0px; will-change: transform;">
										            		{{Yeah::edit($link_registrasi_event,'registrasi_event/edit/'.$registrasi_events->id_registrasi_events)}}
										            		<div class="dropdown-divider"></div>
										            		{{Yeah::hapus($link_registrasi_event,'registrasi_event/hapus/'.$registrasi_events->id_registrasi_events, $registrasi_events->nama_registrasi_events)}}
										            	</div>
										            </div>
											    </td>
									    	@endif
								    		<td class="nowrap">{{$no}}</td>
								    		<td class="nowrap">{{$registrasi_events->tanggal_registrasi_event_details}}</td>
								    		<td class="nowrap">{{$registrasi_events->nama_events}}</td>
								    		<td class="nowrap">{{$registrasi_events->no_registrasi_events}}</td>
								    		<td class="nowrap">{{$registrasi_events->nama_tickets}}</td>
								    		<td class="nowrap">
												<a href="mailto={{$registrasi_events->email_registrasi_event_details}}">
													{{$registrasi_events->email_registrasi_event_details}}
												</a>
											</td>
								    		<td class="nowrap">
												<a href="tel:{{$registrasi_events->telepon_registrasi_event_details}}">
													{{$registrasi_events->telepon_registrasi_event_details}}
												</a>
											</td>
								    		<td class="nowrap">{{$registrasi_events->nama_registrasi_event_details}}</td>
								    		<td class="nowrap">{{$registrasi_events->nama_jenis_kelamins}}</td>
								    		<td class="nowrap">{{$registrasi_events->umur_registrasi_event_details}}</td>
								    		<td class="nowrap">{{$registrasi_events->nama_status_pembayarans}}</td>
								    	</tr>
								    	@php($no++)
								    @endforeach
								@else
									<tr>
										@if(Yeah::totalHakAkses($link_registrasi_event) != 0)
											<td colspan="12" class="center-align">Tidak ada data ditampilkan</td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
										@else
											<td colspan="11" class="center-align">Tidak ada data ditampilkan</td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
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
					<br/>
				   	{{ $lihat_registrasi_events->appends(Request::except('page'))->links('vendor.pagination.custom') }}
				</div>
			</div>
		</div>
	</div>

@endsection