<?php
namespace Unidad\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
class DesplazamientoTable
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

    public function getDesplazamiento($id)
    {
        $rowset = $this->tableGateway->select(array('iddesplazamiento' => $id));
        $row = $rowset->current();
        if (!$row) {
            return false;
        }
        return $row;
    }
    public function saveDesplazamiento(Desplazamiento $desplazamiento)
    {
        $data = array(
            'idunidad'=> $desplazamiento->idunidad,
            'latitud'=> $desplazamiento->latitud,
            'longitud'=> $desplazamiento->longitud,
            'altitud'=> $desplazamiento->altitud,
            'velocidad'=> $desplazamiento->velocidad,
            'fecha'=> $desplazamiento->fecha,
            'estado'=> $desplazamiento->estado
        );

        $id = (int)$desplazamiento->iddesplzamiento;
        if ($id == 0) {
            $this->tableGateway->insert($data);
            $id = $this->tableGateway->lastInsertValue;
        } else {
            if ($this->getDesplazamiento($id)) {
                $this->tableGateway->update(
                    $data, array('iddesplzamiento' => $id)
                );
            } else {
                throw new \Exception('Desplazamiento no existe');
            }
        }

        return $id;
    }
    public function getCantidadRegistros()
    {
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(
            array(
                'count' => new Expression('Count (*)')
            )
        );
        $statement = $this->tableGateway->getSql()
            ->prepareStatementForSqlObject($sqlSelect);
        $resultSet = $statement->execute();

        return $this->resultToArray($resultSet)[0]['count'];
    }
    public function getUbicacionesPala($fechadesde, $fechahasta, $idundiad)
    {


        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(
            array(
                'idunidad'=>  'idunidad',
                'latitud'=> 'latitud',
                'longitud'=> 'longitud',
                'altitud'=> 'altitud',
                'velocidad'=>'velocidad',
                'fecha'=> 'fecha',
                'estado'=> 'estado'
            )
        );
        $sqlSelect
            ->join(
                'unidad',
                'unidad.idunidad = desplazamiento.idunidad',
                array(
                    'placa'=>'placa'
                )
            )
        ;
        $sqlSelect->where("desplazamiento.fecha>= '$fechadesde' and desplazamiento.fecha<='$fechahasta' and desplazamiento.idunidad='$idundiad'");

        $statement = $this->tableGateway->getSql()
            ->prepareStatementForSqlObject($sqlSelect);
        $resultSet = $statement->execute();
        return $this->resultToArray($resultSet);
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