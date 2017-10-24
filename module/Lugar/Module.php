<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Lugar;

use Lugar\Model\Lugar;
use Lugar\Model\LugarTable;
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
                }
            ),
        );
    }



}
