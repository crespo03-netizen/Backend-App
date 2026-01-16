<?php

test('can create a task', function () {

    $data = [
        'name' => 'Test Task',
        'description' => 'This is a test task description.',
        'status' => 'todo',
        'priority' => 'medium',
    ];

    $response = test()->post('/api/tasks', $data);
    $response->assertStatus(201);
});
