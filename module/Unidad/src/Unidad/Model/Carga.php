<?php
namespace Unidad\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Carga implements InputFilterAwareInterface
{
	public $idcarga;
    public $idcargavolquete;
    public $fechainicio;
    public $numero;
    public $fechafin;
    public $estado;
    public $inputFilter;

    public function exchangeArray($data)
    {
	    $this->idcarga = (!empty($data['idcarga']))
		    ? $data['idcarga'] : null;
	    $this->idcargavolquete = (!empty($data['idcargavolquete']))
		    ? $data['idcargavolquete'] : null;
	    $this->fechainicio = (!empty($data['fechainicio']))
		    ? $data['fechainicio'] : null;
	    $this->numero = (!empty($data['numero']))
		    ? $data['numero'] : null;
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