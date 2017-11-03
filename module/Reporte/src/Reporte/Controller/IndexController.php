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
    public $serviciotable;
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
        $cantidadTerminanEsteMes=$this->getOperaTable()->getOperaMonthFinish();
        /*
        return new JsonModel(
            array(
                'siguiente'=>date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")+1, date("d"),   date("Y"))),
                'actual'=>date("Y-m-d H:i:s")
            )
        );*/
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
                case 3:
                    try {
                        $fechainicial= $this->request->getPost('fi');
                        $fechafinal= $this->request->getPost('ff');
                        $fIex=explode('-', $fechainicial);
                        $fFex=explode('-', $fechafinal);
                        $fechainicial=$fIex[2]."-".$fIex[1]."-".$fIex[0];
                        $fechafinal=$fFex[2]."-".$fFex[1]."-".$fFex[0];
                        $cargas=$this->getCargaTable()->getCantidadCargasLugares($fechainicial, $fechafinal);
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
    public function unidadesAction(){
        if ($this->request->isXmlHttpRequest()) {
            $o = (int)$this->request->getPost('o');
            switch ($o)
            {
                case 1:
                    try {
                        $fechainicial= $this->request->getPost('fi');
                        $fechafinal= $this->request->getPost('ff');
                        $idpala= (int)$this->request->getPost('idp');
                        $fIex=explode('-', $fechainicial);
                        $fFex=explode('-', $fechafinal);
                        $fechainicial=$fIex[2]."-".$fIex[1]."-".$fIex[0];
                        $fechafinal=$fFex[2]."-".$fFex[1]."-".$fFex[0];
                        $cargas=$this->getCargaTable()->getCantidadCargasFechasUnidadesP($fechainicial, $fechafinal, $idpala);
                        return new JsonModel(array('data'=>$cargas));
                    }
                    catch (\Exception $e) {
                        return new JsonModel(array('data' => -1, 'm'=>$e));
                    }
                    break;
                case 2:
                    try {
                        $fechainicial= $this->request->getPost('fi');
                        $fechafinal= $this->request->getPost('ff');
                        $idpala= (int)$this->request->getPost('idp');
                        $fIex=explode('-', $fechainicial);
                        $fFex=explode('-', $fechafinal);
                        $fechainicial=$fIex[2]."-".$fIex[1]."-".$fIex[0];
                        $fechafinal=$fFex[2]."-".$fFex[1]."-".$fFex[0];
                        $cargas=$this->getCargaTable()->getCantidadCargasFechasUnidadesV($fechainicial, $fechafinal, $idpala);
                        return new JsonModel(array('data'=>$cargas));
                    }
                    catch (\Exception $e) {
                        return new JsonModel(array('data' => -1, 'm'=>$e));
                    }
                    break;
                case 3:
                    try{
                        $idpala = (int)$this->request->getPost('idp');
                        $carga=$this->getServicioCargaTable()->getServiciosPala($idpala);
                        return new JsonModel(array('data'=>$carga));
                    }catch (\Exception $e)
                    {
                        return new JsonModel(array('data' => -1, 'm'=>$e));
                    }
                    break;
                case 4:
                    try{
                        $idservicio = (int)$this->request->getPost('ids');
                        $carga=$this->getCargaTable()->getCantidadCargasFechasUnidadesVServicio($idservicio);
                        $servicio=$this->getServicioCargaTable()->getServicioCarga($idservicio);
                        return new JsonModel(array('data'=>$carga, 'servicio'=>$servicio));
                    }catch (\Exception $e)
                    {
                        return new JsonModel(array('data' => -1, 'm'=>$e));
                    }
                    break;

            }
        }
        $palas=$this->getUnidadTable()->fetchAllPalas();
        $camiones=$this->getUnidadTable()->fetchAllVolquetes();
        return new ViewModel(
            array(
                'palas'=>$palas,
                'camiones'=>$camiones
            )
        );
    }
    public function ubicacionesAction()
    {
        if ($this->request->isXmlHttpRequest()) {
            $o = (int)$this->request->getPost('o');
            switch ($o)
            {
                case 1:
                    try {
                        $fechainicial= $this->request->getPost('fi');
                        $fechafinal= $this->request->getPost('ff');
                        $idunidad= (int)$this->request->getPost('p');
                        $tipo= (int)$this->request->getPost('t');
                        $fIex=explode('-', $fechainicial);
                        $fFex=explode('-', $fechafinal);
                        $fechainicial=$fIex[2]."-".$fIex[1]."-".$fIex[0];
                        $fechafinal=$fFex[2]."-".$fFex[1]."-".$fFex[0];
                        $ubicaciones=$this->getDesplazamientoTable()->getUbicacionesPala($fechainicial, $fechafinal, $idunidad);
                        return new JsonModel(array('data'=>$ubicaciones));
                    }
                    catch (\Exception $e) {
                        return new JsonModel(array('data' => -1, 'm'=>$e));
                    }
                    break;
                case 2:

                    break;

            }
        }
        $palas=$this->getUnidadTable()->fetchAllPalas();
        $camiones=$this->getUnidadTable()->fetchAllVolquetes();
        return new ViewModel(
            array(
                'palas'=>$palas,
                'camiones'=>$camiones
            )
        );
    }
    public function desplazamientoAction()
    {
        $idunidad=$this->params()->fromRoute("id",0);
        $param=$this->params()->fromRoute("param",0);
        if($idunidad&&$param)
        {
            try{
                $fechasArray= explode("a", $param);

                $fechaDesde=$fechasArray[2]."-".$fechasArray[1]."-".$fechasArray[0]." ".$fechasArray[3].":".$fechasArray[4].":".$fechasArray[5];
                $fechaHasta=$fechasArray[8]."-".$fechasArray[7]."-".$fechasArray[6]." ".$fechasArray[9].":".$fechasArray[10].":".$fechasArray[11];
                $ubicaciones=$this->getDesplazamientoTable()->getUbicacionesPala($fechaDesde, $fechaHasta, $idunidad);
                return new ViewModel(
                    array(
                        'ubicaciones'=>$ubicaciones
                    )
                );
            }
           catch(\Exception $exception)
            {
                return $this->redirect()->toRoute(
                    'reporte', array(
                        'action' => 'ubicaciones'
                    )
                );
            }
        }
        else
        {
            return $this->redirect()->toRoute(
                'reporte', array(
                    'action' => 'ubicaciones'
                )
            );
        }
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
    private function getServicioCargaTable()
    {
        if (!$this->serviciotable) {
            $sm = $this->getServiceLocator();
            $this->serviciotable = $sm->get(
                'Unidad\Model\ServicioCargaTable'
            );
        }

        return $this->serviciotable;

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
