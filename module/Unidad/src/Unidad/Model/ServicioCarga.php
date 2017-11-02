<?php
namespace Unidad\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class ServicioCarga implements InputFilterAwareInterface
{
	public $idservicio;
    public $idcargador;
    public $idlugarorigen;
    public $idmaterial;
    public $fechainicio;
    public $fechafin;
    public $estado;
    public $inputFilter;

    public function exchangeArray($data)
    {
	    $this->idservicio = (!empty($data['idservicio']))
		    ? $data['idservicio'] : null;
	    $this->idcargador = (!empty($data['idcargador']))
		    ? $data['idcargador'] : null;
	    $this->idlugarorigen = (!empty($data['idlugarorigen']))
		    ? $data['idlugarorigen'] : null;
        $this->idmaterial = (!empty($data['idmaterial']))
            ? $data['idmaterial'] : null;
        $this->fechainicio = (!empty($data['fechainicio']))
            ? $data['fechainicio'] : null;
        $this->fechafin = (!empty($data['fechafin']))
            ? $data['fechafin'] : null;
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