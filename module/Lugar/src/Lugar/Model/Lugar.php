<?php
namespace Lugar\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Lugar implements InputFilterAwareInterface
{
	public $idlugar;
	public $nombre;
	public $nombrecompleto;
	public $latitud;
	public $longitud;
    public $estado;
    public $inputFilter;

    public function exchangeArray($data)
    {
	    $this->idlugar = (!empty($data['idlugar']))
		    ? $data['idlugar'] : null;
	    $this->nombre = (!empty($data['nombre']))
		    ? $data['nombre'] : null;
	    $this->nombrecompleto = (!empty($data['nombrecompleto']))
		    ? $data['nombrecompleto'] : null;
	    $this->latitud = (!empty($data['latitud']))
		    ? $data['latitud'] : null;
	    $this->longitud= (!empty($data['longitud']))
		    ? $data['longitud'] : null;
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