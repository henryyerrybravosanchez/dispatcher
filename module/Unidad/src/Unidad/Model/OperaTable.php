<?php
namespace Unidad\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
class OperaTable
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

    public function getOpera($id)
    {
        $rowset = $this->tableGateway->select(array('idopera' => $id));
        $row = $rowset->current();
        if (!$row) {
            return false;
        }
        return $row;
    }
    public function saveOpera(Opera $opera)
    {
        $data = array(
            'idoperador'=> $opera->idoperador,
            'idunidad'=> $opera->idunidad,
            'fechainicio'=> $opera->fechainicio,
            'fechafin'=> $opera->fechafin,
            'estado'=> $opera->estado
        );

        $id = (int)$opera->idopera;
        if ($id == 0) {
            $this->tableGateway->insert($data);
            $id = $this->tableGateway->lastInsertValue;
        } else {
            if ($this->getOpera($id)) {
                $this->tableGateway->update(
                    $data, array('idopera' => $id)
                );
            } else {
                throw new \Exception('Opera no existe');
            }
        }

        return $id;
    }
    public function getOperadoresAll()
    {
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(
            array(
                'count' => new Expression('Count (DISTINCT idoperador)')
            )
        );
        $statement = $this->tableGateway->getSql()
            ->prepareStatementForSqlObject($sqlSelect);
        $resultSet = $statement->execute();

        return $this->resultToArray($resultSet)[0]['count'];
    }
    public function getOperaMonthFinish(){
        $messiguiente=date("Y-d-m H:i:s", mktime(0, 0, 0, date("m")+1, date("d"),   date("Y")));
        $actual=date("Y-d-m H:i:s");
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(
            array(
                'count' => new Expression('Count (*)')
            )
        );
        $sqlSelect->where("fechafin>= '$actual' and fechafin<='$messiguiente'");
        $statement = $this->tableGateway->getSql()
            ->prepareStatementForSqlObject($sqlSelect);
        $resultSet = $statement->execute();

        return $this->resultToArray($resultSet)[0]['count'];
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