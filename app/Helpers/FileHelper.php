<?php

namespace App\Helpers;

use App\File;
use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\StoreFolderRequest;
use App\Http\Requests\UpdateFileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileHelper
{
    public function storeFolder(Request $request, int $userID, int $folderID = null)
    {
        File::create([
            'name' => $request->get('folder_name'),
            'size' => 0,
            'type' => 'folder',
            'user_id' => $userID,
            'file_id' => $folderID
        ]);

    }

    public function storeFile(Request $request, int $userID, int $folderID = null)
    {
        $uploadedFilePath = Storage::putFile('files', $request->file('file'));

        File::create([
            'name' => $request->file('file')->getClientOriginalName(),
            'path' => $uploadedFilePath,
            'size' => $request->file('file')->getSize(),
            'type' => 'file',
            'user_id' => $userID,
            'file_id' => $folderID

        ]);
    }

    public function updateFile(UpdateFileRequest $request, int $fileID)
    {
        File::find($fileID)->update([
            'name' => $request->get('file_name')
        ]);
    }

    public function destroyFile(int $fileID)
    {
        File::find($fileID)->delete();
    }

    public function downloadFile(int $fileID)
    {
        $file = File::find($fileID);

        return Storage::download($file->path, $file->name);
    }
}
