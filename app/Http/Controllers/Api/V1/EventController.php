<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Yeah;

class EventController extends ApiController
{

    /**
     * @OA\Get(path="/api/v1/event",
     *   tags={"Event"},
     *   summary="ambil data event",
     *   description="ambil data event",
     *   operationId="event",
     *   @OA\Response(
     *     response=200,
     *     description="sukses ambil data event",
     *     @OA\Schema(type="string"),
     *   ),
     *   @OA\Response(response=400, description="gagal mendapatkan data event"),
     * )
     */
    public function event(Request $request)
    {
        $current_date = date('Y-m-d H:i:s');
        $ambil_events = \App\Models\Master_event::where('status_hapus_events',0)
                                                ->where('tanggal_events', '>', $current_date)
                                                ->orderBy('tanggal_events','desc')
                                                ->get();

        if(!$ambil_events->isEmpty()){
            $events_data = [];
            foreach($ambil_events as $events)
            {
                $events_data[] = [
                    'id_events'                 => $events->id_events,
                    'tanggal_events'            => $events->tanggal_events,
                    'gambar_events'             => URL('/').'/'.$events->gambar_events,
                    'nama_events'               => $events->nama_events,
                    'deskripsi_events'          => $events->deskripsi_events,
                    'disclaimer_events'         => $events->disclaimer_events,
                    'lokasi_events'             => $events->lokasi_events,
                    'mulai_registrasi_events'   => $events->mulai_registrasi_events,
                    'selesai_registrasi_events' => $events->selesai_registrasi_events
                ];
            }

            return response()->json([
                'status'    => 'sukses',
                'message'   => $events_data,
            ],200);
        }
        else{
            return response()->json([
                'status'    => 'error',
                'message'   => 'data kosong',
            ],400);
        }
    }

    /**
     * @OA\Get(path="/api/v1/event/{id_events}",
     *   tags={"Event"},
     *   summary="ambil data event detail by id",
     *   description="ambil data event detail by id",
     *   operationId="eventdetail",
     *   @OA\Parameter(
     *     name="id_events",
     *     required=true,
     *     in="path",
     *     @OA\Schema(
     *         type="string",
     *     ),
     *     description="input id event",
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="sukses ambil data event detail by id",
     *     @OA\Schema(type="string"),
     *   ),
     *   @OA\Response(response=400, description="gagal mendapatkan data event detail by id"),
     * )
     */
    public function eventdetail(Request $request, int $id_events)
    {
        $ambil_event_details = \App\Models\Master_event::where('id_events',$id_events)
                                                        ->where('status_hapus_events',0)
                                                        ->first();
        
        if(!$ambil_event_details->isEmpty)
        {
            $ambil_tickets = \App\Models\Master_ticket::where('events_id',$id_events)
                                                        ->orderBy('nama_tickets','asc')
                                                        ->get();
            $tickets_data = [];
            if(!$ambil_tickets->isEmpty())
            {
                foreach($ambil_tickets as $tickets)
                {
                    $tickets_data[] = [
                        'nama_tickets'      => $tickets->nama_tickets,
                        'deskripsi_tickets' => $tickets->deskripsi_tickets,
                        'keterangan_tickets'=> $tickets->keterangan_tickets,
                        'kuota_tickets'     => $tickets->kuota_tickets,
                        'harga_tickets'     => $tickets->harga_tickets,
                        'sisa_kuota_tickets'=> $tickets->sisa_kuota_tickets,
                    ];
                }
            }

            $ambil_promos = \App\Models\Master_promo::where('events_id',0)
                                                    ->orWhere('events_id',$id_events)
                                                    ->orderBy('nama_promos','asc')
                                                    ->get();
            
            $promos_data = [];
            if(!$ambil_promos->isEmpty())
            {
                foreach($ambil_promos as $promos)
                {
                    $promos_data[] = [
                        'events_id'         => $ambil_event_details->id_events,
                        'mulai_promos'      => $promos->mulai_promos,
                        'selesai_promos'    => $promos->selesai_promos,
                        'nama_promos'       => $promos->nama_promos,
                        'deskripsi_promos'  => $promos->deskripsi_promos,
                        'gambar_promos'     => URL('/').'/'.$promos->gambar_promos,
                    ];
                }
            }

            $event_details_data = [
                'id_events'                 => $ambil_event_details->id_events,
                'tanggal_events'            => $ambil_event_details->tanggal_events,
                'gambar_events'             => URL('/').'/'.$ambil_event_details->gambar_events,
                'nama_events'               => $ambil_event_details->nama_events,
                'deskripsi_events'          => $ambil_event_details->deskripsi_events,
                'disclaimer_events'         => $ambil_event_details->disclaimer_events,
                'lokasi_events'             => $ambil_event_details->lokasi_events,
                'mulai_registrasi_events'   => $ambil_event_details->mulai_registrasi_events,
                'selesai_registrasi_events' => $ambil_event_details->selesai_registrasi_events,
                'tickets_data'              => $tickets_data,
                'promos_data'               => $promos_data,
            ];

            return response()->json([
                'status'    => 'sukses',
                'message'   => $event_details_data,
            ],200);
        }
        else{
            return response()->json([
                'status'    => 'error',
                'message'   => 'tidak ada data event yang ditemukan',
            ],400);
        }
    }

