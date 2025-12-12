<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table      = 'comments';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'post_id','user_name','user_email','content','status'
    ];

    public function getApprovedByPost($postId)
    {
        return $this->where('post_id', $postId)
                    ->where('status','approved')
                    ->orderBy('created_at','ASC')
                    ->findAll();
    }
}
