<?php

namespace Inggo\Talakdaan\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory() {
        return \Inggo\Talakdaan\Database\Factories\EventFactory::new();
    }
}
