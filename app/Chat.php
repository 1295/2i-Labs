<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    public $fillable = ['first_name', 'last_name','message', 'fb_id'];
}