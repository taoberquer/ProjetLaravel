<?php

namespace App\Http\Controllers;

use App\File;
use App\Helpers\FileHelper;
use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\StoreFolderRequest;
use App\Http\Requests\StoreShareRequest;
use App\Http\Requests\UpdateFileRequest;
use App\Share;
use App\User;
use Illuminate\Support\Facades\Auth;
class ShareController extends Controller
{
    public function index($folderID = null)
    {
        $breadcrumbs = [];
//        if(null !== $folderID)
//            $breadcrumbs = File::find($folderID)->getBreadcrumbsArray();

        $files = null === $folderID ? (User::find(1))->filesFromShares : File::find($folderID)->files;

        return view('shared.index', compact('files', 'folderID', 'breadcrumbs'));
    }

    public function storeFolder(StoreFolderRequest $request, int $folderID)
    {
        (new FileHelper())->storeFolder(
            $request,
            (File::find($folderID))->user->id,
            $folderID
        );

        return redirect()->back()->with('status', __('Le dossier a bien été créé.'));
    }

    public function storeFiles(StoreFileRequest $request, int $folderID)
    {
        (new FileHelper())->storeFile(
            $request,
            (File::find($folderID))->user->id,
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
