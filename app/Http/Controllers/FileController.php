<?php

namespace App\Http\Controllers;

use App\File;
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

    }

    public function update(UpdateFileRequest $request, int $folderID)
    {

    }

    public function destroy(int $folderID)
    {

    }

    public function download(int $folderID)
    {

    }
}
