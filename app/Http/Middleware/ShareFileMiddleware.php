<?php

namespace App\Http\Middleware;

use App\File;
use App\Helpers\FileHelper;
use App\Share;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShareFileMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);

        $file = File::find($request->route('file_id'));

        if (null === $request->route('file_id'))
            return $next($request);

        $writeAccess = in_array($request->route()->getName(), [
            'shared.storeFiles',
            'shared.storeFolder',
            'shared.update',
            'shared.destroy'
        ]);

        if (null !== $file && $this->isAllowed($file, $writeAccess))
            return $next($request);

        return redirect()->route('home')->with(__('Vous n\'avez pas acces à cette ressource.'));

    }

    public function isAllowed(File $file, bool $write)
    {
        return FileHelper::isFileSharedToUser($file, Auth::id(), $write)->isNotEmpty();
    }
}
