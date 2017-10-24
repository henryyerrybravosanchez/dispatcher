<?php
namespace Rrhh\Model;

use Zend\Form\Element;
use Zend\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Authentication\Validator;

class Colaborador implements InputFilterAwareInterface
{
	public $idcolaborador;
	public $nombres;
	public $ap;//Apellido paterno
	public $am;//Apellido materno
    public $dni;
	public $telefono;
	public $direccion;
	public $user;
	public $foto;
	public $contrasena;
	public $estado;
    public function exchangeArray($data)
    {
	    $this->idcolaborador = (!empty($data['idcolaborador']))
		    ? $data['idcolaborador'] : null;
	    $this->nombres = (!empty($data['nombre']))
		    ? $data['nombre'] : null;
	    $this->ap = (!empty($data['ap']))
		    ? $data['ap'] : null;
	    $this->am = (!empty($data['am']))
		    ? $data['am'] : null;
	    $this->dni = (!empty($data['dni']))
		    ? $data['dni'] : null;
	    $this->telefono = (!empty($data['telefono']))
		    ? $data['telefono'] : null;
	    $this->direccion = (!empty($data['direccion']))
		    ? $data['direccion'] : null;
	    $this->user = (!empty($data['user']))
		    ? $data['user'] : null;
	    $this->contrasena = (!empty($data['password']))
		    ? $data['password'] : null;
	    $this->foto = (!empty($data['foto']))
		    ? $data['foto'] : null;
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