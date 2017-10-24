<?php
namespace Unidad\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Volquete implements InputFilterAwareInterface
{
	public $idvolquete;
    public $estado;
    public $inputFilter;

    public function exchangeArray($data)
    {
	    $this->idvolquete = (!empty($data['idvolquete']))
		    ? $data['idvolquete'] : null;
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