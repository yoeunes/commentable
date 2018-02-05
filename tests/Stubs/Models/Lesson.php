<?php

namespace Yoeunes\Commentable\Tests\Stubs\Models;

use Illuminate\Database\Eloquent\Model;
use Yoeunes\Commentable\Traits\Commentable;

class Lesson extends Model
{
    use Commentable;

    protected $connection = 'testbench';

    protected $fillable = [
        'title',
        'subject',
    ];
}
