<?php

namespace App\Utils;

class MenuBuilder
{
    const sidebarMenu = [
        [
            'group' => null,
            'menu' => [
                [
                    'label' => 'Tagihan',
                    'icon' => 'fas fa-receipt',
                    'active' => ['bill.index', 'bill.detail', 'bill.create', 'bill.edit'],
                    'route' => 'bill.index',
                    'can' => ['bill>read'],
                    'submenu' => null
                ],
                [
                    'label' => 'Pembayaran Tagihan',
                    'icon' => 'fas fa-money-check',
                    'active' => ['payment.*'],
                    'route' => 'payment.index',
                    'can' => ['payment>read'],
                    'submenu' => null
                ],
                [
                    'label' => 'Post Artikel',
                    'icon' => 'fas fa-newspaper',
                    'active' => ['article.*'],
                    'route' => 'article.index',
                    'can' => ['article>read'],
                    'submenu' => null
                ],
                [
                    'label' => 'Post Promosi',
                    'icon' => 'fas fa-gifts',
                    'active' => ['promotion.*'],
                    'route' => 'promotion.index',
                    'can' => ['promotion>read'],
                    'submenu' => null
                ],
                [
                    'label' => 'Post Banner',
                    'icon' => 'fas fa-chalkboard',
                    'active' => ['banner.*'],
                    'route' => 'banner.index',
                    'can' => ['banner>read'],
                    'submenu' => null
                ],
                [
                    'label' => 'Complain User',
                    'icon' => 'fas fa-flag',
                    'active' => ['complain.*'],
                    'route' => 'complain.index',
                    'can' => ['complain>read'],
                    'submenu' => null
                ],
            ]
        ],
        [
            'group' => 'Manage Project',
            'menu' => [
                [
                    'label' => 'Project',
                    'icon' => 'fas fa-city',
                    'active' => ['project.*'],
                    'route' => 'project.index',
                    'can' => ['project>read'],
                    'submenu' => null
                ],
                [
                    'label' => 'Project Area',
                    'icon' => 'fas fa-archway',
                    'active' => ['area.*'],
                    'route' => 'area.index',
                    'can' => ['area>read'],
                    'submenu' => null
                ],
                [
                    'label' => 'Project Bloc',
                    'icon' => 'fas fa-road',
                    'active' => ['bloc.*'],
                    'route' => 'bloc.index',
                    'can' => ['bloc>read'],
                    'submenu' => null
                ],
                [
                    'label' => 'Project Unit',
                    'icon' => 'fas fa-house-user',
                    'active' => ['unit.index', 'unit.detail'],
                    'route' => 'unit.index',
                    'can' => ['unit>read'],
                    'submenu' => null
                ],
                [
                    'label' => 'Request Klaim Unit',
                    'icon' => 'bi bi-house-down-fill',
                    'active' => ['unit.request.index'],
                    'route' => 'unit.request.index',
                    'can' => ['unit>request>read'],
                    'submenu' => null
                ],
                [
                    'label' => 'History Klaim Unit',
                    'icon' => 'bi bi-house-exclamation-fill',
                    'active' => ['unit.request.history.*'],
                    'route' => 'unit.request.history.index',
                    'can' => ['unit>request>history>read'],
                    'submenu' => null
                ],
                [
                    'label' => 'Fasilitas Project',
                    'icon' => 'fas fa-cogs',
                    'active' => ['facility.*'],
                    'route' => 'facility.index',
                    'can' => ['facility>read'],
                    'submenu' => null
                ],
                [
                    'label' => 'Access Card',
                    'icon' => 'bi bi-credit-card-2-front-fill',
                    'active' => ['access-card.*'],
                    'route' => 'access-card.index',
                    'can' => ['access-card>read'],
                    'submenu' => null
                ],
            ]
        ],
        [
            'group' => 'Master',
            'menu' => [
                [
                    'label' => 'Developer',
                    'icon' => 'fas fa-snowplow',
                    'active' => ['developer.index', 'developer.permission.*', 'developer.feature.*'],
                    'route' => 'developer.index',
                    'can' => ['developer>read'],
                    'submenu' => null
                ],
                [
                    'label' => 'Developer Bank',
                    'icon' => 'fas fa-money-check-alt',
                    'active' => ['developer.bank.*'],
                    'route' => 'developer.bank.index',
                    'can' => ['developer>bank>read'],
                    'submenu' => null
                ],
                [
                    'label' => 'Ownership Unit',
                    'icon' => 'bi bi-house-lock-fill',
                    'active' => ['unit.ownership.*'],
                    'route' => 'unit.ownership.index',
                    'can' => ['unit>ownership>read'],
                    'submenu' => null
                ],
                [
                    'label' => 'Bantuan',
                    'icon' => 'fas fa-info-circle',
                    'active' => ['support.*'],
                    'route' => 'support.index',
                    'can' => ['support>read'],
                    'submenu' => null
                ],
                [
                    'label' => 'Nomor Darurat',
                    'icon' => 'fas fa-phone-square',
                    'active' => ['emergency.*'],
                    'route' => 'emergency.index',
                    'can' => ['emergency>read'],
                    'submenu' => null
                ],
                [
                    'label' => 'Tipe Tagihan',
                    'icon' => 'fas fa-tools',
                    'active' => ['bill.type.*'],
                    'route' => 'bill.type.index',
                    'can' => ['bill>type>read'],
                    'submenu' => null
                ],
                [
                    'label' => 'Term Condition',
                    'icon' => 'fas fa-book',
                    'active' => ['term-condition.*'],
                    'route' => 'term-condition.index',
                    'can' => ['term-condition>read'],
                    'submenu' => null
                ],
                [
                    'label' => 'Setting Faq',
                    'icon' => 'fas fa-question-circle',
                    'active' => ['faq.*'],
                    'route' => 'faq.index',
                    'can' => ['faq>read'],
                    'submenu' => null
                ],
                [
                    'label' => 'Setting Feature',
                    'icon' => 'fab fa-elementor',
                    'active' => ['feature.*'],
                    'route' => 'feature.index',
                    'can' => ['feature>read'],
                    'submenu' => null
                ],
                // [
                //     'label' => 'Setting Subscription',
                //     'icon' => 'fab fa-hubspot',
                //     'active' => ['subscription.*'],
                //     'route' => 'subscription.index',
                //     'can' => ['subscription>read'],
                //     'submenu' => null
                // ],
                [
                    'label' => 'Access User',
                    'icon' => 'fas fa-user-cog ',
                    'active' => ['user.*', 'role.*', 'permission.*'],
                    'route' => null,
                    'can' => ['user>read', 'role>read', 'permission>read'],
                    'submenu' => [
                        [
                            'label' => 'Setting User',
                            'active' => ['user.*'],
                            'route' => 'user.index',
                            'can' => ['user>read']
                        ],
                        [
                            'label' => 'Master Role',
                            'active' => ['role.*'],
                            'route' => 'role.index',
                            'can' => ['role>read']
                        ],
                        [
                            'label' => 'Master Permission',
                            'active' => ['permission.*'],
                            'route' => 'permission.index',
                            'can' => ['permissionr>read']
                        ],
                    ]
                ],
                [
                    'label' => 'Location',
                    'icon' => 'fas fa-globe-asia',
                    'active' => ['location.province.*', 'location.city.*'],
                    'route' => null,
                    'can' => ['location>province>read', 'location>city>read'],
                    'submenu' => [
                        [
                            'label' => 'Province',
                            'active' => ['location.province.*'],
                            'route' => 'location.province.index',
                            'can' => ['location>province>read']
                        ],
                        [
                            'label' => 'City',
                            'active' => ['location.city.*'],
                            'route' => 'location.city.index',
                            'can' => ['location>city>read']
                        ],
                    ]
                ],
            ]
        ]
    ];
    public function listAllMenu()
    {
        return self::sidebarMenu;
    }
}
