<?php

return [
    'comment'        => Yoeunes\Commentable\Models\Comment::class,
    'user'           => App\User::class,
    'auth_user'      => true,

    /*
     * Register here your custom date transformers. When the package get one of
     * the below keys, it will use the value instead.
     *
     * Keep it empty, if you don't want any date transformers!
     */
    'date-transformers' => [
        // 'past24hours' => Carbon::now()->subDays(1),
        // 'past7days'   => Carbon::now()->subWeeks(1),
        // 'past14days'  => Carbon::now()->subWeeks(2),
    ],
];
