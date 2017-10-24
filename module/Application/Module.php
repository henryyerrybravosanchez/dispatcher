<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Autentificacion\Model\Role;
use Autentificacion\Utility\Acl;
use Zend\View\HelperPluginManager;

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
	public function getServiceConfig()
	{
		return array(
			'factories' => array(

				'navigation' => function($sm) {
					$navigation = new \Zend\Navigation\Service\DefaultNavigationFactory;
					$navigation = $navigation->createService($sm);

					return $navigation;
				}
			),
		);
	}
	public function getViewHelperConfig()
	{
		return array(
			'factories' => array(
				'navigation' => function(HelperPluginManager $pm) {
					$sm = $pm->getServiceLocator();
					$acl = $sm->get('Acl');
					$auth = $sm->get('AuthService');
					$navigation = $pm->get('Zend\View\Helper\Navigation');

					try{
						//$container = $navigation -> getContainer();
						if ($auth->hasIdentity()) {
							//	$user = $auth->getIdentity();
							$navigation->setAcl($acl)-> setRole(\Autentificacion\Utility\Acl::UNIQUE_ROLE);
						}
						else {
							$navigation->setAcl($acl)-> setRole(\Autentificacion\Utility\Acl::DEFAULT_ROLE);
						}
					} catch (\Exception $e) {
						$navigation->setAcl($acl)-> setRole(\Autentificacion\Utility\Acl::DEFAULT_ROLE);
						throw new \Exception($e->getMessage());
					}
					return $navigation;
				}
			)
		);
	}


}
