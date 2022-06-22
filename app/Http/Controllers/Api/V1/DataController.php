<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Yeah;

class DataController extends ApiController
{
    /**
     * @OA\Get(path="/api/v1/data/konfigurasiaplikasi",
     *   tags={"Data"},
     *   summary="ambil data aplikasi",
     *   description="ambil data aplikasi",
     *   operationId="konfigurasiaplikasi",
     *   @OA\Response(
     *     response=200,
     *     description="sukses ambil data konfigurasi aplikasi",
     *     @OA\Schema(type="string"),
     *   ),
     *   @OA\Response(response=400, description="gagal mendapatkan data konfigurasi aplikasi"),
     * )
     */
    public function konfigurasiaplikasi(Request $request)
    {
        $ambil_konfigurasi_aplikasi = \App\Models\Master_konfigurasi_aplikasi::first();

        if(!empty($ambil_konfigurasi_aplikasi)){
            $konfigurasi_aplikasis_data = [
                'nama_konfigurasi_aplikasis'            => $ambil_konfigurasi_aplikasi->nama_konfigurasi_aplikasis,
                'keywords_konfigurasi_aplikasis'        => $ambil_konfigurasi_aplikasi->keywords_konfigurasi_aplikasis,
                'deskripsi_konfigurasi_aplikasis'       => $ambil_konfigurasi_aplikasi->deskripsi_konfigurasi_aplikasis,
                'icon_konfigurasi_aplikasis'            => URL('/').'/'.$ambil_konfigurasi_aplikasi->icon_konfigurasi_aplikasis,
                'logo_konfigurasi_aplikasis'            => URL('/').'/'.$ambil_konfigurasi_aplikasi->logo_konfigurasi_aplikasis,
                'logo_text_konfigurasi_aplikasis'       => URL('/').'/'.$ambil_konfigurasi_aplikasi->logo_text_konfigurasi_aplikasis,
                'whatsapp_konfigurasi_aplikasis'        => $ambil_konfigurasi_aplikasi->whatsapp_konfigurasi_aplikasis,
            ];

            return response()->json([
                'status'    => 'sukses',
                'message'   => $konfigurasi_aplikasis_data,
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
     * @OA\Get(path="/api/v1/data/jeniskelamin",
     *   tags={"Data"},
     *   summary="ambil data jenis kelamin",
     *   description="ambil data jenis kelamin",
     *   operationId="jeniskelamin",
     *   @OA\Response(
     *     response=200,
     *     description="sukses ambil data jenis kelamin",
     *     @OA\Schema(type="string"),
     *   ),
     *   @OA\Response(response=400, description="gagal mendapatkan data jenis kelamin"),
     * )
     */
    public function jeniskelamin(Request $request)
    {
        $ambil_jenis_kelamins = \App\Models\Master_jenis_kelamin::orderBy('nama_jenis_kelamins','desc')
                                                ->get();

        if(!$ambil_jenis_kelamins->isEmpty()){
            $jenis_kelamins_data = [];
            foreach($ambil_jenis_kelamins as $jenis_kelamins)
            {
                $jenis_kelamins_data[] = [
                    'id_jenis_kelamins'         => $jenis_kelamins->id_jenis_kelamins,
                    'nama_jenis_kelamins'       => $jenis_kelamins->nama_jenis_kelamins,
                ];
            }

            return response()->json([
                'status'    => 'sukses',
                'message'   => $jenis_kelamins_data,
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
     * @OA\Get(path="/api/v1/data/pembayaran",
     *   tags={"Data"},
     *   summary="ambil data pembayaran",
     *   description="ambil data pembayaran",
     *   operationId="pembayaran",
     *   @OA\Response(
     *     response=200,
     *     description="sukses ambil data pembayaran",
     *     @OA\Schema(type="string"),
     *   ),
     *   @OA\Response(response=400, description="gagal mendapatkan data pembayaran"),
     * )
     */
    public function pembayaran(Request $request)
    {
        $ambil_pembayarans = \App\Models\Master_pembayaran::orderBy('nama_pembayarans','desc')
                                                ->get();

        if(!$ambil_pembayarans->isEmpty()){
            $pembayarans_data = [];
            foreach($ambil_pembayarans as $pembayarans)
            {
                $pembayarans_data[] = [
                    'id_pembayarans'         => $pembayarans->id_pembayarans,
                    'nama_pembayarans'       => $pembayarans->nama_pembayarans,
                ];
            }

            return response()->json([
                'status'    => 'sukses',
                'message'   => $pembayarans_data,
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
     * @OA\Get(path="/api/v1/data/statuspembayaran",
     *   tags={"Data"},
     *   summary="ambil data status pembayaran",
     *   description="ambil data status pembayaran",
     *   operationId="statuspembayaran",
     *   @OA\Response(
     *     response=200,
     *     description="sukses ambil data status pembayaran",
     *     @OA\Schema(type="string"),
     *   ),
     *   @OA\Response(response=400, description="gagal mendapatkan data status pembayaran"),
     * )
     */
    public function statuspembayaran(Request $request)
    {
        $ambil_status_pembayarans = \App\Models\Master_status_pembayaran::orderBy('nama_status_pembayarans','desc')
                                                                        ->get();

        if(!$ambil_status_pembayarans->isEmpty()){
            $status_pembayarans_data = [];
            foreach($ambil_status_pembayarans as $status_pembayarans)
            {
                $status_pembayarans_data[] = [
                    'id_status_pembayarans'         => $status_pembayarans->id_status_pembayarans,
                    'nama_status_pembayarans'       => $status_pembayarans->nama_status_pembayarans,
                ];
            }

            return response()->json([
                'status'    => 'sukses',
                'message'   => $status_pembayarans_data,
            ],200);
        }
        else{
            return response()->json([
                'status'    => 'error',
                'message'   => 'data kosong',
            ],400);
        }
    }
}