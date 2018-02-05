<?php

namespace Yoeunes\Commentable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;
use Yoeunes\Commentable\Traits\Commentable;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Yoeunes\Commentable\Exceptions\UserDoestNotHaveID;
use Yoeunes\Commentable\Exceptions\ModelDoesNotUseCommentableTrait;

class CommentQueryBuilder
{
    protected $query = null;

    public function __construct(MorphMany $query)
    {
        $this->query = $query;
    }

    public function from($date)
    {
        $this->query = $this->query->where('created_at', '>=', date_transformer($date));

        return $this;
    }

    public function to($date)
    {
        $this->query = $this->query->where('created_at', '<=', date_transformer($date));

        return $this;
    }

    /**
     * @param $user
     *
     * @return CommentQueryBuilder
     *
     * @throws \Throwable
     */
    public function user($user)
    {
        throw_if($user instanceof Model && empty($user->id), UserDoestNotHaveID::class, 'User object does not have ID');

        $this->query = $this->query->where('user_id', $user instanceof Model ? $user->id : $user);

        return $this;
    }

    /**
     * @param Model $commentable
     *
     * @return CommentQueryBuilder
     *
     * @throws \Throwable
     */
    public function voteable(Model $commentable)
    {
        throw_unless(in_array(Commentable::class, class_uses_recursive($commentable)), ModelDoesNotUseCommentableTrait::class, get_class($commentable).' does not use the Commentable Trait');

        $this->query = $this->query
            ->leftJoin('comments', function (JoinClause $join) use ($commentable) {
                $join
                    ->on('comments.commentable_id', $commentable->getTable() . '.id')
                    ->where('comments.commentable_type', in_array(get_class($commentable), Relation::morphMap()) ? array_search(get_class($commentable), Relation::morphMap()) : get_class($commentable));
            });

        return $this;
    }

    public function getQuery()
    {
        return $this->query;
    }
}
