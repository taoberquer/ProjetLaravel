<?php

namespace App\Http\Controllers;

use App\File;
use App\Http\Requests\StoreFolderRequest;
use App\Http\Requests\UpdateFileRequest;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index($folderID = null)
    {
        $files = File::where('user_id', Auth::user()
            ->getAuthIdentifier())->where('file_id', $folderID)->get();

        return view('folder.index', compact('files', 'folderID'));
    }

    public function storeFolder(StoreFolderRequest $request, int $folderID = null)
    {
        File::create([
            'name' => $request->get('folder_name'),
            'size' => 0,
            'type' => 'folder',
            'user_id' => Auth::user()->getAuthIdentifier(),
            'file_id' => $folderID
        ]);

        return redirect()->back()->with('status', __('Le dossier a bien été créé.'));
    }

    public function storeFiles(StoreFileRequest $request, int $folderID = null)
    {
        $uploadedFilePath = Storage::putFile('files', $request->file('file'));

        File::create([
            'name' => $request->file('file')->getClientOriginalName(),
            'path' => $uploadedFilePath,
            'size' => $request->file('file')->getSize(),
            'type' => 'file',
            'user_id' => Auth::user()->getAuthIdentifier(),
            'file_id' => $folderID

        ]);

        return redirect()->back()->with('status', __('Le fichier a été téléverser.'));
    }

    public function update(UpdateFileRequest $request, int $fileID)
    {
        File::find($fileID)->update([
            'name' => $request->get('file_name')
        ]);

        return redirect()->back()->with('status', __('L\'élément a été mise à jour.'));
    }

    public function destroy(int $fileID)
    {
        File::find($fileID)->delete();

        return redirect()->back()->with('status', __('L\'élément a été supprimé.'));
    }

    public function download(int $folderID)
    {

    }
}
