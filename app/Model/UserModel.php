<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table = 'p_users';
    protected $primaryKey = 'user_id';
    public $timestamps = false;
    protected $guarded = [];
}
