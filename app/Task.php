<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    protected $attributes = [
        'is_finished' => 0,
        'finished_at' => ''
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
