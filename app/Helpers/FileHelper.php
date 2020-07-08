<?php

namespace App\Helpers;

use App\File;
use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\StoreFolderRequest;
use App\Http\Requests\UpdateFileRequest;
use App\Share;
use Illuminate\Database\Eloquent\Collection;
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

    public static function isFileSharedToUser(File $file, int $userID, bool $write): Collection
    {
        $shares = Share::with('file')->where('user_id', '=', $userID)->get();

        return $shares->filter(function ($share) use ($file, $write) {
            if ($share->file->user_id !== $file->user_id)
                return false;

            return $share->file_id === $file->id && (
                $share->write === $write || $write === false);
        });
    }

}
