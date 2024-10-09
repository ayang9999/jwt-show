<?php

test('login', function () {

    $response = $this->post('/api/auth/token');

    $response->assertStatus(401);

    $response = $this->post('/api/auth/token', ['phone' => '1234567890', 'password' => md5('123456')]);

    $response->assertStatus(200);

    return $response->json()['access_token'];
});


test('获取用户信息 ', function ($token) {
    $response = $this->get('/api/auth/info');
    $response->assertStatus(401);

    $response = $this->get('/api/auth/info', ['Authorization' => $token]);
    $response->assertStatus(200);

    expect($response->json()['data']['phone'])->toBe('1234567890');

})->depends('login');
