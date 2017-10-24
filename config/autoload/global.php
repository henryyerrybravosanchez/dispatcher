<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */
return array(
    'db'              => array(
        'username'       => 'sa',
        'password'       => 'henry120',
        'driver'         => 'Pdo',
        'dsn'            => 'sqlsrv:Server=DESKTOP-V4461LJ\SQLEXPRESS;Database=despachador',
        'driver_options' => array(
            //PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES\'UTF8\''
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ),
    ),
    'navigation' => array(
        'default' => array(
            array(
                'id' => 'page1',
                'label' => 'Seguridad',
                'uri' => '#',
                'icon' => 'fa fa-lock fa-fw',
                'pages' => array(
                    array(
                        'label' => 'Usuarios',
                        'route' => 'administrador',
                        'action' => 'index',
                        'resource' => 'Administrador\Controller\Index',
                        'privilege' => 'index',
                        'icon' => 'fa fa-users fa-fw'
                    ),
                    array(
                        'label' => 'Roles y Políticas',
                        'route' => 'roles',
                        'action' => 'index',
                        'resource' => 'Administrador\Controller\Rol',
                        'privilege' => 'index',
                        'icon' => 'fa fa-key fa-fw'
                    ),
                )
            ),
            array(
                'label' => 'Reserva',
                'route' => 'reserva',
                'action' => 'index',
                'resource' => 'Reserva\Controller\Index',
                'privilege' => 'index',
                'icon' => 'fa  fa-map-marker fa-fw',
            ),
            array(
                'label' => 'Unidades',
                'route' => 'reserva',
                'action' => 'movilidad',
                'resource' => 'Reserva\Controller\Index',
                'privilege' => 'movilidad',
                'icon' => 'fa  fa-taxi  fa-fw',
            ),


        ),
    ),
);
