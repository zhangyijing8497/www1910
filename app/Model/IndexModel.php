<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class IndexModel extends Model
{
    protected $table = 'p_users';
    protected $primaryKey = 'user_id';
    public $timestamps = false;
    protected $guarded = [];
}
