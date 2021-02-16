<?php

namespace App\Providers;

use App\Menu;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

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
    public function boot(Dispatcher $events)
    {
        // Using dynamic menu from database
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $headers = Menu::getMenuTree();
            
            foreach ($headers as $header) {
                $items = collect();
                $event->menu->add(trans($header->title));
                
                foreach ($header->childs as $child) {
                    $fuckinChild = [
                        'text' => $child->title,
                        'url' => $child->url
                    ];

                    $items->push($fuckinChild);
                }
                $event->menu->add(...$items);
            }
    
        });
    }
}
