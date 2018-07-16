<?php
namespace Lugar\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Contiene implements InputFilterAwareInterface
{
	public $idlugar;
	public $idpunto;
	public $version;
    public $estado;
    public $inputFilter;

    public function exchangeArray($data)
    {
	    $this->idlugar = (!empty($data['idlugar']))
		    ? $data['idlugar'] : null;
	    $this->idpunto = (!empty($data['idpunto']))
		    ? $data['idpunto'] : null;
	    $this->version = (!empty($data['version']))
		    ? $data['version'] : null;
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