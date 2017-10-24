<?php
namespace Unidad\Model;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
class PuntoTable
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

    public function getPunto($id)
    {
        $rowset = $this->tableGateway->select(array('idpunto' => $id));
        $row = $rowset->current();
        if (!$row) {
            return false;
        }

        return $row;
    }
    public function getAllPoints()
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
                'punto',
                'punto.idpunto = unidad.idunidad',
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
    public function updateStateRoute($idruta, $state)
    {
        $this->tableGateway->update(
            array("estado"=>$state), array('idruta' => $idruta)
        );
    }
	public function savePunto(Punto $punto)
    {
        $data = array(
            'orden'   => $punto->orden,
            'idruta'    =>$punto->idruta,
            'latitud'   =>$punto->latitud,
            'longitud'  =>$punto->longitud,
            'estado'    =>$punto->estado
        );

        $id = (int)$punto->idpunto;
        if ($id == 0) {
            $this->tableGateway->insert($data);
            $id = $this->tableGateway->lastInsertValue;
        } else {
            if ($this->getPunto($id)) {
                $this->tableGateway->update(
                    $data, array('idpunto' => $id)
                );
            } else {
	            $id = 0;
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