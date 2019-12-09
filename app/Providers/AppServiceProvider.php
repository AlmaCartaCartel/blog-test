<?php

namespace App\Providers;

use App\Category;
use App\Post;
use App\Comment;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use function foo\func;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        view()->composer('pages._sidebar', function($view){
            $view->with('popularPosts' , Post::getPopularPosts());
            $view->with('featuredPosts' , Post::getFeaturedPosts());
            $view->with('newPosts' , Post::getNewPosts());
            $view->with('categories' , Category::all());
        });

        view()->composer('admin._sidebar', function($view){
            $view->with('newPostsCount', Comment::where('status', 0)->count());
        });
    }
}
