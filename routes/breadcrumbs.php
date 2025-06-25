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
// Home > menu_bill
Breadcrumbs::for('menu_bill', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Tagihan Unit', route('bill.index'));
});
// menu_bill > create_bill
Breadcrumbs::for('create_bill', function (BreadcrumbTrail $trail) {
    $trail->parent('menu_bill');
    $trail->push('Tagihan Unit', route('bill.create'));
});
// menu_bill > edit_bill
Breadcrumbs::for('edit_bill', function (BreadcrumbTrail $trail, $resource) {
    $trail->parent('menu_bill');
    $trail->push('Edit Tagihan Unit', route('bill.edit', ['id' => $resource->id]));
});
// menu_bill > menu_detail_bill
Breadcrumbs::for('menu_detail_bill', function (BreadcrumbTrail $trail, $resource) {
    $trail->parent('menu_bill');
    $trail->push('Detail Tagihan Unit', route('bill.detail', ['id' => $resource->id]));
});

// Home > menu_payment
Breadcrumbs::for('menu_payment', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Payment User', route('payment.index'));
});
// menu_payment > detail_payment
Breadcrumbs::for('detail_payment', function (BreadcrumbTrail $trail, $resource) {
    $trail->parent('menu_payment');
    $trail->push('Payment User', route('payment.detail', ['id' => $resource->id]));
});

// Home > menu_article
Breadcrumbs::for('menu_article', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Article', route('article.index'));
});
// menu_article > create_article
Breadcrumbs::for('create_article', function (BreadcrumbTrail $trail) {
    $trail->parent('menu_article');
    $trail->push('Create Article', route('article.create'));
});
// menu_article > edit_article
Breadcrumbs::for('edit_article', function (BreadcrumbTrail $trail, $resource) {
    $trail->parent('menu_article');
    $trail->push('Edit Article', route('article.edit', ['id' => $resource->id]));
});
// Home > menu_promotion
Breadcrumbs::for('menu_promotion', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Promotion', route('promotion.index'));
});
// menu_promotion > create_promotion
Breadcrumbs::for('create_promotion', function (BreadcrumbTrail $trail) {
    $trail->parent('menu_promotion');
    $trail->push('Create Promotion', route('promotion.create'));
});
// menu_promotion > edit_promotion
Breadcrumbs::for('edit_promotion', function (BreadcrumbTrail $trail, $resource) {
    $trail->parent('menu_promotion');
    $trail->push('Edit Promotion', route('promotion.edit', ['id' => $resource->id]));
});
// Home > menu_banner
Breadcrumbs::for('menu_banner', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Banner', route('banner.index'));
});
// menu_banner > create_banner
Breadcrumbs::for('create_banner', function (BreadcrumbTrail $trail) {
    $trail->parent('menu_banner');
    $trail->push('Create Banner', route('banner.create'));
});
// menu_banner > edit_banner
Breadcrumbs::for('edit_banner', function (BreadcrumbTrail $trail, $resource) {
    $trail->parent('menu_banner');
    $trail->push('Edit banner', route('banner.edit', ['id' => $resource->id]));
});

// Home > menu_complain
Breadcrumbs::for('menu_complain', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Complain User', route('complain.index'));
});
// menu_complain > menu_detail_complain
Breadcrumbs::for('menu_detail_complain', function (BreadcrumbTrail $trail, $resource) {
    $trail->parent('menu_complain');
    $trail->push('Detail Complain User', route('complain.detail', ['id' => $resource->id]));
});

// Home > menu_project
Breadcrumbs::for('menu_project', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Projects', route('project.index'));
});
// Home > menu_area
Breadcrumbs::for('menu_area', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Project Area', route('area.index'));
});
// Home > menu_bloc
Breadcrumbs::for('menu_bloc', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Project Bloc', route('bloc.index'));
});
// Home > menu_unit
Breadcrumbs::for('menu_unit', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Project Unit', route('unit.index'));
});
// menu_unit > menu_detail_unit
Breadcrumbs::for('menu_detail_unit', function (BreadcrumbTrail $trail, $resource) {
    $trail->parent('menu_unit');
    $trail->push('Detail Unit', route('unit.detail', ['id' => $resource->id]));
});
// Home > menu_request_claim_unit
Breadcrumbs::for('menu_request_claim_unit', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Request Claim Unit', route('unit.request.index'));
});

