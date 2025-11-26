<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\File;
use Illuminate\Support\Facades\Auth;

class FileService
{
    public function upload($file, $folder = 'documents', $disk = 'public', $fileable = null, $remark = null)
    {
        $storedName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($folder, $storedName, $disk);

        $fileRecord = File::create([
            'uuid' => uuidGenerator(),
            'original_name' => $file->getClientOriginalName(),
            'stored_name' => $storedName,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'disk' => $disk,
            'path' => $path,
            'folder' => $folder,
            'upload_by' => Auth::user()->uuid ?? null,
            'fileable_id' => optional($fileable)->uuid,
            'fileable_type' => optional($fileable)->getMorphClass(),
            'remark' => $remark
        ]);


        return $fileRecord;
    }

    public function download(File $file)
    {
        // 1. Ambil tipe MIME yang tersimpan di database (ini yang paling dinamis)
        $mimeType = $file->mime_type;

        // 2. Lakukan pengecekan dan penyesuaian khusus (jika diperlukan)
        //    untuk mengatasi masalah umum (misalnya APK terdeteksi sebagai ZIP).
        $extension = pathinfo($file->original_name, PATHINFO_EXTENSION);

        if (strtolower($extension) === 'apk' && $mimeType === 'application/zip') {
            // Jika file adalah APK tetapi terdeteksi sebagai ZIP, paksa tipe yang benar.
            $mimeType = 'application/vnd.android.package-archive';
        }

        // 3. Kembalikan response download dengan header Content-Type yang sudah ditentukan
        return Storage::disk($file->disk)->download(
            $file->path,
            $file->original_name,
            [
                'Content-Type' => $mimeType,
            ]
        );
    }

    public function view(File $file)
    {
        $path = Storage::disk($file->disk)->path($file->path);
        return response()->file($path);
    }

    public function delete(File $file)
    {
        Storage::disk($file->disk)->delete($file->path);
        $file->delete();
        if ($file) {
            return true;
        }
        return false;
    }
}
