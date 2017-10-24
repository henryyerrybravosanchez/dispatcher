<?php
namespace Unidad\Model;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
class CargaTable
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

    public function getCarga($id)
    {
        $rowset = $this->tableGateway->select(array('idcarga' => $id));
        $row = $rowset->current();
        if (!$row) {
            return false;
        }
        return $row;
    }
    public function saveOpera(Carga $carga)
    {
        $data = array(
            'idcargavolquete'=> $carga->idcargavolquete,
            'numero'=> $carga->numero,
            'fechainicio'=> $carga->fechainicio,
            'fechafin'=> $carga->fechafin,
            'estado'=> $carga->estado
        );

        $id = (int)$carga->idcarga;
        if ($id == 0) {
            $this->tableGateway->insert($data);
            $id = $this->tableGateway->lastInsertValue;
        } else {
            if ($this->getCarga($id)) {
                $this->tableGateway->update(
                    $data, array('idcarga' => $id)
                );
            } else {
                throw new \Exception('Carga no existe');
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

    //For reports
    public function getCantidadCargas()
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
}

?>