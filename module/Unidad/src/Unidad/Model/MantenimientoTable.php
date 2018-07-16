<?php
namespace Unidad\Model;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
class MantenimientoTable
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
        $rowset = $this->tableGateway->select(array('idmantenimiento' => $id));
        $row = $rowset->current();
        if (!$row) {
            return false;
        }
        return $row;
    }
    public function saveMantenimiento(Mantenimiento $mantenimiento)
    {
        $data = array(
            'numero'=> $mantenimiento->idunidad,
            'fechainicio'=> $mantenimiento->fechaingreso,
            'fechasalida'=> $mantenimiento->fechasalida,
            'idconductor'=> $mantenimiento->idconductor,
            'tipo'=> $mantenimiento->tipo,
            'observacioningreso'=> $mantenimiento->observacioningreso,
            'observacionsalida'=> $mantenimiento->observacionsalida,
            'estado'=> $mantenimiento->estado,
        );

        $id = (int)$mantenimiento->idmantenimiento;
        if ($id == 0) {
            $this->tableGateway->insert($data);
            $id = $this->tableGateway->lastInsertValue;
        } else {
            if ($this->getMantenimiento($id)) {
                $this->tableGateway->update(
                    $data, array('idmantenimiento' => $id)
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
                'idmantenimiento'=>'idmantenimiento',
                'idunidad'=>'idunidad',
                'fechaingreso'=>'fechaingreso',
                'fechasalida'=>'fechasalida',
                'idconductor'=>'idconductor',
                'tipo'=>'tipo',
                'observacioningreso'=>'observacioningreso',
                'observacionsalida'=>'observacionsalida',
                'estado'=>'estado',
            )
        );
        $sqlSelect
            ->join(
                'unidad',
                'unidad.idunidad = mantenimiento.idunidad',
                array(
                    'placa'=>'placa'
                )
            )->join(
                'colaborador',
                'colaborador.idcolaborador= mantenimiento.idconductor',
                array(
                    'nombre'=>'nombre',
                    'ap'=>'ap',
                    'am'=>'am'
                )
            );
        $sqlSelect->where('mantenimiento.estado=1 or mantenimiento.estado=3 or mantenimiento.estado=4');
        $sqlSelect->order(
            'fechaingreso ASC'
        );
        $statement = $this->tableGateway->getSql()
            ->prepareStatementForSqlObject($sqlSelect);
        $resultSet = $statement->execute();
        return $this->resultToArray($resultSet);
    }

    public function getCantidadCargasFechasUnidadesP($fechadesde, $fechahasta, $idunidad)
    {

        if($idunidad>0)
            $where="carga.fechainicio>= '$fechadesde' and carga.fechainicio<='$fechahasta' and carga.estado=2 and servicio_carga.idcargador=$idunidad";
        else
            $where="carga.fechainicio>= '$fechadesde' and carga.fechainicio<='$fechahasta' and carga.estado=2";

        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(
            array(
                'placa' => new Expression('unidad.placa'),
                'anio' => new Expression('year(carga.fechainicio)'),
                'mes' => new Expression('month(carga.fechainicio)'),
                'dia' => new Expression('day(carga.fechainicio)'),
                'cantidad'=>new Expression('Count (year(carga.fechainicio))')
            )
        );
        $sqlSelect
            ->join(
                'carga_volquete',
                'carga_volquete.idcargavolquete = carga.idcargavolquete',
                array(
                )
            )->join(
                'servicio_carga',
                'servicio_carga.idservicio = carga_volquete.idservicio',
                array(
                )
            )->join(
                'unidad',
                'unidad.idunidad = servicio_carga.idcargador',
                array(
                    'placa'=>'placa'
                )
            );
        $sqlSelect->where($where);
        $sqlSelect->group(
            new Expression('year(carga.fechainicio)')
        );
        $sqlSelect->group(
            new Expression('month(carga.fechainicio)')
        );
        $sqlSelect->group(
            new Expression('day(carga.fechainicio)')
        );
        $sqlSelect->group(
            new Expression('unidad.placa')
        );
        $statement = $this->tableGateway->getSql()
            ->prepareStatementForSqlObject($sqlSelect);
        $resultSet = $statement->execute();
        return $this->resultToArray($resultSet);
    }

    public function getCantidadCargasFechasUnidadesV($fechadesde, $fechahasta, $idunidad)
    {
        if($idunidad>0)
            $where="carga.fechainicio>= '$fechadesde' and carga.fechainicio<='$fechahasta' and carga.estado=2 and carga_volquete.idvolquete=$idunidad";
        else
            $where="carga.fechainicio>= '$fechadesde' and carga.fechainicio<='$fechahasta' and carga.estado=2";

        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(
            array(
                'placa' => new Expression('unidad.placa'),
                'anio' => new Expression('year(carga.fechainicio)'),
                'mes' => new Expression('month(carga.fechainicio)'),
                'dia' => new Expression('day(carga.fechainicio)'),
                'cantidad'=>new Expression('Count (year(carga.fechainicio))')
            )
        );
        $sqlSelect
            ->join(
                'carga_volquete',
                'carga_volquete.idcargavolquete = carga.idcargavolquete',
                array(
                )
            )->join(
                'unidad',
                'unidad.idunidad = carga_volquete.idvolquete',
                array(
                    'placa'=>'placa'
                )
            );
        $sqlSelect->where($where);
        $sqlSelect->group(
            new Expression('year(carga.fechainicio)')
        );
        $sqlSelect->group(
            new Expression('month(carga.fechainicio)')
        );

        $sqlSelect->group(
            new Expression('day(carga.fechainicio)')
        );

        $sqlSelect->group(
            new Expression('unidad.placa')
        );
        $statement = $this->tableGateway->getSql()
            ->prepareStatementForSqlObject($sqlSelect);
        $resultSet = $statement->execute();
        return $this->resultToArray($resultSet);
    }
    public function getCantidadCargasFechasUnidadesVServicio($idservicio)
    {

        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(
            array(
                'anio' => new Expression('year(carga.fechainicio)'),
                'mes' => new Expression('month(carga.fechainicio)'),
                'dia' => new Expression('day(carga.fechainicio)'),
                'cantidad'=>new Expression('Count (year(carga.fechainicio))')
            )
        );
        $sqlSelect
            ->join(
                'carga_volquete',
                'carga_volquete.idcargavolquete = carga.idcargavolquete',
                array(
                )
            )->join(
                'unidad',
                'unidad.idunidad = carga_volquete.idvolquete',
                array(
                    'placa'=>'placa'
                )
            )->join(
                'servicio_carga',
                'servicio_carga.idservicio = carga_volquete.idservicio',
                array(
                )
            );
        $sqlSelect->where(
            array('servicio_carga.idservicio'=>$idservicio)
        );
        $sqlSelect->group(
            new Expression('year(carga.fechainicio)')
        );
        $sqlSelect->group(
            new Expression('month(carga.fechainicio)')
        );

        $sqlSelect->group(
            new Expression('day(carga.fechainicio)')
        );

        $sqlSelect->group(
            new Expression('unidad.placa')
        );
        $statement = $this->tableGateway->getSql()
            ->prepareStatementForSqlObject($sqlSelect);
        $resultSet = $statement->execute();
        return $this->resultToArray($resultSet);
    }

    public function getCantidadCargasMateriales($fechadesde, $fechahasta)
    {
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(
            array(
                'cantidad' => new Expression('count (servicio_carga.idmaterial)'),
            )
        );
        $sqlSelect
            ->join(
                'carga_volquete',
                'carga_volquete.idcargavolquete = carga.idcargavolquete',
                array(
                )
            )->join(
                'servicio_carga',
                'servicio_carga.idservicio = carga_volquete.idservicio',
                array(
                )
            )->join(
                'material',
                'servicio_carga.idmaterial = material.idmaterial',
                array(
                    'idmaterial' =>'idmaterial',
                    'nombre' =>'nombre'
                )
            );
        $sqlSelect->where("carga.fechainicio>= '$fechadesde' and carga.fechainicio<='$fechahasta' and carga.estado=2");
        $sqlSelect->group(
            new Expression('servicio_carga.idmaterial')
        );
        $sqlSelect->group(
            new Expression('material.nombre')
        );
        $sqlSelect->group(
            new Expression('material.idmaterial')
        );
        $statement = $this->tableGateway->getSql()
            ->prepareStatementForSqlObject($sqlSelect);
        $resultSet = $statement->execute();
        return $this->resultToArray($resultSet);
    }

    public function getCantidadCargasLugares($fechadesde, $fechahasta)
    {
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(
            array(
                'cantidad' => new Expression('count (servicio_carga.idlugarorigen)'),
            )
        );
        $sqlSelect
            ->join(
                'carga_volquete',
                'carga_volquete.idcargavolquete = carga.idcargavolquete',
                array(
                )
            )->join(
                'servicio_carga',
                'servicio_carga.idservicio = carga_volquete.idservicio',
                array(
                )
            )->join(
                'lugar',
                'servicio_carga.idlugarorigen = lugar.idlugar',
                array(
                    'idlugar' =>'idlugar',
                    'nombre' =>'nombre'
                )
            );
        $sqlSelect->where("carga.fechainicio>= '$fechadesde' and carga.fechainicio<='$fechahasta' and carga.estado=2");
        $sqlSelect->group(
            new Expression('servicio_carga.idlugarorigen')
        );
        $sqlSelect->group(
            new Expression('lugar.nombre')
        );
        $sqlSelect->group(
            new Expression('lugar.idlugar')
        );
        $statement = $this->tableGateway->getSql()
            ->prepareStatementForSqlObject($sqlSelect);
        $resultSet = $statement->execute();
        return $this->resultToArray($resultSet);
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