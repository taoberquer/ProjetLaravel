<?php

namespace App\Http\Middleware;

use App\File;
use Closure;
use Illuminate\Support\Facades\Auth;

class OwnerFileMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $file = File::find($request->route('file_id'));

        if (null === $request->route('file_id') || (
            $this->isFileOwner($file) && null !== $file))
            return $next($request);

        return redirect()->route('home')->with(__('Vous n\'avez pas acces à cette ressource.'));
    }

    public function isFileOwner(File $file)
    {
        return $file->user_id === Auth::id();
    }
}
