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
// Home > master_ownership
Breadcrumbs::for('master_ownership', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Setting Master Ownership Unit', route('master_ownership'));
});
// Home > menu_project
Breadcrumbs::for('menu_project', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Projects', route('menu_project'));
});
// Home > menu_area
Breadcrumbs::for('menu_area', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Project Area', route('menu_area'));
});
// Home > menu_bloc
Breadcrumbs::for('menu_bloc', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Project Bloc', route('menu_bloc'));
});
// Home > menu_unit
Breadcrumbs::for('menu_unit', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Project Unit', route('menu_unit'));
});
// Home > menu_request_claim_unit
Breadcrumbs::for('menu_request_claim_unit', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Request Claim Unit', route('menu_request_claim_unit'));
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

// Home > menu_article
Breadcrumbs::for('menu_article', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Article', route('menu_article'));
});
// menu_article > create_article
Breadcrumbs::for('create_article', function (BreadcrumbTrail $trail) {
    $trail->parent('menu_article');
    $trail->push('Create Article', route('create_article'));
});
// menu_article > edit_article
Breadcrumbs::for('edit_article', function (BreadcrumbTrail $trail, $resource) {
    $trail->parent('menu_article');
    $trail->push('Edit Article', route('edit_article', ['id' => $resource->id]));
});
// Home > menu_promotion
Breadcrumbs::for('menu_promotion', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Promotion', route('menu_promotion'));
});
// menu_promotion > create_promotion
Breadcrumbs::for('create_promotion', function (BreadcrumbTrail $trail) {
    $trail->parent('menu_promotion');
    $trail->push('Create Promotion', route('create_promotion'));
});
// menu_promotion > edit_promotion
Breadcrumbs::for('edit_promotion', function (BreadcrumbTrail $trail, $resource) {
    $trail->parent('menu_promotion');
    $trail->push('Edit Promotion', route('edit_promotion', ['id' => $resource->id]));
});
// Home > menu_banner
Breadcrumbs::for('menu_banner', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Banner', route('menu_banner'));
});
// menu_banner > create_banner
Breadcrumbs::for('create_banner', function (BreadcrumbTrail $trail) {
    $trail->parent('menu_banner');
    $trail->push('Create Banner', route('create_banner'));
});
// menu_banner > edit_banner
Breadcrumbs::for('edit_banner', function (BreadcrumbTrail $trail, $resource) {
    $trail->parent('menu_banner');
    $trail->push('Edit banner', route('edit_banner', ['id' => $resource->id]));
});

// Home > menu_facility
Breadcrumbs::for('menu_facility', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Facility', route('menu_facility'));
});
// menu_facility > create_facility
Breadcrumbs::for('create_facility', function (BreadcrumbTrail $trail) {
    $trail->parent('menu_facility');
    $trail->push('Create Banner', route('create_facility'));
});
// menu_facility > edit_facility
Breadcrumbs::for('edit_facility', function (BreadcrumbTrail $trail, $resource) {
    $trail->parent('menu_facility');
    $trail->push('Edit Facility', route('edit_facility', ['id' => $resource->id]));
});
