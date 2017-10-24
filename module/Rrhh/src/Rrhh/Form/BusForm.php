<?php
namespace Bus\Form;

use Zend\Form\Form;
use Zend\InputFilter;
use Zend\Form\Element;
/**
 *
 */
class BusForm extends Form
{

    function __construct($name = null)
    {
        parent::__construct($name = null);

        $this->setAttribute('class', 'form-horizontal');
        $this->setAttribute('id', 'bus-form');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');

        $this->add(
            array(
                'name' => 'idbus',
                'type' => 'Hidden',
            )
        );        

        $this->add(
            array(
                'name'       => 'nombretitular',
                'type'       => 'Text',
                'attributes' => array(
                    'placeholder'    => 'Nombre del titular',
                    'id'             => 'nombretitular',
                    'class'          => 'form-control',
                    'data-toggle'    => 'tooltip',
                    'data-placement' => 'right',
                    'title' => 'Nombre titular',
                ),
            )
        );
		
		$this->add(
		    array(
			    'name' => 'nplaca',
			    'type' => 'text',
			    'attributes' => array(
				    'placeholder'    => 'Número de placa',
				    'id'             => 'nplaca',
				    'class'          => 'form-control col-md-12',
				    'data-toggle'    => 'tooltip',
				    'data-placement' => 'right',
				    'title' => 'Número de placa',
			    ),

		    ));


		$this->add(
		    array(
			    'name' => 'npoliza',
			    'type' => 'text',
			    'attributes' => array(
				    'placeholder'    => 'Número de póliza',
				    'id'             => 'npoliza',
				    'class'          => 'form-control col-md-12',
				    'data-toggle'    => 'tooltip',
				    'data-placement' => 'right',
				    'title' => 'Número de póliza',
			    ),

		    ));


		$this->add(
		    array(
			    'name' => 'ntarjetahabilitacion',
			    'type' => 'text',
			    'attributes' => array(
				    'placeholder'    => 'Tarjeta habilitación',
				    'id'             => 'ntarjetahabilitacion',
				    'class'          => 'form-control col-md-12',
				    'data-toggle'    => 'tooltip',
				    'data-placement' => 'right',
				    'title' => 'Tarjeta habilitación',
			    ),

		    ));


		$this->add(
		    array(
			    'name' => 'ninspecciontecnica',
			    'type' => 'text',
			    'attributes' => array(
				    'placeholder'    => 'Inspección técnica',
				    'id'             => 'ninspecciontecnica',
				    'class'          => 'form-control col-md-12',
				    'data-toggle'    => 'tooltip',
				    'data-placement' => 'right',
				    'title' => 'Inspección técnica',
			    ),

		    ));


		$this->add(
		    array(
			    'name' => 'categoria',
			    'type' => 'text',
			    'attributes' => array(
				    'placeholder'    => 'Categoría',
				    'id'             => 'categoria',
				    'class'          => 'form-control col-md-12',
				    'data-toggle'    => 'tooltip',
				    'data-placement' => 'right',
				    'title' => 'Categoría del automovil',
			    ),

		    ));

		$this->add(
		    array(
			    'name' => 'marca',
			    'type' => 'text',
			    'attributes' => array(
				    'placeholder'    => 'Marca',
				    'id'             => 'marca',
				    'class'          => 'form-control col-md-12',
				    'data-toggle'    => 'tooltip',
				    'data-placement' => 'right',
				    'title' => 'Marca del automovil',
			    ),

		    ));


		$this->add(
		    array(
			    'name' => 'modelo',
			    'type' => 'text',
			    'attributes' => array(
				    'placeholder'    => 'Modelo',
				    'id'             => 'modelo',
				    'class'          => 'form-control col-md-12',
				    'data-toggle'    => 'tooltip',
				    'data-placement' => 'right',
				    'title' => 'Modelo del automovil',
			    ),

		    ));


		$this->add(
		    array(
			    'name' => 'color',
			    'type' => 'text',
			    'attributes' => array(
				    'placeholder'    => 'Color',
				    'id'             => 'color',
				    'class'          => 'form-control col-md-12',
				    'data-toggle'    => 'tooltip',
				    'data-placement' => 'right',
				    'title' => 'Color del automovil',
			    ),

		    ));

		$this->add(
		    array(
			    'name' => 'nmotor',
			    'type' => 'text',
			    'attributes' => array(
				    'placeholder'    => 'Número de motor',
				    'id'             => 'nmotor',
				    'class'          => 'form-control col-md-12',
				    'data-toggle'    => 'tooltip',
				    'data-placement' => 'right',
				    'title' => 'Número de motor del automovil',
			    ),

		    ));



		$this->add(
		    array(
			    'name' => 'nserie',
			    'type' => 'text',
			    'attributes' => array(
				    'placeholder'    => 'Número de serie',
				    'id'             => 'nserie',
				    'class'          => 'form-control col-md-12',
				    'data-toggle'    => 'tooltip',
				    'data-placement' => 'right',
				    'title' => 'Número de serie del automovil',
			    ),

		    ));


		$this->add(
		    array(
			    'name' => 'aniofabricacion',
			    'type' => 'text',
			    'attributes' => array(
				    'placeholder'    => 'Año de fabricación',
				    'id'             => 'aniofabricacion',
				    'class'          => 'form-control col-md-12',
				    'data-toggle'    => 'tooltip',
				    'data-placement' => 'right',
				    'title' => 'Año de fabricación',
			    ),

		    ));

		$this->add(
		    array(
			    'name' => 'nasientos',
			    'type' => 'text',
			    'attributes' => array(
				    'placeholder'    => 'Número de asientos',
				    'id'             => 'nasientos',
				    'class'          => 'form-control col-md-12',
				    'data-toggle'    => 'tooltip',
				    'data-placement' => 'right',
				    'title' => 'Número de asientos',
			    ),

		    ));

		$this->add(
		    array(
			    'name' => 'pesobruto',
			    'type' => 'text',
			    'attributes' => array(
				    'placeholder'    => 'Peso bruto',
				    'id'             => 'pesobruto',
				    'class'          => 'form-control col-md-12',
				    'data-toggle'    => 'tooltip',
				    'data-placement' => 'right',
				    'title' => 'Peso bruto',
			    ),

		    ));

		$this->add(
		    array(
			    'name' => 'pesoneto',
			    'type' => 'text',
			    'attributes' => array(
				    'placeholder'    => 'Peso bruto',
				    'id'             => 'pesobruto',
				    'class'          => 'form-control col-md-12',
				    'data-toggle'    => 'tooltip',
				    'data-placement' => 'right',
				    'title' => 'Peso bruto',
			    ),

		    ));

		$this->add(
		    array(
			    'name' => 'cargautil',
			    'type' => 'text',
			    'attributes' => array(
				    'placeholder'    => 'Carga útil',
				    'id'             => 'cargautil',
				    'class'          => 'form-control col-md-12',
				    'data-toggle'    => 'tooltip',
				    'data-placement' => 'right',
				    'title' => 'Carga útil',
			    ),

		    ));


		$this->add(
		    array(
			    'name' => 'altura',
			    'type' => 'text',
			    'attributes' => array(
				    'placeholder'    => 'Altura',
				    'id'             => 'altura',
				    'class'          => 'form-control col-md-12',
				    'data-toggle'    => 'tooltip',
				    'data-placement' => 'right',
				    'title' => 'Altura',
			    ),

		    ));



		$this->add(
		    array(
			    'name' => 'ancho',
			    'type' => 'text',
			    'attributes' => array(
				    'placeholder'    => 'Ancho',
				    'id'             => 'ancho',
				    'class'          => 'form-control col-md-12',
				    'data-toggle'    => 'tooltip',
				    'data-placement' => 'right',
				    'title' => 'Ancho',
			    ),

		    ));



        $this->add(
            array(
                'type'       => 'Zend\Form\Element\Radio',
                'name'       => 'estado',
                'options'    => array(
                    'label_attributes' => array(
                        'class' => 'radio-inline',
                    ),
                    'value_options'    => array(
                        '1' => 'Activo',
                        '2' => 'Inactivo',
                    ),
                ),
                'attributes' => array(
                    'id'    => 'estado',
                ),
            )
        );        
    }
}