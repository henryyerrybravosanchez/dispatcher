<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Lugar;

use Lugar\Model\Contiene;
use Lugar\Model\ContieneTable;
use Lugar\Model\Lugar;
use Lugar\Model\LugarTable;
use Lugar\Model\Material;
use Lugar\Model\MaterialTable;
use Lugar\Model\Punto;
use Lugar\Model\PuntoTable;
use Lugar\Model\Ruta;
use Lugar\Model\RutaTable;
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
                'Lugar\Model\LugarTable' => function ($sm) {
                    $tableGateway = $sm->get('LugarTableGateway');
                    $table = new LugarTable($tableGateway);
                    return $table;
                },
                'LugarTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Lugar());
                    return new TableGateway('lugar', $dbAdapter, null, $resultSetPrototype);
                },
                'Lugar\Model\RutaTable' => function ($sm) {
                    $tableGateway = $sm->get('RutaTableGateway');
                    $table = new RutaTable($tableGateway);
                    return $table;
                },
                'RutaTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Ruta());
                    return new TableGateway('ruta', $dbAdapter, null, $resultSetPrototype);
                },
                'Lugar\Model\MaterialTable' => function ($sm) {
                    $tableGateway = $sm->get('MaterialTableGateway');
                    $table = new MaterialTable($tableGateway);
                    return $table;
                },
                'MaterialTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Material());
                    return new TableGateway('material', $dbAdapter, null, $resultSetPrototype);
                },
                'Lugar\Model\ContieneTable' => function ($sm) {
                    $tableGateway = $sm->get('ContieneTableGateway');
                    $table = new ContieneTable($tableGateway);
                    return $table;
                },
                'ContieneTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Contiene());
                    return new TableGateway('contiene', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }



}
