<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
Route::post('/auth/token', function (Request $request) {
    if ( $request->post('phone') == "1234567890" && $request->post('password') == md5("123456") ) {
        $user = new \App\Services\user();
        $user->id = 1;
        $user->name = 'John Doe';
        $user->email = 'john.doe@example.com';
        $user->phone = '1234567890';
    }else {
        return response()->json(['error' => 'Invalid credentials'], 401);
    }
    return response()->json(['access_token' => (\App\Services\Token\JwtCreator::class::createByUser($user))->getJwtToken()]);
});

Route::get('/auth/info', function (Request $request) {
    return response()->json(['data' => app(\App\Services\user::class)]);
})->middleware(\App\Http\Middleware\authMiddleware::class);
