<?php

use App\Models\User;
use App\Http\Controllers\DashboardController;

test('can see dashboard page & can view scripts', function () {
    $user = User::first();
    
    // Login as the test user
    $this->actingAs($user);
    
    // Make a GET request to the /dashboard route
    $response = $this->get('/dashboard');
    
    // Assert that the response status code is 200 (OK)
    $response->assertStatus(200);
    
    $controller = new DashboardController();
    
    // Call the index() method to generate the $scripts variable
    $view = $controller->index();
    $scriptsVariable = $view->getData()['scripts'];
    
    $this->assertGreaterThan(1, count($scriptsVariable));
});
