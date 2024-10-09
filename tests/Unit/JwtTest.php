<?php

dataset('user', function () {
    $user = new \App\Services\user();
    $user->id = 1;
    $user->name = 'John Doe';
    $user->email = 'john.doe@example.com';
    $user->phone = '1234567890';
    return [$user];
});

test('jwt 验证', function ($user) {
    $jwt = \App\Services\Token\JwtCreator::createByUser($user);
    expect($jwt->getJwtToken())->toBeString()
    ->and($jwt->getUser())->toEqual($user);
})->with('user');

test('无效jwt验证 过期jwt验证', function ($user) {

    $jwt = new \App\Services\Token\JwtToken("dasdasdasd.3123123rrerw.rrewrwe");
    expect($jwt->getUser())->toBeNull();

    $jwt = \App\Services\Token\JwtCreator::createByUser($user);

    $this->travel(1)->days();
    expect($jwt->getUser())->toEqual($user);
    $this->travel(1)->seconds();
    expect($jwt->getUser())->toBeNull();

})->with('user');

test('jwt 验证 中间件', function ($user) {

    $auth = new \App\Http\Middleware\authMiddleware();
    $request = new \Illuminate\Http\Request();
    $request->headers->set('Authorization',  $token
     = \App\Services\Token\JwtCreator::createByUser($user)->getJwtToken());
    $response = $auth->handle($request, function ($request) {
        return response('success');
    });
    expect($response->getContent())->toBe('success');

    $request->headers->set('Authorization', $token . "validate");
    $response = $auth->handle($request, function ($request) {
        return response('success');
    });
    expect($response->getStatusCode())->toBe(401);

})->with('user');



