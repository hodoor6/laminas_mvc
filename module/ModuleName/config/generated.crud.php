<?php

namespace ModuleName;

use Laminas\Router\Http\Segment;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use ModuleName\Model\Rowset;
use ModuleName\Model;
use ModuleName\Controller;

return [
    'router' => [
        'routes' => [
            'simpleName' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/simplename[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\SimpleNameController::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'paginator' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/[page/:page]',
                            'defaults' => [
                                'page' => 1
                            ]
                        ]
                    ],
                ]
            ]
        ]
    ],
    
    'controllers' => [
        'factories' => [
            Controller\SimpleNameController::class => function($sm) {
                $postService = $sm->get(Model\SimpleNameTable::class);

                return new Controller\SimpleNameController($postService);
            },
        ]
    ],
                    
    'service_manager' => [
        'factories' => [
            'SimpleNameTableGateway' => function ($sm) {
                $dbAdapter = $sm->get('Laminas\Db\Adapter\Adapter');
                $config = $sm->get('Config');
                $baseUrl = $config['view_manager']['base_url'];
                $resultSetPrototype = new ResultSet();
                $identity = new Rowset\SimpleName($baseUrl);
                $resultSetPrototype->setArrayObjectPrototype($identity);
                return new TableGateway('simpleName', $dbAdapter, null, $resultSetPrototype);
            },
            Model\SimpleNameTable::class => function($sm) {
                $tableGateway = $sm->get('SimpleNameTableGateway');
                $table = new Model\SimpleNameTable($tableGateway);
                return $table;
            },
        ]
    ],
                    
    'view_manager' => [
        'template_map' => [
            'module-name/simple-name/index' => __DIR__ . '/../view/SimpleName/index.phtml',
            'module-name/simple-name/edit' => __DIR__ . '/../view/SimpleName/edit.phtml',
            'module-name/simple-name/add' => __DIR__ . '/../view/SimpleName/add.phtml',
            'module-name/simple-name/pagination' => __DIR__ . '/../view/SimpleName/pagination.phtml',
        ],
    ]
];
