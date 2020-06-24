<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateSettingsRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Show the user settings.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function editSettings()
    {
        $user = Auth::user();

        return view('settings', compact('user'));
    }

    public function updateSettings(UpdateSettingsRequest $request)
    {
        $data = $request->all();

        Auth::user()->update($data);

        return back()->with('status', 'Vos informations ont été modifiées');
    }
}
