<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{

    protected $fillable = [
        'uuid',
        'original_name',
        'stored_name',
        'mime_type',
        'size',
        'disk',
        'path',
        'folder',
        'fileable_id',
        'fileable_type',
        'upload_by',
        'remark'
    ];

    public function UploadBy()
    {
        return $this->belongsTo(User::class,  'upload_by', 'uuid');
    }
}
