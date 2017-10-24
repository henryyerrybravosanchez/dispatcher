<?php
namespace Unidad\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Opera implements InputFilterAwareInterface
{
	public $idopera;
    public $idoperador;
    public $idunidad;
    public $fechainicio;
    public $fechafin;
    public $estado;
    public $inputFilter;

    public function exchangeArray($data)
    {
	    $this->idopera = (!empty($data['idopera']))
		    ? $data['idopera'] : null;
	    $this->idoperador = (!empty($data['idoperador']))
		    ? $data['idoperador'] : null;
	    $this->idunidad = (!empty($data['idunidad']))
		    ? $data['idunidad'] : null;
	    $this->fechainicio = (!empty($data['fechainicio']))
		    ? $data['fechainicio'] : null;
	    $this->fechafin = (!empty($data['fechafin']))
		    ? $data['fechafin'] : null;
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