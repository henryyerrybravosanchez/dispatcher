<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Reporte;

use Unidad\Model\Opera;
use Unidad\Model\OperaTable;
use Unidad\Model\Pala;
use Unidad\Model\PalaTable;
use Unidad\Model\Unidad;
use Unidad\Model\UnidadTable;
use Unidad\Model\Punto;
use Unidad\Model\PuntoTable;
use Unidad\Model\Volquete;
use Unidad\Model\VolqueteTable;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    // Add this method:
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Unidad\Model\UnidadTable' => function ($sm) {
                    $tableGateway = $sm->get('UnidadTableGateway');
                    $table = new UnidadTable($tableGateway);
                    return $table;
                },
                'UnidadTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Unidad());
                    return new TableGateway('unidad', $dbAdapter, null, $resultSetPrototype);
                },
                'Unidad\Model\PuntoTable' => function ($sm) {
                    $tableGateway = $sm->get('PuntoTableGateway');
                    $table = new PuntoTable($tableGateway);
                    return $table;
                },
                'PuntoTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Punto());
                    return new TableGateway('punto', $dbAdapter, null, $resultSetPrototype);
                },
                'Unidad\Model\PalaTable' => function ($sm) {
                    $tableGateway = $sm->get('PalaTableGateway');
                    $table = new PalaTable($tableGateway);
                    return $table;
                },
                'PalaTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Pala());
                    return new TableGateway('u_cargador', $dbAdapter, null, $resultSetPrototype);
                },
                'Unidad\Model\VolqueteTable' => function ($sm) {
                    $tableGateway = $sm->get('VolqueteTableGateway');
                    $table = new VolqueteTable($tableGateway);
                    return $table;
                },
                'VolqueteTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Volquete());
                    return new TableGateway('u_volquete', $dbAdapter, null, $resultSetPrototype);
                },
                'Unidad\Model\OperaTable' => function ($sm) {
                    $tableGateway = $sm->get('OperaTableGateway');
                    $table = new OperaTable($tableGateway);
                    return $table;
                },
                'OperaTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Opera());
                    return new TableGateway('opera', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }



}
