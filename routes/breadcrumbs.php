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

// menu_unit > menu_detail_unit
Breadcrumbs::for('menu_detail_unit', function (BreadcrumbTrail $trail, $resource) {
    $trail->parent('menu_unit');
    $trail->push('Detail Unit', route('menu_detail_unit', ['id' => $resource->id]));
});
// Home > menu_request_claim_unit
Breadcrumbs::for('menu_request_claim_unit', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Request Claim Unit', route('menu_request_claim_unit'));
});

// Home > menu_history_claim_unit
Breadcrumbs::for('menu_history_claim_unit', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('History Claim Unit', route('menu_history_claim_unit'));
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
    $trail->push('Create Facility', route('create_facility'));
});
// menu_facility > edit_facility
Breadcrumbs::for('edit_facility', function (BreadcrumbTrail $trail, $resource) {
    $trail->parent('menu_facility');
    $trail->push('Edit Facility', route('edit_facility', ['id' => $resource->id]));
});

// Home > menu_support
Breadcrumbs::for('menu_support', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Bantuan', route('menu_support'));
});
// Home > menu_support
Breadcrumbs::for('menu_emergency', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Nomor Darurat', route('menu_emergency'));
});

// Home > menu_term_condition
Breadcrumbs::for('menu_term_condition', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Term & Condition', route('menu_term_condition'));
});
// menu_term_condition > create_term_condition
Breadcrumbs::for('create_term_condition', function (BreadcrumbTrail $trail) {
    $trail->parent('menu_term_condition');
    $trail->push('Create Term & Condition', route('create_term_condition'));
});
// menu_term_condition > edit_facility
Breadcrumbs::for('edit_term_condition', function (BreadcrumbTrail $trail, $resource) {
    $trail->parent('menu_term_condition');
    $trail->push('Edit Term & Condition', route('edit_term_condition', ['id' => $resource->id]));
});

// Home > menu_faq
Breadcrumbs::for('menu_faq', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('FAQ', route('menu_faq'));
});
// Home > menu_bill_type
Breadcrumbs::for('menu_bill_type', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Setting Type Tagihan', route('menu_bill_type'));
});
// Home > menu_access_card
Breadcrumbs::for('menu_access_card', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Access Card', route('menu_access_card'));
});
// Home > menu_complain
Breadcrumbs::for('menu_complain', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Complain User', route('menu_complain'));
});
// menu_complain > menu_detail_complain
Breadcrumbs::for('menu_detail_complain', function (BreadcrumbTrail $trail, $resource) {
    $trail->parent('menu_complain');
    $trail->push('Complain User', route('menu_detail_complain', ['id' => $resource->id]));
});

// Home > menu_bill
Breadcrumbs::for('menu_bill', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Tagihan Unit', route('menu_bill'));
});
// menu_bill > create_bill
Breadcrumbs::for('create_bill', function (BreadcrumbTrail $trail) {
    $trail->parent('menu_bill');
    $trail->push('Tagihan Unit', route('create_bill'));
});
// menu_bill > edit_bill
Breadcrumbs::for('edit_bill', function (BreadcrumbTrail $trail, $resource) {
    $trail->parent('menu_bill');
    $trail->push('Edit Tagihan Unit', route('edit_bill', ['id' => $resource->id]));
});
// menu_bill > menu_detail_bill
Breadcrumbs::for('menu_detail_bill', function (BreadcrumbTrail $trail, $resource) {
    $trail->parent('menu_bill');
    $trail->push('Detail Tagihan Unit', route('menu_detail_bill', ['id' => $resource->id]));
});

// Home > menu_developer_bank
Breadcrumbs::for('menu_developer_bank', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Developer Bank', route('menu_developer_bank'));
});
// menu_developer_bank > create_developer_bank
Breadcrumbs::for('create_developer_bank', function (BreadcrumbTrail $trail) {
    $trail->parent('menu_developer_bank');
    $trail->push('Create Developer Bank', route('create_developer_bank'));
});
// menu_developer_bank > edit_developer_bank
Breadcrumbs::for('edit_developer_bank', function (BreadcrumbTrail $trail, $resource) {
    $trail->parent('menu_developer_bank');
    $trail->push('Edit Developer Bank', route('edit_developer_bank', ['id' => $resource->id]));
});

// Home > menu_payment_master
Breadcrumbs::for('menu_payment_master', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Setting Master Payment', route('menu_payment_master'));
});
// Home > menu_payment
Breadcrumbs::for('menu_payment', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Payment User', route('menu_payment'));
});
// menu_payment > detail_payment
Breadcrumbs::for('detail_payment', function (BreadcrumbTrail $trail, $resource) {
    $trail->parent('menu_payment');
    $trail->push('Payment User', route('detail_payment', ['id' => $resource->id]));
});
