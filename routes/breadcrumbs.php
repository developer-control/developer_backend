<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
});

// Home > master_role
Breadcrumbs::for('master_role', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Setting Role Access', route('master_role'));
});

// Home > master_developer
Breadcrumbs::for('master_developer', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Setting Master Developer', route('master_developer'));
});
// Home > menu_project
Breadcrumbs::for('menu_project', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Data Project', route('menu_project'));
});

// Home > location_province
Breadcrumbs::for('location_province', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Location Province', route('location_province'));
});
// Home > location_city
Breadcrumbs::for('location_city', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Location City', route('location_city'));
});
