<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'file',
        'short_code'
    ];

    protected $appends = ['file_url'];

    function getFileUrlAttribute()
    {
        if (!empty($this->file) && file_exists(public_path('media-files/' . $this->file))) {
            return url('media-files/' . $this->file);
        }
    }
}
