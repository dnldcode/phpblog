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
    '~^adminpanel/users/(\d+)/articles$~' => [\MyProject\Controllers\AdminPanelController::class, 'articlesById'],
    '~^adminpanel/users/(\d+)/comments$~' => [\MyProject\Controllers\AdminPanelController::class, 'commentsById'],
    '~^adminpanel/users/id(\d+)$~' => [\MyProject\Controllers\AdminPanelController::class, 'userView'],
    '~^adminpanel/articles/requests$~' => [\MyProject\Controllers\AdminPanelController::class, 'articlesToPublish'],
    '~^articles/(\d+)/publish$~' => [\MyProject\Controllers\ArticlesController::class, 'publish'],
    '~^articles/(\d+)/hide$~' => [\MyProject\Controllers\ArticlesController::class, 'hide'],
    '~^myarticles$~' => [\MyProject\Controllers\ArticlesController::class, 'articlesByUser'],
    '~^$~' => [\MyProject\Controllers\MainController::class, 'main']
];