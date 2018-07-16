<?php
namespace Unidad\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Mantenimiento implements InputFilterAwareInterface
{
	public $idmantenimiento;
    public $idunidad;
    public $fechaingreso;
    public $fechasalida;
    public $idconductor;
    public $tipo;
    public $observacioningreso;
    public $observacionsalida;
    public $estado;
    public $inputFilter;

    public function exchangeArray($data)
    {
	    $this->idmantenimiento = (!empty($data['idcarga']))
		    ? $data['idcarga'] : null;
	    $this->idunidad = (!empty($data['idcargavolquete']))
		    ? $data['idcargavolquete'] : null;
	    $this->fechaingreso = (!empty($data['fechainicio']))
		    ? $data['fechainicio'] : null;
	    $this->fechasalida = (!empty($data['numero']))
		    ? $data['numero'] : null;
	    $this->idconductor = (!empty($data['fechafin']))
		    ? $data['fechafin'] : null;
	    $this->tipo = (!empty($data['estado']))
		    ? $data['estado'] : null;
	    $this->observacioningreso = (!empty($data['estado']))
		    ? $data['estado'] : null;
	    $this->observacionsalida = (!empty($data['estado']))
		    ? $data['estado'] : null;
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