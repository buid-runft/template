<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class File extends Model
{
    protected $fillable = [
        'name', 'path', 'disk', 'file_hash', 'collection', 'size',
        'mime_type', 'fileable_type', 'fileable_id'
    ];

    protected $casts = [
        'size' => 'integer',
    ];

    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }
}
