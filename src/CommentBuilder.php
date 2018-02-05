<?php

namespace Yoeunes\Commentable;

use Illuminate\Database\Eloquent\Model;
use Yoeunes\Commentable\Models\Comment;
use Yoeunes\Commentable\Traits\Commentable;
use Yoeunes\Commentable\Exceptions\EmptyUser;
use Illuminate\Database\Eloquent\Relations\Relation;
use Yoeunes\Commentable\Exceptions\UserDoestNotHaveID;
use Yoeunes\Commentable\Exceptions\CommentableModelNotFound;
use Yoeunes\Commentable\Exceptions\ModelDoesNotUseCommentableTrait;

class CommentBuilder
{
    protected $user;

    protected $commentable;

    public function __construct()
    {
        if (config('commentable.auth_user')) {
            $this->user = auth()->id();
        }
    }

    /**
     * @param Model|int $user
     *
     * @return CommentBuilder
     *
     * @throws \Throwable
     */
    public function user($user)
    {
        throw_if($user instanceof Model && empty($user->id), UserDoestNotHaveID::class, 'User object does not have ID');

        $this->user = $user instanceof Model ? $user->id : $user;

        return $this;
    }

    /**
     * @param Model $commentable
     *
     * @return CommentBuilder
     *
     * @throws \Throwable
     */
    public function commentable(Model $commentable)
    {
        throw_unless(in_array(Commentable::class, class_uses_recursive($commentable)), ModelDoesNotUseCommentableTrait::class, get_class($commentable).' does not use the Commentable Trait');

        $this->commentable = $commentable;

        return $this;
    }

    /**
     * @param string $body
     *
     * @return Comment
     *
     * @throws \Throwable
     */
    public function comment(string $body)
    {
        throw_if(empty($this->user), EmptyUser::class, 'Empty user');

        throw_if(empty($this->commentable->id), CommentableModelNotFound::class, 'Commentable model not found');

        $data = [
            'user_id'          => $this->user,
            'commentable_id'   => $this->commentable->id,
            'commentable_type' => in_array(get_class($this->commentable), Relation::morphMap()) ? array_search(get_class($this->commentable), Relation::morphMap()) : get_class($this->commentable),
        ];

        $commentModel = config('commentable.comment');

        $comment = (new $commentModel)->fill($data);

        $comment->comment = $body;

        $comment->save();

        return $comment;
    }
}
