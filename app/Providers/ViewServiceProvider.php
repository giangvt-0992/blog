<?php

namespace App\Providers;

use App\Model\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
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
        // $news = $this->getNewFeed();
        
        View::composer('_partial.navbar', function ($view) {
            $news = [];
            if(Auth::check()){
                $user = Auth::user();
                // $news = $user->event_owners()->with(['action:id,actionable_type,actionable_id', 'action.actionable:id', 'creator:id,name'])->orderBy('updated_at', 'DESC')->get();
                $news = Event::where('owner_id', '=', $user->id)
                        ->where(function($query) use ($user){
                            $query->where('creator_id', '!=' , $user->id)
                                ->orWhere('creator_id', '=', null);
                            
                        })
                        ->with(['action:id,actionable_type,actionable_id', 'action.actionable:id', 'creator:id,name'])->orderBy('updated_at', 'DESC')->get();

            }

            $view->with('news', $news);
        });
    }

}