<?php
namespace Unidad\Model;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
class EstadoMantenimientoTable
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

    public function getMantenimiento($id)
    {
        $rowset = $this->tableGateway->select(array('idestado' => $id));
        $row = $rowset->current();
        if (!$row) {
            return false;
        }
        return $row;
    }
    public function saveMantenimiento(EstadoMantenimiento $mantenimiento)
    {
        $data = array(
            'idunidad'=> $mantenimiento->idunidad,
            'idoperador'=> $mantenimiento->idoperador,
            'tipo'=> $mantenimiento->tipo,
            'fechainicio'=>$mantenimiento->fechainicio,
            'fechafin'=> $mantenimiento->fechafin,
            'observacioningreso'=> $mantenimiento->observacioningreso,
            'observacionsalida'=> $mantenimiento->observacionsalida,
            'estado'=> $mantenimiento->estado,
        );

        $id = (int)$mantenimiento->idestado;
        if ($id == 0) {
            $this->tableGateway->insert($data);
            $id = $this->tableGateway->lastInsertValue;
        } else {
            if ($this->getMantenimiento($id)) {
                $this->tableGateway->update(
                    $data, array('idestado' => $id)
                );
            } else {
                throw new \Exception('Mantenimiento no existe');
            }
        }
        return $id;
    }
    public function getMantenimientoActivos()
    {
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(
            array(
                'idestado'=>'idestado',
                'idunidad'=>'idunidad',
                'fechainicio'=>'fechainicio',
                'fechafin'=>'fechafin',
                'idoperador'=>'idoperador',
                'tipo'=>'tipo',
                'observacioningreso'=>'observacioningreso',
                'observacionsalida'=>'observacionsalida',
                'estado'=>'estado',
            )
        );
        $sqlSelect
            ->join(
                'unidad',
                'unidad.idunidad = estado.idunidad',
                array(
                    'placa'=>'placa'
                )
            )->join(
                'colaborador',
                'colaborador.idcolaborador= estado.idoperador',
                array(
                    'nombre'=>'nombre',
                    'ap'=>'ap',
                    'am'=>'am'
                )
            );
        $sqlSelect->where("estado.estado!=2 and estado.estado!=4 and estado.tipo='7'");
        $sqlSelect->order(
            'fechainicio ASC'
        );
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