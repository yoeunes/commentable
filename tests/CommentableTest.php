<?php

namespace Yoeunes\Commentable\Tests;

use Laracasts\TestDummy\Factory;
use Yoeunes\Commentable\Models\Comment;
use Yoeunes\Commentable\Tests\Stubs\Models\User;
use Yoeunes\Commentable\Tests\Stubs\Models\Lesson;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class CommentableTest extends TestCase
{
    /** @test */
    public function it_test_if_commentable_is_a_morph_to_relation()
    {
        /** @var Comment $comment */
        $comment = Factory::create(Comment::class);
        $this->assertInstanceOf(MorphTo::class, $comment->commentable());
    }

    /** @test */
    public function it_test_if_user_is_a_belongs_to_relation()
    {
        /** @var Comment $comment */
        $comment = Factory::create(Comment::class);
        $this->assertInstanceOf(BelongsTo::class, $comment->user());
    }

    /** @test */
    public function it_test_if_comments_is_a_morph_many_relation()
    {
        /** @var Lesson $lesson */
        $lesson = Factory::create(Lesson::class);
        $this->assertInstanceOf(MorphMany::class, $lesson->comments());
    }

    /** @test */
    public function it_get_comments_count()
    {
        /** @var Lesson $lesson */
        $lesson = Factory::create(Lesson::class);

        Factory::create(Comment::class, ['commentable_id' => $lesson->id]);
        Factory::create(Comment::class, ['commentable_id' => $lesson->id]);
        Factory::create(Comment::class, ['commentable_id' => $lesson->id]);

        $this->assertEquals(3, $lesson->commentsCount());
    }

    /** @test */
    public function it_test_if_a_lesson_if_is_commented()
    {
        $lessons = Factory::times(2)->create(Lesson::class);

        $user = Factory::create(User::class);

        Factory::create(Comment::class, ['commentable_id' => $lessons[0]->id, 'user_id' => $user->id]);
        Factory::create(Comment::class, ['commentable_id' => $lessons[0]->id]);
        Factory::create(Comment::class, ['commentable_id' => $lessons[1]->id]);

        $this->assertTrue($lessons[0]->isCommented());
        $this->assertTrue($lessons[0]->isCommentedByUser($user->id));
        $this->assertFalse($lessons[1]->isCommentedByUser($user->id));
    }

    /** @test */
    public function it_comment_lesson_using_comment_builder()
    {
        /** @var Lesson */
        $lesson = Factory::create(Lesson::class);

        /** @var User $user */
        $user = Factory::create(User::class);

        $comment = $lesson
            ->getCommentBuilder()
            ->user($user)
            ->comment('this is a fake comment');

        $this->assertEquals(1, $lesson->commentsCount());
        $this->assertEquals($comment->comment, $lesson->comments()->first()->comment);
    }

    /** @test */
    public function it_test_delete_comment()
    {
        /** @var Lesson $lesson */
        $lesson = Factory::create(Lesson::class);

        Factory::create(Comment::class, ['commentable_id' => $lesson->id]);
        Factory::create(Comment::class, ['commentable_id' => $lesson->id]);
        $comment = Factory::create(Comment::class, ['commentable_id' => $lesson->id]);

        $this->assertEquals(3, $lesson->commentsCount());

        $lesson->deleteComment($comment->id);
        $this->assertEquals(2, $lesson->commentsCount());
    }

    /** @test */
    public function it_test_delete_comments_for_a_user()
    {
        /** @var Lesson $lesson */
        $lesson = Factory::create(Lesson::class);

        $user = Factory::create(User::class);

        Factory::create(Comment::class, ['commentable_id' => $lesson->id, 'user_id' => $user->id]);
        Factory::create(Comment::class, ['commentable_id' => $lesson->id, 'user_id' => $user->id]);
        Factory::create(Comment::class, ['commentable_id' => $lesson->id]);

        $lesson->deleteCommentsForUser($user->id);
        $this->assertEquals(1, $lesson->commentsCount());
    }

    /** @test */
    public function it_test_reset_comments_for_a_lesson()
    {
        $lessons = Factory::times(3)->create(Lesson::class);

        Factory::times(3)->create(Comment::class, ['commentable_id' => $lessons[0]->id]);
        Factory::create(Comment::class, ['commentable_id' => $lessons[1]->id]);
        Factory::create(Comment::class, ['commentable_id' => $lessons[2]->id]);

        $lessons[0]->resetComments();

        $this->assertEquals(0, $lessons[0]->commentsCount());
        $this->assertEquals(1, $lessons[1]->commentsCount());
        $this->assertEquals(1, $lessons[2]->commentsCount());
    }

    /** @test */
    public function it_test_update_comment()
    {
        /** @var Lesson $lesson */
        $lesson = Factory::create(Lesson::class);

        $comment = Factory::create(Comment::class, ['commentable_id' => $lesson->id]);

        $this->assertEquals(1, $lesson->commentsCount());

        $lesson->updateComment($comment->id, 'this is a fake comment');

        $this->assertEquals('this is a fake comment', $lesson->comments()->first()->comment);
    }

    /** @test */
    public function it_get_commenters_for_a_specific_lesson()
    {
        /** @var Lesson $lesson */
        $lesson = Factory::create(Lesson::class);

        $users = Factory::times(2)->create(User::class);

        Factory::create(Comment::class, ['commentable_id' => $lesson->id, 'user_id' => $users[0]->id]);
        Factory::create(Comment::class, ['commentable_id' => $lesson->id, 'user_id' => $users[1]->id]);
        Factory::times(3)->create(Comment::class, ['commentable_id' => $lesson->id]);
        Factory::times(4)->create(Comment::class);

        $this->assertCount(5, $lesson->commenters()->get());
    }
}
