<?php

namespace Yoeunes\Commentable;

use Illuminate\Support\ServiceProvider;

class CommentableServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/commentable.php' => config_path('commentable.php'),
        ], 'config');

        if (! class_exists('CreateCommentsTable')) {
            $this->publishes([
                __DIR__.'/../migrations/create_comments_table.php' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_comments_table.php'),
            ], 'migrations');
        }
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/commentable.php', 'commentable');
    }
}
