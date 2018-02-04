<?php

namespace Yoeunes\Commentable\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\JoinClause;
use Yoeunes\Commentable\CommentBuilder;
use Yoeunes\Commentable\CommentQueryBuilder;
use Yoeunes\Commentable\Models\Comment;

trait Commentable
{
    /**
     * This model has many comments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function commentsCount()
    {
        return $this->comments()->count();
    }

    public function isCommented()
    {
        return $this->comments()->exists();
    }

    public function isCommentedByUser(int $user_id)
    {
        return $this->comments()->where('user_id', $user_id)->exists();
    }

    public function scopeOrderByCommentsCount(Builder $query, string $direction = 'asc')
    {
        return $query
            ->leftJoin('comments', function (JoinClause $join) {
                $join
                    ->on('comments.commentable_id', $this->getTable() . '.id')
                    ->where('comments.commentable_type', Relation::getMorphedModel(__CLASS__) ?? __CLASS__);
            })
            ->addSelect(DB::raw('COUNT(comments.id) as count_comments'))
            ->groupBy($this->getTable(). '.id')
            ->orderBy('count_comments', $direction);
    }

    public function deleteComment(int $comment_id)
    {
        return $this->comments()->where('id', $comment_id)->delete();
    }

    public function resetComments()
    {
        return $this->comments()->delete();
    }

    public function deleteCommentsForUser(int $user_id)
    {
        return $this->comments()->where('user_id', $user_id)->delete();
    }

    public function updateComment(int $comment_id, string $comment)
    {
        return $this->comments()->where('id', $comment_id)->update(['comment' => $comment]);
    }

    public function getCommentBuilder()
    {
        return (new CommentBuilder())
            ->commentable($this);
    }

    /**
     * @return CommentQueryBuilder
     */
    public function getCommentQueryBuilder()
    {
        return new CommentQueryBuilder($this->comments());
    }

    public function commenters()
    {
        return $this->morphToMany(config('commentable.user'), 'commentable', 'comments');
    }
}
