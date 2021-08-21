<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/6.-Basic-Configuration
    |
    */

    'title' => 'DestroRadius',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/6.-Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/6.-Basic-Configuration
    |
    */

    'logo' => '<b>Destro</b>Radius',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'AdminLTE',

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/6.-Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/7.-Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/7.-Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-light',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/7.-Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => 'bg-primary text-white',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/7.-Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => true,
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => true,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/7.-Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/6.-Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/9.-Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/8.-Menu-Configuration
    |
    */

    'menu' => [
        [
            'text'        => 'Dashboard',
            'url'         => '#',
            'icon'        => 'fa fa-fw fa-bars',
            // 'label'       => 4,
            // 'label_color' => 'success',
        ],
        ['header' => 'CRM'],
        
        [
            'text' => 'Managers',
            'icon' => 'fas fa-fw fa-user',
            'submenu'=>[
                [
                    'text' => 'New Manager',
                    'url'=> '/managers/new',
                    'icon'=>'fa fa-code',
                ],
                [
                    'text'=> 'Assign Permission',
                    'url'=>'#',
                    'icon'=>'fas fa-plus',
                    'icon_color'=>'primary',
                ],
                [
                    'text'=>'View Managers',
                    'url'=>'#',
                    'icon'=>'fas fa-users',
                    'icon_color'=>'primary',
                ],
            ]
        ],

        [
            'text' => 'Users',
            'icon' => 'fas fa-fw fa-users',
            'submenu'=>[
                [
                    'text'=>'New User',
                    'url'=>'/users/new',
                    'icon'=>'fas fa-plus',
                    'icon_color'=>'success',
                ],
                [
                    'text'=>'View Users',
                    'icon'=>'fas fa-users',
                    'submenu'=>[
                        [
                            'text'=>'Online',
                            'url'=>'/users/online',
                            'icon'=>'fas fa-circle',
                            'icon_color'=>'success',
                        ],
                        [
                            'text'=>'Offline',
                            'url'=>'/users/offline',
                            'icon'=>'fas fa-circle',
                            'icon_color'=>'red',
                        ],
                        [
                            'text'=>'Paid',
                            'url'=>'/users/paid',
                            'icon'=>'fas fa-circle',
                            'icon_color'=>'success',
                        ],
                        [
                            'text'=>'Unpaid',
                            'url'=>'/users/unpaid',
                            'icon'=>'fas fa-circle',
                            'icon_color'=>'red'
                        ],

                    ]
                ],
                [
                    'text'=>'Suspended Users',
                    'url'=>'/users/suspended',
                    'icon'=>'fas fa-minus',
                    'icon_color'=>'red',
                ],
               
                [
                    'text'=>'Change User Packages',
                    'url'=>'/users/changepackage',
                    'icon'=>'fas fa-circle',
                    'icon_color'=>'primary',
                ]
            ]
        ],
        [
            'text'=>'Nas',
            'icon'=>'fas fa-globe',
            'submenu'=>[
                [
                    'text'=>'New Nas',
                    'url'=>'/nas/new',
                    'icon'=>'fas fa-plus',
                    'icon_color'=>'success',
                ],
                [
                    'text'=>'View Nas',
                    'url'=>'/nas/view',
                    'icon'=>'fas fa-bars',
                ],
            ],
        ],
        [
            'text'=>'Network',
            'icon'=>'fas fa-wifi',
            'submenu'=>[
                [
                    'text'=>'POP',
                    'icon'=>'fas fa-circle',
                    'submenu'=>[
                        [
                            'text'=>'Add POP',
                            'url'=>'#',
                            'icon'=>'fas fa-plus',
                        ],
                        [
                            'text'=>'POP List',
                            'url'=>'#',
                            'icon'=>'fas fa-bars',
                        ],
                        [
                            'text'=>'Assign Manager',
                            'url'=>'#',
                            'icon'=>'fas fa-bars',
                        ],
                        [
                            'text'=>'Assign Packages',
                            'url'=>'#',
                            'icon'=>'fas fa-bars',
                        ],
                        [
                            'text'=>'Assign Nas',
                            'url'=>'#',
                            'icon'=>'fas fa-bars',
                        ],
                    ]
                ],
                [
                    'text'=>'ZONE',
                    'icon'=>'fas fa-map',
                    'submenu'=>[
                        [
                            'text'=>'New Zone/Zone Manager',
                            'url'=>'/zones/new',
                            'icon'=>'fas fa-plus',
                        ],
                        [
                            'text'=>'Zone List',
                            'url'=>'/zones/all',
                            'icon'=>'fas fa-bars',
                        ],
                        [
                            'text'=>'Zone Transfer History',
                            'url'=>'#',
                            'icon'=>'fas fa-file',
                        ],
                    ],
                ],
                [
                    'text'=>'Network Diagram',
                    'icon'=>'fas fa-signal',
                    'submenu'=>[
                        [
                            'text'=>'Add Server',
                            'url'=>'#',
                            'icon'=>'fas fa-plus',
                        ],
                        [
                            'text'=>'Monitor Server',
                            'url'=>'#',
                            'icon'=>'fas fa-monitor',
                        ],
                    ],
                ],
            ],
        ],
        [
            'text'=>'Packages',
            'icon'=>'fas fa-book',
            'submenu'=>[
                [
                    'text'=>'New Package',
                    'url'=>'/packages/new',
                ],
                [
                    'text'=>'View Packages',
                    'url'=>'/packages/all',
                ],
                [
                    'text'=>'Package Pricing',
                    'url'=>'/packages/prices',
                ],
            ],
        ],
        ['header'=>'STORE/INVENTORY'],
        [
            'text'=>'Inventory',
            'icon'=>'fas fa-store',
            'submenu'=>[
                [
            'text'=>'new item',
            'url'=>'/inventory/items/new',
            'icon'=>'fas fa-plus',
            'icon_color'=>'green',
        ],
        [
            'text'=>'view items',
            'icon'=>'fas fa-store',
            'icon_color'=>'yellow',
            'url'=>'/inventory/items',
        ],
        [
            'text'=>'new product',
            'url'=>'/inventory/products/new',
            'icon'=>'fas fa-plus',
            'icon_color'=>'green',
        ],
        [
            'text'=>'view products',
            'url'=>'/inventory/products',
            'icon'=>'fas fa-file',
            'icon_color'=>'yellow',
        ],
        [
            'text'=>'supply',
            'icon'=>'fas fa-bars',
            'icon_color'=>'orange',
            'submenu'=>[
                [
                    'text'=>'suppliers',
                    'url'=>'/inventory/suppliers',
                    'icon'=>'fas fa-car',
                ],
                [
                    'text'=>'vendors',
                    'url'=>'/inventory/vendors',
                    'icon'=>'fas fa-fish',
                ],
                [
                    'text'=>'supplier invoices',
                    'url'=>'#',
                    'icon'=>'fas fa-book',
                ],
            ],
        ],
            ],
        ],
        
        [
            'text'=>'Tickets',
            'icon'=>'fas fa-ticket-alt',
            'submenu'=>[
                [
                    'text'=>'open tickets',
                    'url'=>'/tickets/open',
                    'icon'=>'fas fa-envelope-open',
                    'icon_color'=>'green',
                ],
                [
                    'text'=>'closed tickets',
                    'url'=>'#',
                    'icon'=>'fas fa-times',
                    'icon_color'=>'red',
                ],
                [
                    'text'=>'new ticket',
                    'url'=>'/tickets/new',
                    'icon'=>'fas fa-plus',
                    'icon_color'=>'green',
                ],
            ],
        ],
        ['header' => 'MAINTENANCE'],
        [
            'text'       => 'Clean Stale Connections',
            'icon_color' => 'red',
            'url'        => '/stale/connections',
        ],
        [
            'text'       => 'Test User Connectivity',
            'icon_color' => 'yellow',
            'url'        => '/services/testconnectivity',
        ],
        [
            'text'       => 'Service Statuses',
            'icon_color' => 'cyan',
            'url'        => '/services/status',
        ],
        
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/8.-Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/9.-Other-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/sweetalert2/sweetalert2.min.js',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/9.-Other-Configuration
    */

    'livewire' => false,
];
