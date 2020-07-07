<?php

namespace App\Http\Controllers;

use App\File;
use App\Http\Requests\StoreFolderRequest;
use App\Http\Requests\UpdateFileRequest;
use Illuminate\Support\Facades\Auth;

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

    public function storeFiles(StoreFolderRequest $request, int $folderID = null)
    {

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
