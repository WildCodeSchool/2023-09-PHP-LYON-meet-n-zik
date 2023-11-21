<?php

// list of accessible routes of your application, add every new route here
// key : route to match
// values : 1. controller name
//          2. method name
//          3. (optional) array of query string keys to send as parameter to the method
// e.g route '/item/edit?id=1' will execute $itemController->edit(1)
return [
    '' => ['HomeController', 'index',],
    'login' => ['UserController', 'login',],
    'logout' => ['UserController', 'logout'],
    'signup' => ['UserController', 'registration',],
    'host/show' => ['HostController', 'index',['id']],
    'band/show' => ['BandController', 'index',['id']],
    'items' => ['ItemController', 'index',],
    'items/edit' => ['ItemController', 'edit', ['id']],
    'items/show' => ['ItemController', 'show', ['id']],
    'items/add' => ['ItemController', 'add',],
    'meet' => ['UserController', 'userIndex',],
    'items/delete' => ['ItemController', 'delete',],
    'interact' => ['InteractionController', 'interact',],
    'liking' => ['MatchController', 'likingUser', ['targetId']],
    'matches/show' => ['MatchController', 'show', ['id']],
    'matches/like' => ['InteractionController', 'like', ['id']],
    'matches/dislike' => ['InteractionController', 'dislike', ['id']],
    'account' => ['UserController', 'showUser',['id']],
    'account/edit' => ['UserController', 'editProfil',['id']],
    'my-matches' => ['UserController', 'showMatches', ['id']],
];
