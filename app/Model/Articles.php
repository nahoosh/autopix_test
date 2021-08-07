<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Model\Comments;
use DB;

class Articles extends Model
{
    protected $table = "articles";
    protected $fillable = ['users_id', 'title', 'description', 'tags','image'];

    public function getUserNameAttribute()
    {
        $user = User::find($this->users_id);
        if($user)
        {
            return $user->name;
        }
        else
        {
            return '';
        }
    }

    public function getTagNamesAttribute()
    {
        $tags = explode(",",$this->tags);
        $myTag = '';
        foreach($tags as $tag)
        {
            $myTag .= '<span class="badge badge-info">'.$tag.'</span> ';
        }
        return $myTag;
    }

    public function getCommentDetailsAttribute()
    {
        $comments = Comments::where('article_id',$this->id)->orderBy('created_at','desc')->get();
        return $comments;
    }
}
