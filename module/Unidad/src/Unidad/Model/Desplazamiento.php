<?php
namespace Unidad\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Desplazamiento implements InputFilterAwareInterface
{
	public $iddesplzamiento;
    public $idunidad;
    public $latitud;
    public $longitud;
    public $velocidad;
    public $altitud;
    public $fecha;
    public $estado;
    public $inputFilter;

    public function exchangeArray($data)
    {
	    $this->iddesplzamiento = (!empty($data['iddesplzamiento']))
		    ? $data['iddesplzamiento'] : null;
	    $this->idunidad = (!empty($data['idunidad']))
		    ? $data['idunidad'] : null;
	    $this->latitud = (!empty($data['latitud']))
		    ? $data['latitud'] : null;
	    $this->longitud = (!empty($data['longitud']))
		    ? $data['longitud'] : null;
	    $this->velocidad = (!empty($data['velocidad']))
		    ? $data['velocidad'] : null;
	    $this->altitud = (!empty($data['altitud']))
		    ? $data['altitud'] : null;
	    $this->fecha = (!empty($data['fecha']))
		    ? $data['fecha'] : null;
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