// Home > menu_history_claim_unit
Breadcrumbs::for('menu_history_claim_unit', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('History Claim Unit', route('unit.request.history.index'));
});
// Home > menu_facility
Breadcrumbs::for('menu_facility', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Facility', route('facility.index'));
});
// menu_facility > create_facility
Breadcrumbs::for('create_facility', function (BreadcrumbTrail $trail) {
    $trail->parent('menu_facility');
    $trail->push('Create Facility', route('facility.create'));
});
// menu_facility > edit_facility
Breadcrumbs::for('edit_facility', function (BreadcrumbTrail $trail, $resource) {
    $trail->parent('menu_facility');
    $trail->push('Edit Facility', route('facility.edit', ['id' => $resource->id]));
});

// Home > master_developer
Breadcrumbs::for('master_developer', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Setting Master Developer', route('developer.index'));
});

// Home > menu_developer_bank
Breadcrumbs::for('menu_developer_bank', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Developer Bank', route('developer.bank.index'));
});
// menu_developer_bank > create_developer_bank
Breadcrumbs::for('create_developer_bank', function (BreadcrumbTrail $trail) {
    $trail->parent('menu_developer_bank');
    $trail->push('Create Developer Bank', route('developer.bank.create'));
});
// menu_developer_bank > edit_developer_bank
Breadcrumbs::for('edit_developer_bank', function (BreadcrumbTrail $trail, $resource) {
    $trail->parent('menu_developer_bank');
    $trail->push('Edit Developer Bank', route('developer.bank.edit', ['id' => $resource->id]));
});
// Home > master_ownership
Breadcrumbs::for('master_ownership', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Setting Master Ownership Unit', route('unit.ownership.index'));
});

// Home > menu_support
Breadcrumbs::for('menu_support', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Bantuan', route('support.index'));
});

// Home > menu_support
Breadcrumbs::for('menu_emergency', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Nomor Darurat', route('emergency.index'));
});

// Home > menu_bill_type
Breadcrumbs::for('menu_bill_type', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Setting Type Tagihan', route('bill.type.index'));
});

// Home > menu_term_condition
Breadcrumbs::for('menu_term_condition', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Term & Condition', route('term-condition.index'));
});
// menu_term_condition > create_term_condition
Breadcrumbs::for('create_term_condition', function (BreadcrumbTrail $trail) {
    $trail->parent('menu_term_condition');
    $trail->push('Create Term & Condition', route('term-condition.create'));
});
// menu_term_condition > edit_facility
Breadcrumbs::for('edit_term_condition', function (BreadcrumbTrail $trail, $resource) {
    $trail->parent('menu_term_condition');
    $trail->push('Edit Term & Condition', route('term-condition.edit', ['id' => $resource->id]));
});

// Home > menu_faq
Breadcrumbs::for('menu_faq', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('FAQ', route('faq.index'));
});

// Home > menu_feature
Breadcrumbs::for('menu_feature', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Master Feature', route('feature.index'));
});
// Home > master_role
Breadcrumbs::for('master_role', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Setting Role Access', route('role.index'));
});

// Home > master_permission
Breadcrumbs::for('master_permission', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Setting Permission Access', route('permission.index'));
});






// Home > location_province
Breadcrumbs::for('location_province', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Location Province', route('location.province.index'));
});
// Home > location_city
Breadcrumbs::for('location_city', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Location City', route('location.city.index'));
});

// Home > menu_access_card
Breadcrumbs::for('menu_access_card', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Access Card', route('menu_access_card'));
});

// Home > menu_payment_master
Breadcrumbs::for('menu_payment_master', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Setting Master Payment', route('menu_payment_master'));
});

// Home > menu_renovation_permit
Breadcrumbs::for('menu_renovation_permit', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Izin Renovasi', route('menu_renovation_permit'));
});

// menu_renovation_permit > menu_detail_renovation_permit
Breadcrumbs::for('menu_detail_renovation_permit', function (BreadcrumbTrail $trail, $resource) {
    $trail->parent('menu_renovation_permit');
    $trail->push('Complain User', route('menu_detail_renovation_permit', ['id' => $resource->id]));
});


// tutup dulu ganti model bisnis
// master_developer > developer_subscription
// Breadcrumbs::for('developer_subscription', function (BreadcrumbTrail $trail, $resource) {
//     $trail->parent('master_developer');
//     $trail->push('Subscription Developer', route('developer_subscription', ['id', $resource->id]));
// });
// Home > menu_subscription
// Breadcrumbs::for('menu_subscription', function (BreadcrumbTrail $trail) {
//     $trail->parent('home');
//     $trail->push('Master Subscription', route('menu_subscription'));
// });
// menu_subscription > detail_subscription
// Breadcrumbs::for('detail_subscription', function (BreadcrumbTrail $trail, $resource) {
//     $trail->parent('menu_subscription');
//     $trail->push('Detail Subscription', route('detail_subscription', ['id' => $resource->id]));
// });
