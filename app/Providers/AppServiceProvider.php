<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Response::macro('success', function($data, $message){
            return response()->json([
                'status' => 200,
                'message' => $message,
                'data' => $data
            ], 200);
        });
        Response::macro('failed', function($message){
            return response()->json([
                'status' => 400,
                'message' => $message
            ], 400);
        });

        Response::macro('empty', function(){
            return response()->json([
                'status' => 400,
                'message' => 'No Record To Show'
            ], 400);
        });


    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
