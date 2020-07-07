<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function getBreadcrumbsArray()
    {
        
    }
}
