<?php
namespace Unidad\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
class PalaTable
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

    public function getPala($id)
    {
        $rowset = $this->tableGateway->select(array('idcargador' => $id));
        $row = $rowset->current();
        if (!$row) {
            return false;
        }
        return $row;
    }
    public function savePala(Pala $pala)
    {
        $data = array(
            'idcargador'=> $pala->idcargador,
            'estado'=> $pala->estado
        );
        $id = (int)$pala->idcargador;
        if ($id == 0) {
            throw new \Exception('Persona no existe');

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