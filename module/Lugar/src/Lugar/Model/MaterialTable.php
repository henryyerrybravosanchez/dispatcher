<?php
namespace Lugar\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
class MaterialTable
{
    protected $tableGateway;
    protected $dbAdapter;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select('estado=1');

        return $this->resultToArray($resultSet);
    }

    public function getMaterial($id)
    {
        $rowset = $this->tableGateway->select(array('idmaterial' => $id));
        $row = $rowset->current();
        if (!$row) {
            return false;
        }
        return $row;
    }
    public function saveMaterial(Material $material)
    {
        $data = array(
            'nombre'=> $material->nombre,
            'estado'=> $material->estado,
        );
        $id = (int)$material->$material;
        if ($id == 0) {
            $this->tableGateway->insert($data);
            $id = $this->tableGateway->lastInsertValue;
        } else {
            if ($this->getMaterial($id)) {
                $this->tableGateway->update(
                    $data, array('$material' => $id)
                );
            } else {
                throw new \Exception('Material no existe');
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