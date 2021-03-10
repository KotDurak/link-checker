<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = [
        'donor_page',
        'project_id',
        'user_id'
    ];


    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
