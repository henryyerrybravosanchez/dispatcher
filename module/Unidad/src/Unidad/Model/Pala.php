<?php
namespace Unidad\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Pala implements InputFilterAwareInterface
{
	public $idcargador;
    public $estado;
    public $galonesXhora;
    public $inputFilter;

    public function exchangeArray($data)
    {
	    $this->idcargador = (!empty($data['idcargador']))
		    ? $data['idcargador'] : null;
	    $this->galonesXhora = (!empty($data['galonesXhora']))
		    ? $data['galonesXhora'] : null;
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
    {

    }
}