<?php
namespace Unidad\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
class VolqueteTable
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

    public function getVolquete($id)
    {
        $rowset = $this->tableGateway->select(array('idvolquete' => $id));
        $row = $rowset->current();
        if (!$row) {
            return false;
        }
        return $row;
    }
    public function saveVolquete(Volquete $volquete)
    {
        $data = array(
            'idvolquete'=> $volquete->idvolquete,
            'estado'=> $volquete->estado
        );
        $id = (int)$volquete->idvolquete;
        if ($id == 0) {
            throw new \Exception('Volquete  no existe');
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