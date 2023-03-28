<?php

use Browser;
use App\Models\User;
use App\Models\Script;
use App\Http\Controllers\DashboardController;

test('can see dashboard page & can view scripts and categories', function () {
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
    $categoriesVariable = $view->getData()['categories'];
    
    $this->assertGreaterThan(1, count($scriptsVariable));

    $this->assertGreaterThan(1, count($categoriesVariable));
});


it('should render all scripts on the dashboard', function () {

    $scripts = Script::limit(6)->get();

    $response = $this->actingAs(User::first())->get('/dashboard');

    $response->assertStatus(200);
    $response->assertViewIs('dashboard');
    $response->assertViewHas('scripts', function ($scripts) {
        return count($scripts) >= 1;
    });
    
});