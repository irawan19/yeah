@extends('dashboard.layouts.app')
@section('content')

	<style type="text/css">
		.bg-custom{
			background-color: #fff;
		    border: 1px solid #c8ced3;
		    border-radius: 0.25rem;
		}
		.card-custom{
			position: relative;
		    display: -ms-flexbox;
		    display: flex;
		    -ms-flex-direction: column;
		    flex-direction: column;
		    min-width: 0;
		    word-wrap: break-word;
		    background-color: #fff;
		    background-clip: border-box;
		    margin-bottom: 5px;
		}
		.card-header{
			color: #000
		}
		.text-muted {
		    color: #0e2f44 !important;
		}
	</style>

	<div class="animated fadeIn">
		<div class="row">
			<div class="col-sm-8">
				<div class="card" style="min-height: 225px;background-color: white">
				    <div class="card-body pb-0">
				    	<div class="row">
				    		<div class="col-sm-6">
					        	<div style="max-width: 350px;text-align: center; margin-top: 20px">
					        		<img src="{{URL::asset($lihat_konfigurasi_aplikasis->logo_text_konfigurasi_aplikasis)}}" width="256px">
					        	</div>
					        </div>
				    		<div class="col-sm-6">
				    			<div style="margin-top: 70px; text-align: center">
				        			<p style="font-weight: bold; font-size: 20px; margin-bottom: 5px">Halo, {{Auth::user()->name}}</p>
				        			<p style="font-size: 16px">Selamat Datang di halaman dashboard</p>
				    			</div>
				    		</div>
				    	</div>
				    </div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-6">
					    <a href="{{URL('dashboard/jasa')}}" class="nonstyle">
					        <div class="card" style="height: 100px; background-color: #fff; color: #000;">
					            <div class="card-body pb-0">
					                <div class="btn-group float-right">
					                    <svg class="c-icon">
					                        <use xlink:href="{{URL::asset('template/back/assets/icons/coreui/free.svg#cil-badge')}}"></use>
					                    </svg>
					                </div>
					                <div class="text-value-lg">{{Yeah::konversiNilai(0)}} <span>{{Yeah::konversiNilaiString(0)}}</span></div>
					                <div>Event</div>
					            </div>
					            <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;"></div>
					        </div>
					    </a>
					</div>
					<div class="col-sm-6">
					    <a href="{{URL('dashboard/member')}}" class="nonstyle">
					        <div class="card" style="height: 100px; background-color: #fff; color: #000;">
					            <div class="card-body pb-0">
					                <div class="btn-group float-right">
					                    <svg class="c-icon">
					                        <use xlink:href="{{URL::asset('template/back/assets/icons/coreui/free.svg#cil-user')}}"></use>
					                    </svg>
					                </div>
					                <div class="text-value-lg">{{Yeah::konversiNilai(0)}} <span>{{Yeah::konversiNilaiString(0)}}</span></div>
					                <div>Member</div>
					            </div>
					            <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;"></div>
					        </div>
					    </a>
					</div>
					<div class="col-sm-6">
					    <a href="{{URL('dashboard/user')}}" class="nonstyle">
					        <div class="card" style="height: 100px; background-color: #fff; color: #000;">
					            <div class="card-body pb-0">
					                <div class="btn-group float-right">
					                    <svg class="c-icon">
					                        <use xlink:href="{{URL::asset('template/back/assets/icons/coreui/free.svg#cil-user-follow')}}"></use>
					                    </svg>
					                </div>
					                <div class="text-value-lg">{{Yeah::konversiNilai(0)}} <span>{{Yeah::konversiNilaiString(0)}}</span></div>
					                <div>User</div>
					            </div>
					            <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;"></div>
					        </div>
					    </a>
					</div>
					<div class="col-sm-6">
					    <a href="{{URL('dashboard')}}" class="nonstyle">
					        <div class="card" style="height: 100px; background-color: #fff; color: #000;">
					            <div class="card-body pb-0">
					                <div class="btn-group float-right">
					                    <svg class="c-icon">
					                        <use xlink:href="{{URL::asset('template/back/assets/icons/coreui/free.svg#cil-user')}}"></use>
					                    </svg>
					                </div>
					                <div class="text-value-lg">{{Yeah::konversiNilai(0)}} <span>{{Yeah::konversiNilaiString(0)}}</span></div>
					                <div>Admin</div>
					            </div>
					            <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;"></div>
					        </div>
					    </a>
					</div>
				</div>
			</div>
		</div>


		@php($id_admins           	= Auth::user()->id)
		@php($ambil_menus           = \App\Models\Master_menu::where('sub_menus_id',0)
		                                                ->orderBy('order_menus')
		                                                ->get())
		@foreach($ambil_menus as $menus)
		    @if($loop->last)
		    	@php($style = 'style=padding-bottom:30px')
		    @else
		    	@php($style = '')
		    @endif
			@php($id_menus          = $menus->id_menus)
		    @php($ambil_sub_menus   = \App\Models\Master_menu::join('master_fiturs','master_menus.id_menus','=','master_fiturs.menus_id')
			                                                ->join('master_akses','master_fiturs.id_fiturs','=','master_akses.fiturs_id')
			                                                ->join('master_level_sistems','master_akses.level_sistems_id','=','master_level_sistems.id_level_sistems')
			                                                ->join('users','master_level_sistems.id_level_sistems','=','users.level_sistems_id')
			                                                ->where('sub_menus_id',$id_menus)
			                                                ->where('id',$id_admins)
			                                                ->where('nama_fiturs','lihat')
			                                                ->groupBy('nama_menus','id_menus','id_fiturs','master_akses.id_akses','master_akses.level_sistems_id','master_akses.fiturs_id','master_level_sistems.id_level_sistems','users.id')
			                                                ->orderBy('order_menus')
			                                                ->get())
		    @php($total_sub_menus   = \App\Models\Master_menu::join('master_fiturs','master_menus.id_menus','=','master_fiturs.menus_id')
			                                                ->join('master_akses','master_fiturs.id_fiturs','=','master_akses.fiturs_id')
			                                                ->join('master_level_sistems','master_akses.level_sistems_id','=','master_level_sistems.id_level_sistems')
			                                                ->join('users','master_level_sistems.id_level_sistems','=','users.level_sistems_id')
			                                               	->where('sub_menus_id',$id_menus)
			                                                ->where('id',$id_admins)
			                                                ->where('nama_fiturs','lihat')
			                                                ->count())
		    @if($total_sub_menus != 0)
		    	<div class="card" style="margin-bottom: 10px; border-radius: 0">
		    		<div class="card-header">
		    			<strong>
		    				<svg class="c-sidebar-nav-icon" style="width: 50px">
							  	<use xlink:href="{{URL::asset('template/back/assets/icons/coreui/free.svg#'.$menus->icon_menus)}}"></use>
							</svg>{{$menus->nama_menus}}
		    			</strong>
		    		</div>
		    		<div class="card-body">
		    			<div class="row">
		    				@foreach($ambil_sub_menus as $sub_menus)
			    				<div class="col-sm-2">
			    					<a href="{{URL('dashboard/'.$sub_menus->link_menus)}}" style="color:black; text-decoration: none; cursor: pointer">
				    					<div class="card-custom">
					        				<div class="card-body p-2 d-flex align-items-center">
										        <svg class="c-sidebar-nav-icon">
											      	<use xlink:href="{{URL::asset('template/back/assets/icons/coreui/free.svg#'.$sub_menus->icon_menus)}}"></use>
											    </svg>
					                      		<div>
					                        		<div class="text-muted text-uppercase font-weight-bold small">{{$sub_menus->nama_menus}}</div>
					                      		</div>
					                    	</div>
					                    </div>
					                </a>
				                </div>
				            @endforeach
				    	</div>
					</div>
				</div>
		   	@endif
		@endforeach
	</div>

@endsection