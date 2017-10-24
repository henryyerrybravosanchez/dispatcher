<?php
namespace Lugar\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
class LugarTable
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

    public function getLugar($id)
    {
        $rowset = $this->tableGateway->select(array('idcargador' => $id));
        $row = $rowset->current();
        if (!$row) {
            return false;
        }
        return $row;
    }
    public function saveLugar(Lugar $pala)
    {
        $data = array(
            'nombrecompleto'=> $pala->nombrecompleto,
            'nombre'=> $pala->nombre,
            'latitud'=> $pala->latitud,
            'longitud'=> $pala->longitud,
            'estado'=> $pala->estado,
        );
        $id = (int)$pala->idlugar;
        if ($id == 0) {
            $this->tableGateway->insert($data);
            $id = $this->tableGateway->lastInsertValue;
        } else {
            if ($this->getLugar($id)) {
                $this->tableGateway->update(
                    $data, array('idlugar' => $id)
                );
            } else {
                throw new \Exception('Lugar no existe');
            }
        }

        return $id;
    }
    public function getLugaresAll()
    {
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(
            array(
                'count' => new Expression('Count (*)')
            )
        );
        $sqlSelect->where('tipo=1');
        $statement = $this->tableGateway->getSql()
            ->prepareStatementForSqlObject($sqlSelect);
        $resultSet = $statement->execute();

        return $this->resultToArray($resultSet)[0]['count'];
    }
    public function getMaterialesAll()
    {
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(
            array(
                'count' => new Expression('Count (*)')
            )
        );
        $sqlSelect->where('tipo=2');
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