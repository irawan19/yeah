<table>
	<tr>
		<td colspan="12" style="font-weight: bold; text-align: center">Registrasi Event</td>
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
			<td style="display:none"></td>
	</tr>
</table>
<table>
	<tr>
		<td colspan="12" style="font-weight: bold; text-align: center">{{Yeah::ubahDBKeTanggalwaktu(date('Y-m-d H:i:s'))}}</td>
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
			<td style="display:none"></td>
	</tr>
</table>
<table>
	<thead>
		<tr>
			<th width="50px">No</th>
			<th>Tanggal</th>
			<th>No Reg.</th>
			<th>Event</th>
			<th>Ticket</th>
			<th>Email</th>
			<th>Telp</th>
			<th>Nama</th>
			<th>Jenis Kelamin</th>
			<th>Tanggal Lahir</th>
			<th>Pembayaran</th>
			<th>Kedatangan</th>
		</tr>
	</thead>
	<tbody>
		@if(!$lihat_registrasi_events->isEmpty())
			@php($no = 1)
			@foreach($lihat_registrasi_events as $registrasi_events)
		    	<tr>
		    		<td>{{$no}}</td>
		    		<td>{{Yeah::ubahDBKeTanggalwaktu($registrasi_events->tanggal_registrasi_event_details)}}</td>
		    		<td>{{$registrasi_events->no_registrasi_events}}</td>
		    		<td>{{$registrasi_events->nama_events}}</td>
		    		<td>{{$registrasi_events->nama_tickets}}</td>
		    		<td>
						<a href="mailto={{$registrasi_events->email_registrasi_event_details}}">
							{{$registrasi_events->email_registrasi_event_details}}
						</a>
					</td>
		    		<td>
						<a href="tel:{{$registrasi_events->telepon_registrasi_event_details}}">
							{{$registrasi_events->telepon_registrasi_event_details}}
						</a>
					</td>
		    		<td>{{$registrasi_events->nama_registrasi_event_details}}</td>
		    		<td>{{$registrasi_events->nama_jenis_kelamins}}</td>
		    		<td>{{Yeah::ubahDBKeTanggal($registrasi_events->tanggal_lahir_registrasi_event_details)}}</td>
		    		<td>{{$registrasi_events->nama_status_pembayarans}}</td>
					<td>
						@if($registrasi_events->status_kedatangan_registrasi_events == false)
							<svg class="c-icon" style="margin-right:5px; color:red">
								<use xlink:href="{{URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-x-circle')}}"></use>
							</svg>
						@else
							<svg class="c-icon" style="margin-right:5px; color:green">
								<use xlink:href="{{URL::asset('public/template/back/assets/icons/coreui/free.svg#cil-check-circle')}}"></use>
							</svg>
						@endif
					</td>
		    	</tr>
		    	@php($no++)
		    @endforeach
		@else
			<tr>
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
			</tr>
		@endif
	</tbody>
</table>