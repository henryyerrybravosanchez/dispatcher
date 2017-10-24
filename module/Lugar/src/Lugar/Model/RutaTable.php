<?php
namespace Lugar\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
class RutaTable
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

    public function getRuta($id)
    {
        $rowset = $this->tableGateway->select(array('idruta' => $id));
        $row = $rowset->current();
        if (!$row) {
            return false;
        }
        return $row;
    }
    public function saveRuta(Ruta $ruta)
    {
        $data = array(
            'idLugarInicio'=> $ruta->idLugarInicio,
            'idLugarFinal'=> $ruta->idLugarFinal,
            'color'=> $ruta->color,
            'estado'=> $ruta->estado,
        );
        $id = (int)$ruta->idruta;
        if ($id == 0) {
            $this->tableGateway->insert($data);
            $id = $this->tableGateway->lastInsertValue;
        } else {
            if ($this->getRuta($id)) {
                $this->tableGateway->update(
                    $data, array('idruta' => $id)
                );
            } else {
                throw new \Exception('Ruta no existe');
            }
        }

        return $id;
    }

    public function getRutasAll()
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
    public function fetchAllWithPlace(){
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(
            array(
                'idruta' => 'idruta',
                'idLugarInicio' => 'idLugarInicio',
                'idLugarFinal' => 'idLugarFinal',
                'color' => 'color',
                'estado' => 'estado',
            )
        );
        $sqlSelect
            ->join(
                array("li"=>"lugar"),
                'li.idlugar = ruta.idLugarInicio',
                array(
                    'nombreinicio' => 'nombre',
                    'nombreiniciocompleto' => 'nombrecompleto',
                    'latitudinicio' => 'latitud',
                    'longitudinicio' => 'longitud',
                )
            )
            ->join(
                array("lf"=>"lugar"),
                'lf.idlugar = ruta.idLugarFinal',
                array(
                    'nombrefinal' => 'nombre',
                    'nombrefinalcompleto' => 'nombrecompleto',
                    'latitudfinal' => 'latitud',
                    'longitudfinal' => 'longitud',
                )
            );

        $sqlSelect->order('ruta.idruta DESC');
        $statement = $this->tableGateway->getSql()
            ->prepareStatementForSqlObject($sqlSelect);
        $resultSet = $statement->execute();

        return $this->resultToArray($resultSet);
    }

    public function fetchAllPoints($idruta){
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(
            array(
                'idruta' => 'idruta',
                'idLugarInicio' => 'idLugarInicio',
                'idLugarFinal' => 'idLugarFinal',
                'color' => 'color',
                'estado' => 'estado',
            )
        );
        $sqlSelect
            ->join(
                array("p"=>"punto"),
                'p.idruta = ruta.idruta',
                array(
                    'latitud' => 'latitud',
                    'longitud' => 'longitud',
                    'orden' => 'orden',
                )
            );

        $sqlSelect->where(array('p.idruta='.$idruta.' and  p.estado=1'));
        $sqlSelect->order('p.orden ASC');
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