<table>
	<tr>
		<td colspan="11" style="font-weight: bold; text-align: center">Registrasi Event</td>
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
		<td colspan="11" style="font-weight: bold; text-align: center">{{Yeah::ubahDBKeTanggalwaktu(date('Y-m-d H:i:s'))}}</td>
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
			<th>Umur</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		@if(!$lihat_registrasi_events->isEmpty())
			@php($no = 1)
			@foreach($lihat_registrasi_events as $registrasi_events)
		    	<tr>
		    		<td>{{$no}}</td>
		    		<td>{{$registrasi_events->tanggal_registrasi_event_details}}</td>
		    		<td>{{$registrasi_events->nama_events}}</td>
		    		<td>{{$registrasi_events->no_registrasi_events}}</td>
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
		    		<td>{{$registrasi_events->umur_registrasi_event_details}}</td>
		    		<td>{{$registrasi_events->nama_status_pembayarans}}</td>
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