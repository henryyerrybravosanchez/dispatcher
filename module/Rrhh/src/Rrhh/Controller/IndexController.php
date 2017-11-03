<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Rrhh\Controller;

use Rrhh\Model\Colaborador;
use Rrhh\Model\Operador;
use Unidad\Model\Opera;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{

    public $dbAdapter;
    public $Rrhhtable;
    public $asientotable;
    public $unidadtable;
    public $palatable;
    public $volquetetable;
    public $operatable;
    public $operadortable;
    public $colaboradortable;

    public function operadorAction(){

        if ($this->request->isXmlHttpRequest()) {
            $o = (int)$this->request->getPost('o');
            switch ($o) {
                case 1:
                    try{
                        $idcolaborador = (int)$this->request->getPost('idc');
                        $datavolquetes=$this->getUnidadTable()->getAllManeja($idcolaborador,1);//Volquetes
                        $datapalas=$this->getUnidadTable()->getAllManeja($idcolaborador,2);//Palas
                        return new JsonModel(
                            array(
                                'data'=>array(
                                    'datapalas'=>$datapalas,
                                    'datavolquetes'=>$datavolquetes
                                ),
                                'o'=>$o
                            ));
                    }catch (\Exception $exception){
                        return new JsonModel(
                            array(
                                'data'=>-1,
                                'o'=>$o,
                                'm'=>$exception
                            ));
                    }
                    break;
                case 2:
                    try{
                        $idopera = (int)$this->request->getPost('ido');
                        $fechainicio = $this->request->getPost('fi');
                        $fechafin= $this->request->getPost('ff');
                        $opera=$this->getOperaTable()->getOpera($idopera);
                        $opera->fechainicio=$fechainicio;
                        $opera->fechafin=$fechafin;
                        if($fechafin=="")//si todavia no hay una fecha de termino asignada se va a guardar como nula
                        {
                            $opera->fechafin=null;
                        }
                        $id=$this->getOperaTable()->saveOpera($opera);
                        if($id)
                            return new JsonModel(
                                array(
                                    'data'=>$id,
                                    'o'=>$o
                                ));
                    }catch (\Exception $exception){
                        return new JsonModel(
                            array(
                                'data'=>-1,
                                'o'=>$o,
                                'm'=>$exception
                            ));
                    }
                    break;
                case 3:
                    $idcolaborador = (int)$this->request->getPost('idc');
                    $nombre = $this->request->getPost('n');
                    $ap = $this->request->getPost('ap');
                    $am = $this->request->getPost('am');
                    $telefono = $this->request->getPost('t');
                    $direccion = $this->request->getPost('d');
                    $user = $this->request->getPost('u');
                    $password = $this->request->getPost('p');
                    $dni = $this->request->getPost('dni');
                    $estado = $this->request->getPost('e');
                    if($idcolaborador==0)
                        $colaborador=new Colaborador();
                    else
                        $colaborador=$this->getColaboradorTable()->getColaborador($idcolaborador);
                    $colaborador->idcolaborador=$idcolaborador;
                    $colaborador->nombres=$nombre;
                    $colaborador->ap=$ap;
                    $colaborador->am=$am;
                    $colaborador->dni=$dni;
                    $colaborador->telefono=$telefono;
                    $colaborador->direccion=$direccion;
                    $colaborador->user=$user;
                    $colaborador->contrasena=$password;
                    $colaborador->estado=$estado;
                    $idcolaborador=$this->getColaboradorTable()->saveColaborador($colaborador);
                    if($idcolaborador){
                        if($colaborador->idcolaborador==0){

                            $operador=new Operador();
                            $operador->idoperador=$idcolaborador;
                            $this->getOperadorTable()->saveOperador($operador);
                        }
                        return new JsonModel(
                            array(
                                'data'=>$idcolaborador,
                                'o'=>$o
                            ));
                    }

                    else
                        return new JsonModel(
                            array(
                                'data'=>-1,
                                'o'=>$o,
                                'm'=>"Error al guardar"
                            ));
                    break;
                case 4:
                    $tipo = (int)$this->request->getPost('t');
                    $unidades=array();
                    switch ($tipo){
                        case 1:
                            $unidades= $this->getUnidadTable()->fetchAllPalas();
                            break;
                        case 2:
                            $unidades=$this->getUnidadTable()->fetchAllVolquetes();
                            break;
                    }

                    return new JsonModel(
                        array(
                            'data'=>$unidades,
                            'o'=>$o,
                            't'=>$tipo
                        ));

                    break;
                case 5:
                    try {
                        $idcolaborador = (int)$this->request->getPost('idc');
                        $idunidad = (int)$this->request->getPost('idu');
                        $fechainicio = $this->request->getPost('fi');
                        $fechafin= $this->request->getPost('ff');
                        $opera= new Opera();
                        $opera->idoperador=$idcolaborador;
                        if($fechafin!="")
                            $opera->fechafin=$fechafin;
                        else
                            $opera->fechafin=null;
                        $opera->fechainicio=$fechainicio;
                        $opera->idunidad=$idunidad;
                        $opera->estado=1;
                        $id=$this->getOperaTable()->saveOpera($opera);
                        if($id)
                            return new JsonModel(
                                array(
                                    'data'=>$id,
                                    'o'=>$o
                                )
                            );
                    }catch (\Exception $exception){
                        return new JsonModel(
                            array(
                                'data'=>-1,
                                'o'=>$o,
                                'm'=>$exception
                            ));
                    }
                    break;
                case 6:
                    $id = (int)$this->request->getPost('ido');
                    $opera=$this->getOperaTable()->getOpera($id);
                    $opera->fechainicio=str_replace(" ", "T", $opera->fechainicio);
                    if($opera->fechafin)
                        $opera->fechafin=str_replace(" ", "T", $opera->fechafin);
                    $opera->estado=2;
                    $idopera=$this->getOperaTable()->saveOpera($opera);
                    if($idopera){
                        return new JsonModel(
                            array(
                                'data'=>$idopera,
                                'o'=>$o
                            )
                        );
                    }
                    else
                        return new JsonModel(
                            array(
                                'data'=>-1,
                                'o'=>$o,
                                'm'=>"Error al guardar"
                            ));
                    break;
                case 7:
                    $id = (int)$this->request->getPost('idc');
                    $colaborador=$this->getColaboradorTable()->getColaborador($id);
                    return new JsonModel(
                        array(
                            'data'=>$colaborador,
                            'o'=>$o
                        )
                    );
                    break;
                case 8:
                    $idcolaborador = (int)$this->request->getPost('idc');
                    $foto=$this->request->getPost('f');
                    $colaborador=$this->getColaboradorTable()->getColaborador($idcolaborador);
                    $colaborador->foto=$foto;
                    $this->getColaboradorTable()->saveColaborador($colaborador);
                    return new JsonModel(
                      array(
                          'data'=>$colaborador,
                          'o'=>$o
                      ));
                    break;
            }
        }

        $colaboradores=$this->getColaboradorTable()->fetchAllOperador();

        return new ViewModel(
            array(
                'operadores'=>$colaboradores
            ));
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

    private function getOperadorTable()
    {
        if (!$this->operadortable) {
            $sm = $this->getServiceLocator();
            $this->operadortable = $sm->get(
                'Rrhh\Model\OperadorTable'
            );
        }

        return $this->operadortable;
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

    private function getColaboradorTable()
    {
        if (!$this->colaboradortable) {
            $sm = $this->getServiceLocator();
            $this->colaboradortable = $sm->get(
                'Rrhh\Model\ColaboradorTable'
            );
        }
        return $this->colaboradortable;
    }

}