    public function registrasi(Request $request)
    {
        $id_tickets                         = $request->get('id_tickets');
        $array_data_registrasi              = $request->get('registrasi');
        $no_registrasi                      = Yeah::noRegistrasi();
        $ambil_tickets                      = \App\Models\Master_ticket::where('id_tickets',$id_tickets)
                                                                    ->where('status_hapus_tickets',0)
                                                                    ->first();
        if(!empty($ambil_tickets)){
            $id_registrasi_events           = Yeah::autoIncrementKey('registrasi_events','id_registrasi_events');
            $harga_registrasi_events        = $ambil_tickets->harga_tickets;

            $registrasi_events_data = [
                'id_registrasi_events'                          => $id_registrasi_events,
                'tickets_id'                                    => $id_tickets,
                'pembayarans_id'                                => 1,
                'status_pembayarans_id'                         => 1,
                'jumlah_registrasi_events'                      => 0,
                'total_harga_registrasi_events'                 => 0,
                'bukti_pembayaran_registrasi_events'            => '',
                'no_registrasi_events'                          => $no_registrasi,
                'harga_registrasi_events'                       => $harga_registrasi_events,
                'created_at'                                    => date('Y-m-d H:i:s'),
                'updated_at'                                    => date('Y-m-d H:i:s'),
            ];
            \App\Models\Registrasi_event::insert($registrasi_events_data);

            $jumlah_registrasi_event_details = 0;
            foreach($array_data_registrasi as $data_registrasi)
            {
                $id_jenis_kelamins                      = $data_registrasi['jenis_kelamins_id'];
                $nama_registrasi_event_details          = $data_registrasi['nama_registrasi'];
                $email_registrasi_event_details         = $data_registrasi['email_registrasi'];
                $tanggal_lahir_registrasi_event_details = $data_registrasi['tanggal_lahir_registrasi'];
                $telepon_registrasi_event_details       = $data_registrasi['telepon_registrasi'];

                if(!empty($nama_registrasi_event_details))
                {
                    $registrasi_event_details_data = [
                        'id_registrasi_event_details'                   => Yeah::autoIncrementKey('registrasi_event_details','id_registrasi_event_details'),
                        'registrasi_events_id'                          => $id_registrasi_events,
                        'jenis_kelamins_id'                             => $id_jenis_kelamins,
                        'nama_registrasi_event_details'                 => $nama_registrasi_event_details,
                        'tanggal_lahir_registrasi_event_details'        => $tanggal_lahir_registrasi_event_details,
                        'email_registrasi_event_details'                => $email_registrasi_event_details,
                        'telepon_registrasi_event_details'              => $telepon_registrasi_event_details,
                        'created_at'                                    => date('Y-m-d H:i:s'),
                        'updated_at'                                    => date('Y-m-d H:i:s'),
                    ];
                    \App\Models\Registrasi_event_detail::insert($registrasi_event_details_data);

                    $jumlah_registrasi_event_details += 1;
                }
            }

            $update_registrasi_events = [
                'jumlah_registrasi_events'          => $jumlah_registrasi_event_details,
                'total_harga_registrasi_events'     => $harga_registrasi_events * $jumlah_registrasi_event_details,
                'updated_at'                        => date('Y-m-d H:i:s'),
            ];
            \App\Models\Registrasi_event::where('id_registrasi_events',$id_registrasi_events)
                                        ->update($update_registrasi_events);
            
            return response()->json([
                'status'            => 'sukses',
                'message'           => [
                    'booking_code'      => $no_registrasi,
                    'tanggal_registrasi'=> date('Y-m-d H:i:s'),
                    "pesan"         => 'data berhasil disimpan. no register '.$no_registrasi,
                ],
            ],400);
        }
        else{
            return response()->json([
                'status'    => 'error',
                'message'   => 'tidak ada data event yang ditemukan',
            ],400);
        }
    }

