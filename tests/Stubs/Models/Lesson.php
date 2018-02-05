<?php

namespace Yoeunes\Commentable\Tests\Stubs\Models;

use Yoeunes\Commentable\Traits\Commentable;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use Commentable;

    protected $connection = 'testbench';

    protected $fillable = [
        'title',
        'subject',
    ];
}
