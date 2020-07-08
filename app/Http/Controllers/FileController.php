<?php

namespace App\Http\Controllers;

use App\File;
use App\Helpers\FileHelper;
use App\Http\Requests\StoreFolderRequest;
use App\Http\Requests\UpdateFileRequest;
use App\Http\Requests\StoreFileRequest;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index($folderID = null)
    {
        $breadcrumbs = [];
        if(null !== $folderID)
            $breadcrumbs = File::find($folderID)->getBreadcrumbsArray();

        $files = File::where('user_id', Auth::user()
            ->getAuthIdentifier())->where('file_id', $folderID)->get();

        return view('folder.index', compact('files', 'folderID', 'breadcrumbs'));
    }

    public function storeFolder(StoreFolderRequest $request, int $folderID = null)
    {
        (new FileHelper())->storeFolder(
            $request,
            Auth::user()->getAuthIdentifier(),
            $folderID
        );

        return redirect()->back()->with('status', __('Le dossier a bien été créé.'));
    }

    public function storeFiles(StoreFileRequest $request, int $folderID = null)
    {
        (new FileHelper())->storeFile(
            $request,
            Auth::user()->getAuthIdentifier(),
            $folderID
        );

        return redirect()->back()->with('status', __('Le fichier a été téléverser.'));
    }

    public function update(UpdateFileRequest $request, int $fileID)
    {
        (new FileHelper())->updateFile($request, $fileID);

        return redirect()->back()->with('status', __('L\'élément a été mise à jour.'));
    }

    public function destroy(int $fileID)
    {
        (new FileHelper())->destroyFile($fileID);

        return redirect()->back()->with('status', __('L\'élément a été supprimé.'));
    }

    public function download(int $fileID)
    {
        return (new FileHelper())->downloadFile($fileID);
    }
}
