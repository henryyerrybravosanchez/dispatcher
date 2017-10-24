<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Oficina\Model\Responsable;
use Zend\Db\Sql\Select;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;

class IndexController extends AbstractActionController
{

    public $dbAdapter;
    public $empleadoTable;
    public $responsableTable;
    public $oficinaTable;

    protected  $personaTable;
    protected  $administradorTable;
    protected  $afiliadoTable;
    protected  $clienteTable;
    protected  $cotizacionTable;
    protected  $invitacionTable;
    protected  $ordenServicioTable;
    protected  $contratoTable;
    protected  $ventaTable;
    protected  $pedidoTable;
    protected  $compraTable;
    protected  $egresoTable;

    public function indexAction()
    {
        date_default_timezone_set("America/Lima");
        return $this->redirect()->toRoute(
            'reserva', array(
                'action' => 'index'
            )
        );
    }

    private function getEmpleadoTable()
    {
        if (!$this->empleadoTable) {
            $sm = $this->getServiceLocator();
            $this->empleadoTable = $sm->get(
                'RRhh\Model\EmpleadoTable'
            );
        }
        return $this->empleadoTable;
    }


}
