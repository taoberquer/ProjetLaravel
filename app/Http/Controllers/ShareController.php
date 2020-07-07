<?php

namespace App\Http\Controllers;

use App\File;
use App\Http\Requests\StoreShareRequest;
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

        $files = Share::with('file')->where('user_id', Auth::user()
            ->getAuthIdentifier())->get();

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
}
