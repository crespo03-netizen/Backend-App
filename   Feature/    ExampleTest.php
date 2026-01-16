<?php

use Pest\Laravel;

it('tests the get method', function () {
    $response = Laravel\get('/your-endpoint');
    $response->assertStatus(200);
});