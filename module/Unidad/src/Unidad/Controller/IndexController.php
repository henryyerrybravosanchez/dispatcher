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

class IndexController extends AbstractActionController
{

    public $dbAdapter;
    public $puntotable;
    public $unidadtable;
    public $rutatable;
    public $volquetetable;
    public $lugartable;
    public $operatable;
    public $palatable;

    public function indexAction()
    {
        if ($this->request->isXmlHttpRequest()) {
            $o = (int)$this->request->getPost('o');
            switch ($o) {

                case 1:
                    $rutas=$this->getRutaTable()->fetchAll();
                    $lugares=$this->getLugarTable()->fetchAll();
                    $rutasArray=array();
                    foreach ($rutas as $r)
                    {
                        $rutasArray[$r->idruta]=$this->getRutaTable()->fetchAllPoints($r->idruta);
                    }
                    if($rutasArray)
                    {
                        return new JsonModel(array('data'=>$rutasArray,'lugares'=>$lugares));
                    }
                    else
                        return new JsonModel(array('data'=>-1));
                    break;
                case 2:
                    $volquetes=$this->getUnidadTable()->getVolquetesUbicacion();
                    $palas=$this->getUnidadTable()->getPalasUbicacion();
                    if($volquetes||$palas)
                    {
                        return new JsonModel(array('data'=>$volquetes,'datapalas'=>$palas));

                    }
                    else
                        return new JsonModel(array('data'=>-1));
                    break;
            }

        }
        return new ViewModel();
    }

    public function unidadAction()
    {
        if ($this->request->isXmlHttpRequest()) {
            $o = (int)$this->request->getPost('o');
            switch ($o) {
                case 1:
                    $placa= $this->request->getPost('p');
                    $tipo= (int)$this->request->getPost('t');


                    $unidad= new Unidad();
                    $unidad->placa=$placa;
                    $unidad->estado="1";
                    $idunidad=$this->getUnidadTable()->saveUnidad($unidad);
                    ///return new JsonModel(array($idunidad));
                    if($idunidad){
                        switch ($tipo)
                        {
                            case 1:
                                $pala= new Pala();
                                $pala->idcargador=$idunidad;
                                $pala->estado="3";
                                $id=$this->getPalaTable()->savePala($pala);
                                break;
                            case 2:
                                $volqeute= new Volquete();
                                $volqeute->idvolquete=$idunidad;
                                $volqeute->estado="3";
                                $id=$this->getVolqueteTable()->saveVolquete($volqeute);
                                break;
                            default:
                                break;
                        }
                    }

                    if($idunidad)
                        return new JsonModel(array('o'=>1, 'data'=>$idunidad));
                    else
                        return new JsonModel(array('o'=>1, 'data'=>-1));

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
                'Volquete\Model\VolqueteTable'
            );
        }
        return $this->volquetetable;
    }
}
