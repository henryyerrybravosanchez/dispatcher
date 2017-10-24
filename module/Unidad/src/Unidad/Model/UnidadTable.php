<?php
namespace Unidad\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
class UnidadTable
{
    protected $tableGateway;
    protected $dbAdapter;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();

        return $this->resultToArray($resultSet);
    }

    public function getUnidad($id)
    {
        $rowset = $this->tableGateway->select(array('idunidad' => $id));
        $row = $rowset->current();
        if (!$row) {
            return false;
        }
        return $row;
    }


    public function getPalasUbicacion()
    {
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(
            array(
                'idunidad' => 'idunidad',
                'placa' => 'placa',
                'estado' => 'estado',
            )
        );
        $sqlSelect
            ->join(
                'u_cargador',
                'u_cargador.idcargador = unidad.idunidad',
                array(
                    'idcargador' => 'idcargador',
                    'estado' => 'estado',
                )
            )->join(
                'desplazamiento',
                'desplazamiento.idunidad = unidad.idunidad',
                array(
                    'latitud' => 'latitud',
                    'longitud' => 'longitud',
                    'velocidad' => 'velocidad',
                    'altitud' => 'altitud',
                    'fecha' => 'fecha',
                    'estado' => 'estado',
                )
            );

        $sqlSelect->where(
            array(
                'desplazamiento.estado' => '1',
            )
        );
        $statement = $this->tableGateway->getSql()
            ->prepareStatementForSqlObject($sqlSelect);
        $resultSet = $statement->execute();

        return $this->resultToArray($resultSet);
    }

    public function getPalasCantidad()
    {
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(
            array(
                'cantidad' => new Expression('Count (*)')
            )
        );
        $sqlSelect
            ->join(
                'u_cargador',
                'u_cargador.idcargador = unidad.idunidad',
                array(
                )
            );
        $statement = $this->tableGateway->getSql()
            ->prepareStatementForSqlObject($sqlSelect);
        $resultSet = $statement->execute();

        return $this->resultToArray($resultSet)[0]['cantidad'];
    }

    public function getPalasServicio()
    {
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(
            array(
                'idunidad'=>'idunidad'
            )
        );
        $sqlSelect
            ->join(
                'u_cargador',
                'u_cargador.idcargador = unidad.idunidad',
                array(
                    'galonesXhora'=>'galonesXhora'
                )
            );
        $sqlSelect
            ->join(
                'servicio_carga',
                'servicio_carga.idcargador = u_cargador.idcargador',
                array(
                    'fechafin'=>'fechafin',
                    'fechainicio'=>'fechainicio'
                )
            );
        $sqlSelect->where('servicio_carga.estado=2');
        $sqlSelect->order('idunidad');
        $statement = $this->tableGateway->getSql()
            ->prepareStatementForSqlObject($sqlSelect);
        $resultSet = $statement->execute();

        return $this->resultToArray($resultSet);
    }

    public function getCamionesServicio()
    {
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(
            array(
                'idunidad'=>'idunidad'
            )
        );
        $sqlSelect
            ->join(
                'u_volquete',
                'u_volquete.idvolquete = unidad.idunidad',
                array(
                    'galonesXkm'=>'galonesXkm'
                )
            );
        $sqlSelect
            ->join(
                'carga_volquete',
                'carga_volquete.idvolquete = unidad.idunidad',
                array(
                    'fechafin'=>'fechafin',
                    'fechainicio'=>'fechainicio'
                )
            );
        $sqlSelect->where('carga_volquete.estado=2');
        $sqlSelect->order('idunidad');
        $statement = $this->tableGateway->getSql()
            ->prepareStatementForSqlObject($sqlSelect);
        $resultSet = $statement->execute();

        return $this->resultToArray($resultSet);
    }

    public function getPalasCantidadDesactivado()
    {
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(
            array(
                'cantidad' => new Expression('Count (*)')
            )
        );
        $sqlSelect
            ->join(
                'u_cargador',
                'u_cargador.idcargador = unidad.idunidad',
                array(
                )
            );
        $sqlSelect->where('u_cargador.estado=4');
        $statement = $this->tableGateway->getSql()
            ->prepareStatementForSqlObject($sqlSelect);
        $resultSet = $statement->execute();

        return $this->resultToArray($resultSet)[0]['cantidad'];
    }

    public function getVolquetesUbicacion()
    {
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(
            array(
                'idunidad' => 'idunidad',
                'placa' => 'placa',
                'estado' => 'estado',
            )
        );
        $sqlSelect
            ->join(
                'u_volquete',
                'u_volquete.idvolquete = unidad.idunidad',
                array(
                    'idvolquete' => 'idvolquete',
                    'estado' => 'estado',
                )
            )->join(
                'desplazamiento',
                'desplazamiento.idunidad = unidad.idunidad',
                array(
                    'latitud' => 'latitud',
                    'longitud' => 'longitud',
                    'velocidad' => 'velocidad',
                    'altitud' => 'altitud',
                    'fecha' => 'fecha',
                    'estado' => 'estado',
                )
            );

        $sqlSelect->where(
            array(
                'desplazamiento.estado' => '1',
            )
        );
        $statement = $this->tableGateway->getSql()
            ->prepareStatementForSqlObject($sqlSelect);
        $resultSet = $statement->execute();

        return $this->resultToArray($resultSet);
    }
    public function getVolquetesCantidad()
    {
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(
            array(
                'cantidad' => new Expression('Count (*)')
            )
        );
        $sqlSelect
            ->join(
                'u_volquete',
                'u_volquete.idvolquete = unidad.idunidad',
                array(
                )
            );


        $statement = $this->tableGateway->getSql()
            ->prepareStatementForSqlObject($sqlSelect);
        $resultSet = $statement->execute();

        return $this->resultToArray($resultSet)[0]['cantidad'];
    }

    public function getVolquetesCantidadDesactivados()
    {
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(
            array(
                'cantidad' => new Expression('Count (*)')
            )
        );
        $sqlSelect
            ->join(
                'u_volquete',
                'u_volquete.idvolquete = unidad.idunidad',
                array(
                )
            );
        $sqlSelect->where('u_volquete.estado=4');

        $statement = $this->tableGateway->getSql()
            ->prepareStatementForSqlObject($sqlSelect);
        $resultSet = $statement->execute();

        return $this->resultToArray($resultSet)[0]['cantidad'];
    }

    public function fetchAllVolquetes(){
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(
            array(
                'idunidad' => 'idunidad',
                'placa' => 'placa',
                'estado' => 'estado',
            )
        );
        $sqlSelect
            ->join(
                'u_volquete',
                'u_volquete.idvolquete = unidad.idunidad',
                array(
                    'idvolquete' => 'idvolquete',
                    'estado' => 'estado',
                )
            );
        $sqlSelect->order('unidad.idunidad DESC');


        $statement = $this->tableGateway->getSql()
            ->prepareStatementForSqlObject($sqlSelect);
        $resultSet = $statement->execute();

        return $this->resultToArray($resultSet);
    }
    public function fetchAllPalas(){
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(
            array(
                'idunidad' => 'idunidad',
                'placa' => 'placa',
                'estado' => 'estado',
            )
        );
        $sqlSelect
            ->join(
                'u_cargador',
                'u_cargador.idcargador = unidad.idunidad',
                array(
                    'idcargador' => 'idcargador',
                    'estado' => 'estado',
                )
            );

        $sqlSelect->order('unidad.idunidad DESC');
        $statement = $this->tableGateway->getSql()
            ->prepareStatementForSqlObject($sqlSelect);
        $resultSet = $statement->execute();

        return $this->resultToArray($resultSet);
    }
    public function getAllManeja($idoperador, $tipo)
    {

        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(
            array(
                'idunidad' => 'idunidad',
                'placa' => 'placa',
                'estado' => 'estado',
            )
        );
        $sqlSelect
            ->join(
                'opera',
                'opera.idunidad = unidad.idunidad',
                array(
                    'idopera' => 'idopera',
                    'idoperador' => 'idoperador',
                    'fechainicio' => 'fechainicio',
                    'fechafin' => 'fechafin',
                    'estadoopera' => 'estado'
                )
            );
        switch ($tipo){
            case 1:
                $sqlSelect
                    ->join(
                        'u_volquete',
                        'u_volquete.idvolquete = unidad.idunidad',
                        array(
                            'estadovolquete' => 'estado'
                        )
                    );
                break;
            case 2:
                $sqlSelect
                    ->join(
                        'u_cargador',
                        'u_cargador.idcargador = unidad.idunidad',
                        array(
                            'estadocargador' => 'estado'
                        )
                    );
                break;
        }
        $sqlSelect->order('opera.idopera DESC');
        $sqlSelect->where('opera.idoperador='.$idoperador.' and opera.estado!=2');
        $statement = $this->tableGateway->getSql()
            ->prepareStatementForSqlObject($sqlSelect);
        $resultSet = $statement->execute();

        return $this->resultToArray($resultSet);
    }
    public function fetchAllOperador($estadopera, $estadocolaborador){
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(
            array(
                'idunidad' => 'idunidad',
                'placa' => 'placa',
                'estado' => 'estado',
            )
        );
        $sqlSelect
            ->join(
                'opera',
                'opera.idunidad = unidad.idunidad',
                array(
                    'idcolaborador' => 'idcolaborador',
                    'fechainicio' => 'fechainicio',
                    'fechafin' => 'fechafin',
                    'estadooperador' => 'estado'
                )
            )
            ->join(
                'colaborador',
                'colaborador.idcolaborador = opera.idcolaborador',
                array(
                    'nombre' => 'nombre',
                    'ap' => 'ap',
                    'am' => 'am',
                    'telefono' => 'telefono',
                    'direccion' => 'direccion',
                    'user' => 'user',
                    'password' => 'password',
                    'estadocolaborador' => 'estado'
                )
            );

        $sqlSelect->order('opera.idopera DESC');
        $sqlSelect->where('opera.estado='.$estadopera.' and colaborador.estado='.$estadocolaborador);
        $statement = $this->tableGateway->getSql()
            ->prepareStatementForSqlObject($sqlSelect);
        $resultSet = $statement->execute();

        return $this->resultToArray($resultSet);
    }

    public function saveUnidad(Unidad $unidad)
    {
        $data = array(
            'placa'             => $unidad->placa,
            'estado'             => $unidad->estado
        );
        $id = (int)$unidad->idunidad;
        if ($id == 0) {
            $this->tableGateway->insert($data);
            $id = $this->tableGateway->lastInsertValue;
        } else {
            if ($this->getUnidad($id)) {
                $this->tableGateway->update(
                    $data, array('idunidad' => $id)
                );
            } else {
                throw new \Exception('Persona no existe');
            }
        }

        return $id;
    }

    private function resultToArray($result)
    {
        $data = array();
        foreach ($result as $value) {
            $data[] = $value;
        }

        return $data;
    }


}

?>