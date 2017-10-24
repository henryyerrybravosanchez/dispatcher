<?php
namespace Rrhh\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Operador implements InputFilterAwareInterface
{
	public $idoperador;
    public $inputFilter;

    public function exchangeArray($data)
    {
	    $this->idoperador= (!empty($data['idoperador']))
		    ? $data['idoperador'] : null;
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