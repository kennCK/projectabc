<?php

namespace Increment\Comment\Models;

use Illuminate\Database\Eloquent\Model;
use App\APIModel;

class CommentReply extends APIModel
{
    protected $table = 'inc_comment_replies';
    protected $fillable = ['account_id', 'inc_comment_id', 'text'];
}
