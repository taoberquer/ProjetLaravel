<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Support\Facades\Auth;

class FolderController extends Controller
{
    public function index($folderID = null)
    {
        $files = File::where('user_id', Auth::user()
            ->getAuthIdentifier())->where('file_id', $folderID)->get();

        return view('folder.index', compact('files'));
    }
}
