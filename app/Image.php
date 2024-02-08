<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'images';

    protected $fillable = ['name', 'url', 'imageable_id', 'imageable_type'];


    public function imageable()
    {
        return $this->morphTo();
    }
}
