<?php

return [
    '~^articles/(\d+)$~' => [\MyProject\Controllers\ArticlesController::class, 'view'],
    '~^articles/(\d+)/edit$~' => [\MyProject\Controllers\ArticlesController::class, 'edit'],
    '~^articles/(\d+)/delete$~' => [\MyProject\Controllers\ArticlesController::class, 'delete'],
    '~^articles/add$~' => [\MyProject\Controllers\ArticlesController::class, 'add'],
    '~^users/register$~' => [\MyProject\Controllers\UsersController::class, 'signUp'],
    '~^users/(\d+)/activate/(.+)$~' => [\MyProject\Controllers\UsersController::class, 'activate'],
    '~^users/login$~' => [\MyProject\Controllers\UsersController::class, 'login'],
    '~^users/logout$~' => [\MyProject\Controllers\UsersController::class, 'logout'],
    '~^articles/(\d+)/comments$~' => [\MyProject\Controllers\CommentsController::class, 'addComment'],
    '~^comments/(\d+)/edit$~' => [\MyProject\Controllers\CommentsController::class, 'edit'],
    '~^comments/(\d+)/delete$~' => [\MyProject\Controllers\CommentsController::class, 'delete'],
    '~^user/id(\d+)$~' => [\MyProject\Controllers\UsersController::class, 'show'],
    '~^settings$~' => [\MyProject\Controllers\UsersController::class, 'settings'],
    '~^adminpanel$~' => [\MyProject\Controllers\AdminPanelController::class, 'view'],
    '~^adminpanel/comments$~' => [\MyProject\Controllers\AdminPanelController::class, 'comments'],
    '~^adminpanel/users$~' => [\MyProject\Controllers\AdminPanelController::class, 'users'],
    '~^$~' => [\MyProject\Controllers\MainController::class, 'main']
];