<?php

return \FastRoute\simpleDispatcher(function(\FastRoute\RouteCollector $route){
    // Home
    $route->addRoute('GET', '/', [Application\Controllers\HomeController::class, 'index']);
    // Login
    $route->addRoute('GET', '/login', [Application\Controllers\LoginController::class, 'login']);
    $route->addRoute('POST', '/login', [Application\Controllers\LoginController::class, 'login']);
    $route->addRoute('GET', '/logout', [Application\Controllers\LoginController::class, 'logout']);
    // Registro
    $route->addRoute('GET', '/register', [Application\Controllers\RegisterController::class, 'register']);
    $route->addRoute('POST', '/register', [Application\Controllers\RegisterController::class, 'register']);
    // Profile
    $route->addRoute('GET', '/profile', [Application\Controllers\ProfileController::class, 'index', 'auth']);
    // Blogs
    $route->addRoute('GET', '/blog[/{page:\d+}]', [Application\Controllers\BlogController::class, 'index', 'auth']);
});