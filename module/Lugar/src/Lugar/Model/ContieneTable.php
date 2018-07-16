<?php
namespace Lugar\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
class ContieneTable
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
    public function getContiene($idlugar, $idpunto)
    {
        $rowset = $this->tableGateway->select(
            array(
                'idpunto' => $idpunto,
                'idlugar'=>$idlugar
                ));
        $row = $rowset->current();
        if (!$row) {
            return false;
        }
        return $row;
    }
    public function saveContiene(Contiene $contiene)
    {
        $data = array(
            'idlugar'=> $contiene->idlugar,
            'idpunto'=> $contiene->idpunto,
            'version'=> $contiene->version,
            'estado'=> $contiene->estado,
        );
        $id = (int)$contiene->idlugar;
        $idp = (int)$contiene->idpunto;

        if($this->getContiene($id, $idp)){
            $this->tableGateway->update(
                $data,
                array(
                    'idlugar' => $id,
                    'idpunto' => $idp,
                )
            );
        }else{
            $this->tableGateway->insert($data);
        }
        return $id;
    }
    public function fetchAllWithPlace($idlugar){
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(
            array(
                'version' => 'version'
            )
        );
        $sqlSelect
            ->join(
                array("li"=>"lugar"),
                'li.idlugar = contiene.idlugar',
                array(
                    'nombreinicio' => 'nombre',
                    'nombreiniciocompleto' => 'nombrecompleto',
                    'color' => 'color',
                )
            )
            ->join(
                array("p"=>"punto"),
                'p.idpunto = contiene.idpunto',
                array(
                    'latitud' => 'latitud',
                    'longitud' => 'longitud',
                    'orden' => 'orden',
                )
            );
        $sqlSelect->where('contiene.estado!=2 and li.idlugar='.$idlugar);
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