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
use Lugar\Model\Contiene;
use Lugar\Model\Lugar;
use Lugar\Model\Ruta;
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
    public $unidadtable;
    public $contienetable;
    public $desplazamiento;

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
                case 6:
                    $idcamion = (int)$this->request->getPost('c');
                    $desde = $this->request->getPost('d');
                    $hasta = $this->request->getPost('h');
                    $puntos=$this->getDesplazamientoTable()->getUbicacionesUnidad($desde,$hasta, $idcamion);
                    try{
                        return new JsonModel(array('o'=>$o, 'data'=>$puntos));
                    }catch (\Exception $exception){
                        return new JsonModel(array('o'=>$o, 'data'=>-1));
                    }
                    break;
                case 7:
                    $lugares =$this->getLugarTable()->fetchAllLugares();
                    return new JsonModel(array('o'=>$o, 'data'=>$lugares));
                    break;
                case 8:
                    $idinicio = $this->request->getPost('idi');
                    $iddestino = $this->request->getPost('idd');
                    $data = $this->request->getPost('d');
                    if(count($data)>0){
                        $ruta=new Ruta();
                        $ruta->idLugarFinal=$iddestino;
                        $ruta->idLugarInicio=$idinicio;
                        $ruta->estado=1;
                        $idr=$this->getRutaTable()->saveRuta($ruta);
                        $orden=0;
                        foreach ($data as $d){
                            $latitud=$d['lat'];
                            $longitud=$d['lng'];
                            if($latitud!=0&&$longitud!=0){
                                $orden++;
                                $p= new Punto();
                                $p->estado=1;
                                $p->idruta=$idr;
                                $p->latitud=$latitud;
                                $p->longitud=$longitud;
                                $p->orden=$orden;
                                $idp=$this->getPuntoTable()->savePunto($p);
                            }

                        }
                        return new JsonModel(array('o'=>$o, 'data'=>$idr));
                    }
                    else {
                        return new JsonModel(array('o'=>$o, 'data'=>-1));
                    }
                    break;
            }
        }
        $lugares=$this->getLugarTable()->fetchAllLugares();
        $volquete=$this->getUnidadTable()->fetchAllVolquetes();
        $rutas=$this->getRutaTable()->fetchAllWithPlace();
        return new ViewModel(array(
            'lugares'=>$lugares,
            'rutas'=>$rutas,
            'camiones'=>$volquete
        ));
    }
    public function poligonoAction(){
        if ($this->request->isXmlHttpRequest()) {
            $o = (int)$this->request->getPost('o');
            switch ($o) {
                case 1:
                    $dato= $this->request->getPost('d');
                    $color= $this->request->getPost('co');
                    $nombre= $this->request->getPost('np');
                    $lugar=new Lugar();
                    $lugar->nombre=$nombre;
                    $lugar->color=$color;
                    $lugar->estado=1;
                    $lugar->tipo=2;
                    $idlugar=$this->getLugarTable()->saveLugar($lugar);
                    $or=0;
                    foreach ($dato as $d){
                        $or++;
                        $punto=new Punto();
                        $punto->latitud=$d['lat'];
                        $punto->longitud=$d['lng'];
                        $punto->estado=1;
                        $punto->orden=$or;
                        $idp=$this->getPuntoTable()->savePunto($punto);

                        $contiene=new Contiene();
                        $contiene->idlugar=$idlugar;
                        $contiene->idpunto=$idp;
                        $contiene->estado=1;
                        $contiene->version=1;
                        $this->getContieneTable()->saveContiene($contiene);
                    }
                    if($idlugar)
                        return new JsonModel(array('o'=>$o, 'data'=>$idlugar));
                    else
                        return new JsonModel(array('o'=>$o, 'data'=>-1));
                    break;
                case 2:
                    $idlugar=(int)$this->request->getPost('idl');
                    $puntos=$this->getContieneTable()->fetchAllWithPlace($idlugar);
                    return new JsonModel(array('o'=>$o, 'data'=>$puntos));
                    break;
            }
        }
        $lugares=$this->getLugarTable()->fetchAllPoligonos();
        return new ViewModel(
            array(
                'poligonoes'=>$lugares
            )
        );
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
    private function getContieneTable()
    {
        if (!$this->contienetable) {
            $sm = $this->getServiceLocator();
            $this->contienetable = $sm->get(
                'Lugar\Model\ContieneTable'
            );
        }
        return $this->contienetable;
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
    private function getDesplazamientoTable()
    {
        if (!$this->desplazamiento) {
            $sm = $this->getServiceLocator();
            $this->desplazamiento= $sm->get(
                'Unidad\Model\DesplazamientoTable'
            );
        }
        return $this->desplazamiento;
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
