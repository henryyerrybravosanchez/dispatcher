<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonAlimento for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router'          => array(
        'routes' => array(
            'lugar' => array(
                'type'          => 'segment',
                'options'       => array(
                    'route'       => '/lugar[/:action][/:id][/:param]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[a-zA-Z0-9_-]+',
                        'param'  => '[a-zA-Z0-9_-]+',
                    ),
                    'defaults'    => array(
                        'controller' => 'Lugar\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'       => '/[:controller][/:action][/:id][/:param]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'         => '[a-zA-Z0-9_-]+',
                                'param'      => '[a-zA-Z0-9_-]+',
                            ),
                            'defaults'    => array(),
                        ),
                    ),
                ),
            ),


        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases'            => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers'     => array(
        'invokables' => array(
            'Lugar\Controller\Index'    => 'Lugar\Controller\IndexController',
        ),
    ),
    'view_manager'    => array(
        'display_not_found_reason' => false,
        'display_exceptions'       => false,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map'             => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'error/404'     => __DIR__ . '/../view/error/404.phtml',
            'error/index'   => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack'      => array(
            __DIR__ . '/../view',
        ),
        'strategies'               => array(            // Add
            // this
            'ViewJsonStrategy'
            // line
        )
    ),
    // Placeholder for console routes
    'console'         => array(
        'router' => array(
            'routes' => array(),
        ),
    ),
    'session'         => array(
        'remember_me_seconds' => 2419200,
        'use_cookies'         => true,
        'cookie_httponly'     => true
    ),
);