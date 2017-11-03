<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Lugar\Controller;

use Bus\Form\BusForm;
use Lugar\Model\Lugar;
use Unidad\Model\Punto;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{

    public $dbAdapter;
    public $puntotable;
    public $Lugartable;
    public $volquetetable;
    public $rutatable;
    public $palatable;

    public function indexAction()
    {
        if ($this->request->isXmlHttpRequest()) {
            $o = (int)$this->request->getPost('o');
            switch ($o) {
                case 1:
                    $nombrecompleto= $this->request->getPost('nc');
                    $nombre= $this->request->getPost('n');
                    $latitud= $this->request->getPost('lt');
                    $longitud= $this->request->getPost('lg');
                    $lugar= new Lugar();
                    $lugar->longitud=$longitud;
                    $lugar->latitud=$latitud;
                    $lugar->estado=1;
                    $lugar->nombrecompleto=$nombrecompleto;
                    $lugar->nombre=$nombre;
                    $idlugar=$this->getLugarTable()->saveLugar($lugar);
                    if($idlugar)
                        return new JsonModel(array('o'=>1, 'data'=>$idlugar));
                    else
                        return new JsonModel(array('o'=>1, 'data'=>-1));
                    break;
                case 2:
                    $idruta= $this->request->getPost('idr');
                    $rutas=$this->getRutaTable()->fetchAllPoints($idruta);
                    return new JsonModel(array('o'=>1, 'data'=>$rutas));
                    break;
                case 3:
                    $idruta= $this->request->getPost('idr');
                    $color= $this->request->getPost('c');
                    $ruta=$this->getRutaTable()->getRuta($idruta);
                    $ruta->color=$color;
                    $id=$this->getRutaTable()->saveRuta($ruta);
                    if($id)
                        return new JsonModel(array('o'=>3, 'data'=>$id));
                    else
                        return new JsonModel(array('o'=>3, 'data'=>-1));
                    break;
                case 4:
                    $idruta= $this->request->getPost('idr');
                    $rutas=$this->getRutaTable()->fetchAllPoints($idruta);
                    return new JsonModel(array('o'=>4, 'data'=>$rutas));
                    break;
                case 5:
                    $data= $this->request->getPost('d');
                    $idruta= $this->request->getPost('idr');
                    $flat=false;
                    $this->getPuntoTable()->updateStateRoute($idruta, "2");
                    $orden=1;
                    foreach ($data as $d)
                    {
                        $punto=new Punto();
                        $punto->idruta=$idruta;
                        $punto->orden=$orden;
                        $punto->latitud=$d['lat'];
                        $punto->longitud=$d['lng'];
                        $punto->estado=1;
                        $idpunto=$this->getPuntoTable()->savePunto($punto);
                        $orden++;
                        if($idpunto)
                        {
                            $flat=true;
                        }else{
                            $flat=false;
                        }
                    }
                    if($flat)
                    {
                        return new JsonModel(array('o'=>5, 'data'=>$idruta));
                    }
                    else{
                        return new JsonModel(array('o'=>5, 'data'=>-1));
                    }
                    break;
            }
        }
        $lugares=$this->getLugarTable()->fetchAll();
        $rutas=$this->getRutaTable()->fetchAllWithPlace();
        return new ViewModel(array(
            'lugares'=>$lugares,
            'rutas'=>$rutas
        ));
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
    private function getLugarTable()
    {
        if (!$this->Lugartable) {
            $sm = $this->getServiceLocator();
            $this->Lugartable = $sm->get(
                'Lugar\Model\LugarTable'
            );
        }

        return $this->Lugartable;
    }
    private function getPalaTable()
    {
        if (!$this->palatable) {
            $sm = $this->getServiceLocator();
            $this->palatable = $sm->get(
                'Pala\Model\PalaTable'
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


    private function getPuntoTable()
    {
        if (!$this->puntotable) {
            $sm = $this->getServiceLocator();
            $this->puntotable = $sm->get(
                'Unidad\Model\PuntoTable'
            );
        }

        return $this->puntotable;
    }
}
