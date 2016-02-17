<?php

namespace Spatie\Rss;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Response;

class Rss
{
    protected $app;

    public function __construct(Application $app){

        $this->app = $app;

    }

    public function feed($feed)
    {

        $items = explode('@', $feed['items']);

        $data['items'] = $this->app->make($items[0])->getAllOnline()->map(function($item){

            return $item->getFeedData();
        });

        $data['meta'] = $feed['meta'];

        return Response::view('laravel-rss::rss', $data, 200, ['Content-Type' => 'application/atom+xml; chartset=UTF-8']);

    }
}