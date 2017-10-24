<?php
namespace Rrhh\Model;

use Zend\Db\TableGateway\TableGateway;
class OperadorTable
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

    public function getOperador($id)
    {
        $rowset = $this->tableGateway->select(array('idoperador' => $id));
        $row = $rowset->current();
        if (!$row) {
            return false;
        }
        return $row;
    }
    public function saveOperador(Operador $operador)
    {
        $data = array(
            'idoperador'=> $operador->idoperador,
        );
        $id = (int)$operador->idoperador;
        if ($id == 0) {
            throw new \Exception('Operador no existe');
        } else {
            $this->tableGateway->insert($data);
            $id = $this->tableGateway->lastInsertValue;
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