    /**
     * @OA\Get(path="/api/v1/event/cekticket",
     *   tags={"Event"},
     *   summary="ambil data ticket by booking code",
     *   description="ambil data ticket by booking code",
     *   operationId="cekticket",
     *   @OA\Parameter(
     *     name="booking_code",
     *     required=true,
     *     in="path",
     *     @OA\Schema(
     *         type="string",
     *     ),
     *     description="input booking code",
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="sukses ambil data ticket by booking code",
     *     @OA\Schema(type="string"),
     *   ),
     *   @OA\Response(response=400, description="gagal mendapatkan data ticket by booking code"),
     * )
     */
    public function cekticket(Request $request)
    {
        $no_registrasi_events       = $request->booking_code;
        $ambil_registrasi_events    = \App\Models\Registrasi_event::selectRaw('*,
                                                                                    registrasi_events.created_at as tanggal_registrasi_events')
                                                                            ->join('master_tickets','tickets_id','=','master_tickets.id_tickets')
                                                                            ->join('master_events','events_id','=','master_events.id_events')
                                                                            ->join('master_pembayarans','pembayarans_id','=','master_pembayarans.id_pembayarans')
                                                                            ->join('master_status_pembayarans','status_pembayarans_id','=','master_status_pembayarans.id_status_pembayarans')
                                                                            ->where('no_registrasi_events',$no_registrasi_events)
                                                                            ->first();
        
        if(!empty($ambil_registrasi_events))
        {
            $ambil_registrasi_details = \App\Models\Registrasi_event_detail::join('master_jenis_kelamins','jenis_kelamins_id','=','master_jenis_kelamins.id_jenis_kelamins')
                                                                            ->where('registrasi_events_id',$ambil_registrasi_events->id_registrasi_events)
                                                                            ->orderBy('registrasi_event_details.created_at')
                                                                            ->get();
            $data_registrasi = [];
            if(!$ambil_registrasi_details->isEmpty())
                $data_registrasi = $ambil_registrasi_details;

            $registrasi_events_data = [
                'id_events'                     => $ambil_registrasi_events->id_events,
                'tanggal_events'                => $ambil_registrasi_events->tanggal_events,
                'gambar_events'                 => URL('/').'/'.$ambil_registrasi_events->gambar_events,
                'nama_events'                   => $ambil_registrasi_events->nama_events,
                'deskripsi_events'              => $ambil_registrasi_events->deskripsi_events,
                'disclaimer_events'             => $ambil_registrasi_events->disclaimer_events,
                'lokasi_events'                 => $ambil_registrasi_events->lokasi_events,
                'id_tickets'                    => $ambil_registrasi_events->id_tickets,
                'nama_tickets'                  => $ambil_registrasi_events->nama_tickets,
                'deskripsi_tickets'             => $ambil_registrasi_events->deskripsi_tickets,
                'keterangan_tickets'            => $ambil_registrasi_events->keterangan_tickets,
                'tanggal_registrasi_events'     => $ambil_registrasi_events->tanggal_registrasi_events,
                'jumlah_registrasi_events'      => $ambil_registrasi_events->jumlah_registrasi_events,
                'harga_registrasi_events'       => $ambil_registrasi_events->harga_registrasi_events,
                'total_harga_registrasi_events' => $ambil_registrasi_events->total_harga_registrasi_events,
                'id_pembayarans'                => $ambil_registrasi_events->id_pembayarans,
                'nama_pembayarans'              => $ambil_registrasi_events->nama_pembayarans,
                'id_status_pembayarans'         => $ambil_registrasi_events->id_status_pembayarans,
                'nama_status_pembayarans'       => $ambil_registrasi_events->nama_status_pembayarans,
                'registrasi_data'               => $data_registrasi,
            ];

            return response()->json([
                'status'    => 'sukses',
                'message'   => $registrasi_events_data,
            ],200);
        }
        else{
            return response()->json([
                'status'    => 'error',
                'message'   => 'tidak ada data ticket yang ditemukan',
            ],400);
        }
    }
}