<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class File extends Model
{
    protected $fillable = [
        'name',
        'size',
        'type',
        'user_id',
        'file_id'
    ];

    public function delete()
    {
        if ($this->type === 'folder')
            $this->files()->delete();

        return parent::delete();
    }

    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }
}
