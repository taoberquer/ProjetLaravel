<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    protected $fillable = [
        'name',
        'path',
        'size',
        'type',
        'user_id',
        'file_id'
    ];

    public function delete()
    {
        if ($this->type === 'folder')
            $this->files()->delete();

        if ($this->type === 'file')
            Storage::delete($this->path);

        return parent::delete();
    }

    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function shares(): HasMany
    {
        return $this->hasMany(Share::class);
    }

    public function share(): BelongsTo
    {
        return $this->belongsTo(Share::class);
    }

    public function getBreadcrumbsArray(): array
    {
        if (null === $this->file_id)
            return [$this->id => $this->name];

        $breadcrumbs = $this->file->getBreadcrumbsArray();
        $breadcrumbs[$this->id] = $this->name;

        return $breadcrumbs;
    }

    public static function sharedFiles($userID)
    {
        return DB::table('files')
            ->rightJoin('shares', 'files.id', '=', 'shares.file_id')
            ->where('shares.user_id', '=', $userID)
            ->get();
    }
}
