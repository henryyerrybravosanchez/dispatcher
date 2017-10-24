<?php
namespace Lugar\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Ruta implements InputFilterAwareInterface
{
	public $idruta;
	public $idLugarInicio;
	public $idLugarFinal;
	public $color;
	public $estado;
    public $inputFilter;

    public function exchangeArray($data)
    {
	    $this->idruta = (!empty($data['idruta']))
		    ? $data['idruta'] : null;
	    $this->idLugarFinal = (!empty($data['idLugarFinal']))
		    ? $data['idLugarFinal'] : null;
	    $this->idLugarInicio = (!empty($data['idLugarInicio']))
		    ? $data['idLugarInicio'] : null;
	    $this->color = (!empty($data['color']))
		    ? $data['color'] : null;
	    $this->estado = (!empty($data['estado']))
		    ? $data['estado'] : "1";
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