<?php
namespace Lugar\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Material implements InputFilterAwareInterface
{
	public $idmaterial;
	public $nombre;
    public $estado;
    public $inputFilter;

    public function exchangeArray($data)
    {
	    $this->idmaterial = (!empty($data['idmaterial']))
		    ? $data['idmaterial'] : null;
	    $this->nombre = (!empty($data['nombre']))
		    ? $data['nombre'] : null;
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