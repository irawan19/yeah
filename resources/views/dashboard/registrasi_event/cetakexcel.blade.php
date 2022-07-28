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
	<tr>
		<td colspan="12" style="font-weight: bold; text-align: center"></td>
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
			<th>Ticket</th>
			<th>Harga</th>
			<th>Datang</th>
			<th>Tidak Datang</th>
			<th>Jumlah</th>
			<th>Sisa</th>
			<th>Terjual</th>
			<th>Total Harga</th>
		</tr>
	</thead>
	<tbody>
		@php($lihat_tickets = \App\Models\Master_ticket::where('events_id',$hasil_event)
														->where('status_hapus_tickets',0)
														->get())
		@php($total_datang 			= 0)
		@php($total_tidak_datang 	= 0)
		@php($total_tickets 		= 0)
		@php($total_sisa_tickets 	= 0)
		@php($total_terjual_tickets = 0)
		@php($total_harga_tickets 	= 0)
		@if(!$lihat_tickets->isEmpty())
			@foreach($lihat_tickets as $tickets)
				<tr>
					<td>{{$tickets->nama_tickets}}</td>
					<td align="right">{{Yeah::ubahDBKeHarga($tickets->harga_tickets)}}</td>
					<td align="right">
						@php($lihat_datang = \App\Models\Registrasi_event_detail::join('registrasi_events','registrasi_events_id','=','registrasi_events.id_registrasi_events')
																					->join('master_tickets','tickets_id','=','master_tickets.id_tickets')
																					->where('events_id',$hasil_event)
																					->where('tickets_id',$tickets->id_tickets)
																					->where('status_kedatangan_registrasi_events',1)
																					->where('status_hapus_tickets',0)
																					->count())
						{{$lihat_datang}}
					</td>
					<td align="right">
						@php($lihat_tidak_datang = \App\Models\Registrasi_event_detail::join('registrasi_events','registrasi_events_id','=','registrasi_events.id_registrasi_events')
																					->join('master_tickets','tickets_id','=','master_tickets.id_tickets')
																					->where('events_id',$hasil_event)
																					->where('tickets_id',$tickets->id_tickets)
																					->where('status_kedatangan_registrasi_events',0)
																					->where('status_hapus_tickets',0)
																					->count())
						{{$lihat_tidak_datang}}
					</td>
					<td align="right">{{$tickets->kuota_tickets}}</td>
					<td align="right">{{$tickets->sisa_kuota_tickets}}</td>
					<td align="right">{{$tickets->kuota_tickets - $tickets->sisa_kuota_tickets}}</td>
					<td align="right">{{Yeah::ubahDBKeHarga(($tickets->kuota_tickets - $tickets->sisa_kuota_tickets) * $tickets->harga_tickets)}}</td>
				</tr>
				@php($total_datang 			+= $lihat_datang)
				@php($total_tidak_datang 	+= $lihat_tidak_datang)
				@php($total_tickets 		+= $tickets->kuota_tickets)
				@php($total_sisa_tickets 	+= $tickets->sisa_kuota_tickets)
				@php($total_terjual_tickets += $tickets->kuota_tickets - $tickets->sisa_kuota_tickets)
				@php($total_harga_tickets 	+= ($tickets->kuota_tickets - $tickets->sisa_kuota_tickets) * $tickets->harga_tickets)
			@endforeach
		@else
			<tr>
				<td colspan="8" align="center">Tidak ada data ditampilkan</td>
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
	<tfoot>
		<tr>
			<th align="center" colspan="2">Total</th>
			<th align="right">{{$total_datang}}</th>
			<th align="right">{{$total_tidak_datang}}</th>
			<th align="right">{{$total_tickets}}</th>
			<th align="right">{{$total_sisa_tickets}}</th>
			<th align="right">{{$total_terjual_tickets}}</th>
			<th align="right">{{Yeah::ubahDBKeHarga($total_harga_tickets)}}</th>
		</tr>
	</tfoot>
</table>

<table>
	<tr>
		<td colspan="12" style="font-weight: bold; text-align: center"></td>
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
							Tidak Datang
						@else
							Datang
						@endif
					</td>
		    	</tr>
		    	@php($no++)
		    @endforeach
		@else
			<tr>
				<td colspan="12" align="center">Tidak ada data ditampilkan</td>
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