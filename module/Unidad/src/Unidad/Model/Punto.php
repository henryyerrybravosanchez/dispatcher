<?php
namespace Unidad\Model;

use Zend\Form\Element;
use Zend\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Authentication\Validator;

class Punto implements InputFilterAwareInterface
{
	public $idpunto;
	public $idruta;
	public $estado;
	public $orden;
	public $latitud;
	public $longitud;
    public $inputFilter;

    public function exchangeArray($data)
    {
	    $this->idpunto = (!empty($data['idpunto']))
		    ? $data['idpunto'] : null;
	    $this->idruta = (!empty($data['idruta']))
		    ? $data['idruta'] : null;
	    $this->latitud = (!empty($data['latitud']))
		    ? $data['latitud'] : null;
	    $this->longitud = (!empty($data['longitud']))
		    ? $data['longitud'] : null;
	    $this->orden = (!empty($data['orden']))
		    ? $data['orden'] : null;
	    $this->estado = (!empty($data['estado']))
		    ? $data['estado'] : null;
    }

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
        if (!$this->inputFilter) {

        }

        return $this->inputFilter;
    }

}