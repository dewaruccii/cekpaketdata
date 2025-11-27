<?php

namespace App\Http\Controllers;

use App\Models\CekPaketData;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index');
    }
    public function check(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'operator' => 'required|string|max:50',
            'harga' => 'required|integer|min:1',
            'kuota_gb' => 'required|numeric|min:0.1',
            'masa_aktif_hari' => 'required|integer|min:1',
            'ppgb' => 'required|numeric',
            'flag' => 'required|string|in:COMPLY,NON COMPLY',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            // Validasi untuk multiple files:
            'bukti' => 'required|array|max:5', // Harus ada array file, max 5 file
            'bukti.*' => 'mimes:jpeg,png', // Setiap file max 10MB (10000 KB)
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // 2. Simpan Data Paket ke Model CekPaketData
            $dataPaket = CekPaketData::create([
                'uuid' => uuidGenerator(),
                'operator' => $request->operator,
                'harga' => $request->harga,
                'kuota_gb' => $request->kuota_gb,
                'masa_aktif_hari' => $request->masa_aktif_hari,
                'ppgb' => $request->ppgb,
                'flag' => $request->flag,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'user_email' => Auth::user()->email ?? null,
            ]);

            // 3. Proses Multiple File Upload
            if ($request->hasFile('bukti')) {
                foreach ($request->file('bukti') as $file) {
                    // Simpan file ke storage (contoh: storage/app/public/bukti_paket)
                    // $path = $file->store('public/bukti_paket');

                    // Simpan data bukti ke Model BuktiFoto
                    // BuktiFoto::create([
                    //     'cek_paket_data_id' => $dataPaket->id,
                    //     'file_path' => $path,
                    //     'file_name' => $file->getClientOriginalName(),
                    // ]);
                    $upload = new FileService();
                    $upload->upload($file, 'bukti_foto', 'local', $dataPaket);
                }
            }

            // 4. Respon Sukses
            return response()->json([
                'success' => true,
                'message' => 'Data paket dan bukti berhasil disimpan!',
                'data' => $dataPaket
            ], 200);
        } catch (\Exception $e) {
            // Log error
            Log::error('Error saat menyimpan paket: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data ke server.',
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }
    public function laporan()
    {
        return view('admin.laporan');
    }
    public function laporanData(Request $request)
    {
        $query = CekPaketData::query()->with('Files');

        // Filter berdasarkan tanggal jika diberikan
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $data = $query->orderBy('created_at', 'desc')->get();

        $return = [];
        foreach ($data as $item) {
            $return[] = [
                'id' => $item->id,
                'operator' => $item->operator,
                'harga' => $item->harga,
                'kuota_gb' => $item->kuota_gb,
                'masa_aktif_hari' => $item->masa_aktif_hari,
                'ppgb' => $item->ppgb,
                'flag' => $item->flag,
                'latitude' => $item->latitude,
                'longitude' => $item->longitude,
                'user_email' => $item->user_email,
                'created_at' => $item->created_at->toDateTimeString(),
                'files' => $item->Files->map(function ($file) {
                    return [
                        'file_name' => $file->original_name,
                        'file_url' => route('files.view', ['uuid' => $file->uuid]),
                    ];
                }),
            ];

            return response()->json([
                'data' => $return
            ]);
        }
    }
}
