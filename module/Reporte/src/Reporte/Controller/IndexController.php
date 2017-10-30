<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Reporte\Controller;

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
    public $cargatable;
    public $desplazamientotable;
    public $palatable;
    public $materialtable;

    public function indexAction()
    {

        $cargaCount=$this->getCargaTable()->getCantidadCargas();
        $cantidadPalas=$this->getUnidadTable()->getPalasCantidad();
        $cantidadVolquetes=$this->getUnidadTable()->getVolquetesCantidad();
        $cantidadVolquetesdesactivados=$this->getUnidadTable()->getVolquetesCantidadDesactivados();
        $cantidadPalasdesactivados=$this->getUnidadTable()->getPalasCantidadDesactivado();
        $desplazamientoCount=$this->getDesplazamientoTable()->getCantidadRegistros();
        $operadoresCount=$this->getOperaTable()->getOperadoresAll();
        $date=explode('-', date("Y-m-d"));
        $cantidadTerminanEsteMes=$this->getOperaTable()->getOperaMonthFinish($date[1],$date[0]);
        $cantidadLugares=$this->getLugarTable()->getLugaresAll();
        $cantidadMateriales=$this->getLugarTable()->getMaterialesAll();
        $cantidadRutas=$this->getRutaTable()->getRutasAll();
        $ordenesServicio=$this->getUnidadTable()->getPalasServicio();
        $ordenesServicioCamion=$this->getUnidadTable()->getCamionesServicio();
        $arrayDateDays= array();
        $arrayDateHrs= array();
        $galonesPalasTotalesXPala=array();
        $totalHoras=0;
        $totalDias=0;
        foreach ($ordenesServicio as $value){
            $date = date_create($value['fechainicio']);
            $datef = date_create($value['fechafin']);
            $dif=date_diff($date, $datef);
            $totalDias+=$dif->days;
            $totalHoras+=$dif->h;
            if(isset($arrayDateDays[$value['idunidad']])){
                $arrayDateDays[$value['idunidad']]=$arrayDateDays[$value['idunidad']]+$dif->days;
                $arrayDateHrs[$value['idunidad']]=$arrayDateHrs[$value['idunidad']]+$dif->h;
            }
            else{
                $arrayDateDays[$value['idunidad']]=$dif->days;
                $arrayDateHrs[$value['idunidad']]=$dif->h;
            }
            if(isset($arrayDateDays[$value['idunidad']]))
                $galonesPalasTotalesXPala[$value['idunidad']]=$value['galonesXhora']*$arrayDateHrs[$value['idunidad']]+$value['galonesXhora']*24*$arrayDateDays[$value['idunidad']];
        }

        $totalHorasCamion=0;
        $totalDiasCamion=0;
        foreach ($ordenesServicioCamion as $value){
            $date = date_create($value['fechainicio']);
            $datef = date_create($value['fechafin']);
            $dif=date_diff($date, $datef);
            $totalDiasCamion+=$dif->days;
            $totalHorasCamion+=$dif->h;
        }
        $totalGeneralPalas=0;
        foreach ($galonesPalasTotalesXPala as  $v){
            $totalGeneralPalas+=$v;
        }
        return new ViewModel(
           array(
               'cantidadCargas'=>$cargaCount,
               'cantidadPalas'=>$cantidadPalas,
               'cantidadVolquetes'=>$cantidadVolquetes,
               'cantidadDesactivadosV'=>$cantidadVolquetesdesactivados,
               'cantidadDesactivadosP'=>$cantidadPalasdesactivados,
               'registrosDesplazamientos'=>$desplazamientoCount,
               'cantidadOperadores'=>$operadoresCount,
               'cantidadEsteMes'=>$cantidadTerminanEsteMes,
               'cantidadLugares'=>$cantidadLugares,
               'cantidadMateriales'=>$cantidadMateriales,
               'cantidadRutas'=>$cantidadRutas,
               'cantidadGalonesPalas'=>$totalGeneralPalas,
               'cantidadDiasServicio'=>$arrayDateDays,
               'cantidadHorasServicio'=>$arrayDateHrs,
               'totalHoras'=>$totalHoras,
               'totalDias'=>$totalDias,
               'totalHoraCamion'=>$totalHorasCamion,
               'totalDiasCamion'=>$totalDiasCamion
           )
        );
    }

    public function cargasAction(){
        if ($this->request->isXmlHttpRequest()) {
            $o = (int)$this->request->getPost('o');
            switch ($o) {

                case 1:
                    try {
                        $fechainicial= $this->request->getPost('fi');
                        $fechafinal= $this->request->getPost('ff');
                        $idmaterial= (int)$this->request->getPost('idm');
                        $fIex=explode('-', $fechainicial);
                        $fFex=explode('-', $fechafinal);
                        $fechainicial=$fIex[2]."-".$fIex[1]."-".$fIex[0];
                        $fechafinal=$fFex[2]."-".$fFex[1]."-".$fFex[0];
                        $cargas=$this->getCargaTable()->getCantidadCargasFechas($fechainicial, $fechafinal, $idmaterial);
                        return new JsonModel(array('data'=>$cargas));
                    }
                    catch (\Exception $e) {
                        return new JsonModel(array('data' => -1, 'm'=>$e));
                    }
                    case 2:
                    try {
                        $fechainicial= $this->request->getPost('fi');
                        $fechafinal= $this->request->getPost('ff');
                        $fIex=explode('-', $fechainicial);
                        $fFex=explode('-', $fechafinal);
                        $fechainicial=$fIex[2]."-".$fIex[1]."-".$fIex[0];
                        $fechafinal=$fFex[2]."-".$fFex[1]."-".$fFex[0];
                        $cargas=$this->getCargaTable()->getCantidadCargasMateriales($fechainicial, $fechafinal);
                        return new JsonModel(array('data'=>$cargas));
                    }
                    catch (\Exception $e) {
                        return new JsonModel(array('data' => -1, 'm'=>$e));
                    }
                    break;
            }
        }
        $materiales=$this->getMaterialTable()->fetchAll();
        return new ViewModel(
            array(
                'materiales'=>$materiales,
            )
        );
    }
    private function getCargaTable()
    {
        if (!$this->cargatable) {
            $sm = $this->getServiceLocator();
            $this->cargatable = $sm->get(
                'Unidad\Model\CargaTable'
            );
        }
        return $this->cargatable;
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
    private function getDesplazamientoTable()
    {
        if (!$this->desplazamientotable) {
            $sm = $this->getServiceLocator();
            $this->desplazamientotable = $sm->get(
                'Unidad\Model\DesplazamientoTable'
            );
        }

        return $this->desplazamientotable;
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
    private function getMaterialTable()
    {
        if (!$this->materialtable) {
            $sm = $this->getServiceLocator();
            $this->materialtable = $sm->get(
                'Lugar\Model\MaterialTable'
            );
        }
        return $this->materialtable;
    }
}
