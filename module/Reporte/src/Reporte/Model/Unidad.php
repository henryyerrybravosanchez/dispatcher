<?php
namespace Unidad\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Unidad implements InputFilterAwareInterface
{
	public $idunidad;
    public $placa;
    public $estado;
    public $inputFilter;

    public function exchangeArray($data)
    {
	    $this->idunidad = (!empty($data['idunidad']))
		    ? $data['idunidad'] : null;
        $this->placa = (!empty($data['placa']))
            ? $data['placa'] : null;
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