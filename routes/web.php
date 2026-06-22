<?php

use App\Controllers\AdminController;
use App\Controllers\PageController;

// Public site
$router->get('/', [PageController::class, 'home']);
$router->post('/request', [PageController::class, 'submitRequest']);
$router->get('/secure-services', [PageController::class, 'page']);
$router->get('/services', [PageController::class, 'servicesRedirect']);
$router->get('/virtual-bodyguard', [PageController::class, 'page']);
$router->get('/bravo-comms', [PageController::class, 'page']);
$router->get('/long-term-bookings', [PageController::class, 'page']);
$router->get('/agent-network', [PageController::class, 'page']);
$router->get('/about', [PageController::class, 'page']);
$router->get('/contact', [PageController::class, 'page']);
$router->post('/contact', [PageController::class, 'sendContact']);
$router->get('/manage', [PageController::class, 'page']);
$router->post('/manage', [PageController::class, 'lookup']);

// Admin
$router->get('/admin/setup', [AdminController::class, 'setup']);
$router->post('/admin/setup', [AdminController::class, 'createAdmin']);
$router->get('/admin/login', [AdminController::class, 'login']);
$router->post('/admin/login', [AdminController::class, 'authenticate']);
$router->post('/admin/logout', [AdminController::class, 'logout']);
$router->get('/admin', [AdminController::class, 'dashboard']);
$router->get('/admin/submissions/{id}', [AdminController::class, 'submission']);
$router->post('/admin/submissions/{id}/status', [AdminController::class, 'updateStatus']);
$router->post('/admin/upload', [AdminController::class, 'uploadImage']);
$router->get('/admin/content', [AdminController::class, 'content']);
$router->get('/admin/content/{key}', [AdminController::class, 'editContent']);
$router->post('/admin/content/{key}', [AdminController::class, 'saveContent']);
$router->get('/admin/settings', [AdminController::class, 'settings']);
$router->post('/admin/settings', [AdminController::class, 'updateSettings']);
