<?php
namespace Unidad\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class EstadoMantenimiento implements InputFilterAwareInterface
{
	public $idestado;
    public $idunidad;
    public $idoperador;
    public $tipo;
    public $fechainicio;
    public $fechafin;
    public $observacioningreso;
    public $observacionsalida;
    public $estado;
    public $inputFilter;

    public function exchangeArray($data)
    {
	    $this->idestado = (!empty($data['idestado']))
		    ? $data['idestado'] : null;
	    $this->idunidad = (!empty($data['idunidad']))
		    ? $data['idunidad'] : null;
	    $this->idoperador = (!empty($data['idoperador']))
		    ? $data['idoperador'] : null;
	    $this->fechafin = (!empty($data['fechafin']))
		    ? $data['fechafin'] : null;
	    $this->fechainicio = (!empty($data['fechainicio']))
		    ? $data['fechainicio'] : null;
	    $this->tipo = (!empty($data['tipo']))
		    ? $data['tipo'] : null;
	    $this->observacioningreso = (!empty($data['observacioningreso']))
		    ? $data['observacioningreso'] : null;
	    $this->observacionsalida = (!empty($data['observacionsalida']))
		    ? $data['observacionsalida'] : null;
	    $this->estado = (!empty($data['estado']))
		    ? $data['estado'] : null;
    }

    // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {}
}