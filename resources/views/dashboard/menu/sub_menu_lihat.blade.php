@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-sm-6">
							<strong>Menu {{$lihat_menus->nama_menus}}</strong>
						</div>
						<div class="col-sm-6">
							<div class="right-align">
								{{ Yeah::tambah($link_menu,'dashboard/menu/tambah_submenu/'.$lihat_menus->id_menus) }} {{ Yeah::urutan($link_menu,'dashboard/menu/urutan_submenu/'.$lihat_menus->id_menus) }}
							</div>
						</div>
					</div>
				</div>
				<div class="card-body">
					<form method="GET" action="{{ URL('dashboard/menu/cari_submenu/'.$lihat_menus->id_menus) }}">
						@csrf
	                	<div class="input-group">
	                		<input class="form-control" id="input2-group2" type="text" name="cari_kata" placeholder="Cari" value="{{$hasil_kata2}}">
	                		<span class="input-group-append">
	                		  	<button class="btn btn-primary" type="submit"> Cari</button>
	                		</span>
	                	</div>
	                </form>
	            	<br/>
			    	<table id="tablesort" class="table table-responsive-sm table-bordered table-striped table-sm">
			    		<thead>
			    			<tr>
			    				@if(Yeah::totalHakAkses($link_menu) != 0)
				    				<th class="nowrap" width="5px"></th>
				    			@endif
			    				<th class="nowrap" width="50px">No</th>
			    				<th class="nowrap" width="5px">Icon</th>
			    				<th class="nowrap">Nama</th>
			    			</tr>
			    		</thead>
			    		<tbody>
			    			@if(!$lihat_sub_menus->isEmpty())
				    			@php($no = 1)
	            				@foreach($lihat_sub_menus as $sub_menus)
							    	<tr>
				    					@if(Yeah::totalHakAkses($link_menu) != 0)
				    						<td class="nowrap">
										      	<div class="dropdown">
									            	<button class="btn btn-sm btn-success dropdown-toggle" id="dropdownMenu2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
									            	<div class="dropdown-menu" aria-labelledby="dropdownMenu2" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 34px, 0px); top: 0px; left: 0px; will-change: transform;">
									            		{{Yeah::baca($link_menu,'dashboard/menu/baca_submenu/'.$sub_menus->id_menus)}}
									            		<div class="dropdown-divider"></div>
									            		{{Yeah::edit($link_menu,'dashboard/menu/edit_submenu/'.$sub_menus->id_menus)}}
									            		<div class="dropdown-divider"></div>
									            		{{Yeah::hapus($link_menu,'dashboard/menu/hapus_submenu/'.$sub_menus->id_menus, $sub_menus->nama_menus)}}
									            	</div>
									            </div>
										    </td>
								    	@endif
							    		<td class="nowrap">{{$no}}</td>
							    		<td class="nowrap">
							    			<svg class="c-sidebar-nav-icon">
									          	<use xlink:href="{{URL::asset('public/template/back/assets/icons/coreui/free.svg#'.$sub_menus->icon_menus)}}"></use>
									        </svg>
							    		</td>
							    		<td>{{$sub_menus->nama_menus}}</td>
							    	</tr>
							    	@php($no++)
							    @endforeach
							@else
								<tr>
									@if(Yeah::totalHakAkses($link_menu) != 0)
										<td colspan="4" class="center-align">Tidak ada data ditampilkan</td>
										<td style="display:none"></td>
										<td style="display:none"></td>
										<td style="display:none"></td>
									@else
										<td colspan="3" class="center-align">Tidak ada data ditampilkan</td>
										<td style="display:none"></td>
										<td style="display:none"></td>
									@endif
								</tr>
							@endif
			    		</tbody>
			    	</table>
				</div>
				<div class="card-footer right-align">
				  	@if(request()->session()->get('halaman') != '')
		           		@php($ambil_kembali = request()->session()->get('halaman'))
	               	@else
	               		@php($ambil_kembali = URL('dashboard/menu'))
	               	@endif
		           	<a class="btn btn-sm btn-danger" href="{{ $ambil_kembali }}">
		           		<svg class="c-icon" style="margin-right:5px;">
	               	      	<use xlink:href="{{URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-ban')}}"></use>
	               	    </svg> Kembali
	               	</a>
				</div>
			</div>
		</div>
	</div>

@endsection