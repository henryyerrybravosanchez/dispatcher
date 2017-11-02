<?php
namespace Unidad\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
class ServicioCargaTable
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

    public function saveServicioCarga(ServicioCarga $unidad)
    {
        $data = array(
            'idmaterial'    => $unidad->idmaterial,
            'idlugarorigen' => $unidad->idlugarorigen,
            'idcargador'    => $unidad->idcargador,
            'fechafin'      => $unidad->fechafin,
            'fechainicio'   => $unidad->fechainicio,
            'estado'        => $unidad->estado,
        );
        $id = (int)$unidad->idservicio;
        if ($id == 0) {
            $this->tableGateway->insert($data);
            $id = $this->tableGateway->lastInsertValue;
        } else {
            if ($this->getServicioCarga($id)) {
                $this->tableGateway->update(
                    $data, array('idservicio' => $id)
                );
            } else {
                throw new \Exception('Servicio no existe');
            }
        }
        return $id;
    }

    public function getServiciosPala($idpala)
    {
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(
            array(
                'idservicio' => 'idservicio',
                'idcargador' => 'idcargador',
                'idlugarorigen' => 'idlugarorigen',
                'idmaterial' => 'idmaterial',
                'fechainicio' => 'fechainicio',
                'fechafin' => 'fechafin',
                'estado' => 'estado',
            )
        );
        $sqlSelect->where(
            array(
                'idcargador' => $idpala,
            )
        );
        $statement = $this->tableGateway->getSql()
            ->prepareStatementForSqlObject($sqlSelect);
        $resultSet = $statement->execute();

        return $this->resultToArray($resultSet);
    }

    public function getServicioCarga($id)
    {
        $rowset = $this->tableGateway->select(array('idservicio' => $id));
        $row = $rowset->current();
        if (!$row) {
            return false;
        }
        return $row;
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