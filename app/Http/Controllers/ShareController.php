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

        $files = null === $folderID ? (User::find(Auth::id()))->filesFromShares : File::find($folderID)->files;

        return view('shared.index', compact('files', 'folderID', 'breadcrumbs'));
    }

    public function show(int $fileID)
    {
        $shares = File::find($fileID)->shares;

        return view('share.show', compact('shares', 'fileID'));
    }

    public function store(StoreShareRequest $request, int $fileID)
    {
        $user = User::where('email', $request->get('email'))->first();

        Share::create([
            'read' => true,
            'write' => (bool)$request->get('write') ?? false,
            'file_id' => $fileID,
            'user_id' => $user->id,
        ]);

        return redirect()->back()->with('status', 'L\'utilisateur a été ajouté.');
    }

    public function destroy(int $fileID, int $shareID)
    {
        Share::find($shareID)->delete();

        return redirect()->back()->with('status', 'Le partage a été supprimé.');
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

    public function updateFile(UpdateFileRequest $request, int $fileID)
    {
        (new FileHelper())->updateFile($request, $fileID);

        return redirect()->back()->with('status', __('L\'élément a été mise à jour.'));
    }

    public function destroyFile(int $fileID)
    {
        (new FileHelper())->destroyFile($fileID);

        return redirect()->back()->with('status', __('L\'élément a été supprimé.'));
    }

    public function download(int $fileID)
    {
        return (new FileHelper())->downloadFile($fileID);
    }
}
