<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::any('/example', function (Request $request) {
    $search = $request->input('q');
    return Cache::rememberForever('options', function () {
        return User::factory()
            ->count(20000)
            ->make()
            ->map(function ($user, $i) {
                return [
                    'value' => $i,
                    'label' => "{$user->name}",
                ];
            });
    })->when(!empty($search), function ($collection) use ($search) {
        return $collection->filter(function ($option) use ($search) {
            return strpos(strtolower(serialize($option)), strtolower($search)) !== false;
        });
    })->values()->all();
});
