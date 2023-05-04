<?php

namespace App\Main;

class SideMenu
{
    /**
     * List of side menu items.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function menu()
    {
        return [
            'dashboard' => [
                'icon' => 'home',
                'route_name' => 'dashboard',
                'params' => [
                    'layout' => 'side-menu',
                ],
                    'title' => 'Dashboard'
            ],
            'product' => [
                'icon' => 'file-text',
                'route_name' => 'products',
                'params' => [
                    'layout' => 'side-menu'
                ],
                'title' => 'Products'
            ],

            'devider',
            'data-master' => [
                'icon' => 'file-text',
                'title' => 'Master Data',
                'sub_menu' => [
                    'users-layout-1' => [
                        'icon' => '',
                        'route_name' => 'users',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Users'
                    ],
                    'users-layout-2' => [
                        'icon' => '',
                        'route_name' => 'roles',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Roles'
                    ],
                ]
            ],
        ];
    }
}
