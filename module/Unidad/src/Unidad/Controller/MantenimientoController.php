<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Unidad\Controller;

use Bus\Form\BusForm;
use Unidad\Model\Pala;
use Unidad\Model\Unidad;
use Unidad\Model\Volquete;
use Zend\Form\Element\DateTime;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class MantenimientoController extends AbstractActionController
{

    public $dbAdapter;
    public $puntotable;
    public $unidadtable;
    public $rutatable;
    public $volquetetable;
    public $mantenimientotable;
    public $lugartable;
    public $operatable;
    public $palatable;
    public function indexAction()
    {
        if ($this->request->isXmlHttpRequest()){
            $o = (int)$this->request->getPost('o');
            switch ($o) {
                case 1:
                    $manactivos=$this->getMantenimientoTable()->getMantenimientoActivos();
                    return new JsonModel(array('o'=>$o, 'data'=>$manactivos));
                    break;
            }
        }
        $volquetes=$this->getUnidadTable()->fetchAllVolquetes();
        $palas=$this->getUnidadTable()->fetchAllPalas();
        return new ViewModel(array(
            'volquetes'=>$volquetes,
            'palas'=>$palas
        ));
    }

    private function getPuntoTable()
    {
        if (!$this->puntotable) {
            $sm = $this->getServiceLocator();
            $this->puntotable = $sm->get(
                'Punto\Model\PuntoTable'
            );
        }
        return $this->puntotable;
    }
    private function getLugarTable()
    {
        if (!$this->lugartable) {
            $sm = $this->getServiceLocator();
            $this->lugartable = $sm->get(
                'Lugar\Model\LugarTable'
            );
        }

        return $this->lugartable;
    }
    private function getOperaTable()
    {
        if (!$this->operatable) {
            $sm = $this->getServiceLocator();
            $this->operatable = $sm->get(
                'Unidad\Model\OperaTable'
            );
        }

        return $this->operatable;
    }
    private function getRutaTable()
    {
        if (!$this->rutatable) {
            $sm = $this->getServiceLocator();
            $this->rutatable = $sm->get(
                'Lugar\Model\RutaTable'
            );
        }

        return $this->rutatable;
    }
    private function getUnidadTable()
    {
        if (!$this->unidadtable) {
            $sm = $this->getServiceLocator();
            $this->unidadtable = $sm->get(
                'Unidad\Model\UnidadTable'
            );
        }

        return $this->unidadtable;
    }
    private function getPalaTable()
    {
        if (!$this->palatable) {
            $sm = $this->getServiceLocator();
            $this->palatable = $sm->get(
                'Unidad\Model\PalaTable'
            );
        }

        return $this->palatable;
    }
    private function getVolqueteTable()
    {
        if (!$this->volquetetable) {
            $sm = $this->getServiceLocator();
            $this->volquetetable = $sm->get(
                'Unidad\Model\VolqueteTable'
            );
        }
        return $this->volquetetable;
    }
    private function getMantenimientoTable()
    {
        if (!$this->mantenimientotable) {
            $sm = $this->getServiceLocator();
            $this->mantenimientotable = $sm->get(
                'Unidad\Model\MantenimientoTable'
            );
        }
        return $this->mantenimientotable;
    }
}

