<?php

use Yoeunes\Commentable\Models\Comment;
use Yoeunes\Commentable\Tests\Stubs\Models\User;
use Yoeunes\Commentable\Tests\Stubs\Models\Lesson;

$factory(Lesson::class, [
    'title'   => $faker->sentence,
    'subject' => $faker->words(2),
]);

$factory(Comment::class, [
    'comment'          => $faker->text,
    'user_id'          => 'factory:Yoeunes\Commentable\Tests\Stubs\Models\User',
    'commentable_id'   => 'factory:Yoeunes\Commentable\Tests\Stubs\Models\Lesson',
    'commentable_type' => Lesson::class,
]);

$factory(User::class, [
    'name'           => $faker->name,
    'email'          => $faker->unique()->safeEmail,
    'password'       => bcrypt('secret'),
    'remember_token' => str_random(10),
]);
