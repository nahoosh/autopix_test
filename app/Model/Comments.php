<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\User;
use DB;

class Comments extends Model
{
    protected $table = "comments";
    protected $fillable = ['users_id', 'article_id', 'comment','created_at','updated_at'];

    public function getUserNameAttribute()
    {
        $user = User::find($this->user_id);
        if($user)
        {
            return $user->name;
        }
        else
        {
            return '';
        }
    }
}
