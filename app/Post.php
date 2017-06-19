<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    // protected $fillable = [ 'title', 'fulltext' ]; // white list for mass assignment
    // protected $guarded = ['is_admin']; // black list for mass assignment

    use SoftDeletes;

    protected $dates = ["delete_at"];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function photos() {
        return $this->morphMany('App\Photo', 'imageable');
    }    
}
