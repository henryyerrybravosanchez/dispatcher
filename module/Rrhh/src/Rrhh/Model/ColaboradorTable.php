<?php
namespace Rrhh\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
class ColaboradorTable
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

    public function getColaborador($id)
    {
        $rowset = $this->tableGateway->select(array('idcolaborador' => $id));
        $row = $rowset->current();
        if (!$row) {
            return false;
        }

        return $row;
    }


	public function saveColaborador(Colaborador $colaborador)
    {
        $data = array(
            'nombre'             => $colaborador->nombres,
            'ap'             => $colaborador->ap,
            'am'             => $colaborador->am,
            'dni'             => $colaborador->dni,
            'telefono'             => $colaborador->telefono,
            'direccion'             => $colaborador->direccion,
            'user'             => $colaborador->user,
            'password'             => $colaborador->contrasena,
            'foto'             => $colaborador->foto,
            'estado'             => $colaborador->estado,
        );

        $id = (int)$colaborador->idcolaborador;
        if ($id == 0) {
            $this->tableGateway->insert($data);
            $id = $this->tableGateway->lastInsertValue;
        } else {
            if ($this->getColaborador($id)) {
                $this->tableGateway->update(
                    $data, array('idcolaborador' => $id)
                );
            } else {
                throw new \Exception('Colaborador no existe');
            }
        }


        return $id;
    }
    public function fetchAllOperador(){
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(
            array(
                'idcolaborador' => 'idcolaborador',
                'nombre' => 'nombre',
                'ap' => 'ap',
                'am' => 'am',
                'telefono' => 'telefono',
                'direccion' => 'direccion',
                'user' => 'user',
                'password' => 'password',
                'foto' => 'foto',
                'estadocolaborador' => 'estado'
            )
        );
        $sqlSelect
            ->join(
                'c_operador',
                'c_operador.idoperador = colaborador.idcolaborador',
                array(
                    'idoperador' => 'idoperador'
                )
            );

        $sqlSelect->order('colaborador.idcolaborador DESC');
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