<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Services\FileService;
use Illuminate\Http\Request;

class FileController extends Controller
{


    public function upload(Request $request, FileService $fileService)
    {
        $request->validate([
            'file' => 'required|file|max:2048',
        ]);

        $file = $fileService->upload($request->file('file'), 'documents');

        return response()->json(['message' => 'File uploaded', 'file' => $file]);
    }

    public function download($uuid, FileService $fileService)
    {
        $file = File::where('uuid', $uuid)->firstOrFail();
        return $fileService->download($file);
    }

    public function view($uuid, FileService $fileService)
    {
        $file = File::where('uuid', $uuid)->firstOrFail();
        return $fileService->view($file);
    }

    public function delete($uuid, FileService $fileService)
    {
        $file = File::where('uuid', $uuid)->firstOrFail();
        $fileService->delete($file);

        return response()->json(['message' => 'File deleted']);
    }
    public function viewPublic($uuid, FileService $fileService)
    {
        $file = File::where('uuid', $uuid)->firstOrFail();
        return $fileService->view($file);
    }
}
