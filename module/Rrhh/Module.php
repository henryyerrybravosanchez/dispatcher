<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Rrhh;

use Rrhh\Model\Colaborador;
use Rrhh\Model\ColaboradorTable;
use Rrhh\Model\Operador;
use Rrhh\Model\OperadorTable;
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
                'Rrhh\Model\ColaboradorTable' => function ($sm) {
                    $tableGateway = $sm->get('ColaboradorTableGateway');
                    $table = new ColaboradorTable($tableGateway);
                    return $table;
                },
                'ColaboradorTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Colaborador());
                    return new TableGateway('colaborador', $dbAdapter, null, $resultSetPrototype);
                },
                'Rrhh\Model\OperadorTable' => function ($sm) {
                    $tableGateway = $sm->get('OperadorTableGateway');
                    $table = new OperadorTable($tableGateway);
                    return $table;
                },
                'OperadorTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Operador());
                    return new TableGateway('c_operador', $dbAdapter, null, $resultSetPrototype);
                }
            ),
        );
    }



}
