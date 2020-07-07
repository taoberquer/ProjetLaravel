<?php

namespace App\Http\Controllers;

use App\File;
use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\UpdateFileRequest;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    public function index($folderID = null)
    {
        $files = File::where('user_id', Auth::user()
            ->getAuthIdentifier())->where('file_id', $folderID)->get();

        return view('folder.index', compact('files'));
    }

    public function store(StoreFileRequest $request, int $folderID = null)
    {
        File::create([
            'name' => $request->get('file_name'),
            'size' => 0,
            'type' => 'file',
            'user_id' => Auth::user()->getAuthIdentifier(),
        ]);

        return redirect()->back()->with('status', __('L\'élément a bien été créé.'));
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
