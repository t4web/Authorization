<?php

namespace T4webAuthorization\Controller\Console;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\Sql\Ddl;
use Zend\Db\Sql\Ddl\Column;
use Zend\Db\Sql\Ddl\Constraint;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;

class InitController extends AbstractActionController implements AdapterAwareInterface
{

    use AdapterAwareTrait;

    public function __construct(Adapter $adapter)
    {
        $this->setDbAdapter($adapter);
    }

    public function runAction()
    {
        echo "Create table" . PHP_EOL;

        $message = "Success completed" . PHP_EOL;

        try {
            $this->createAuthTable();
        } catch (\PDOException $e) {
            $message .= $e->getMessage() . PHP_EOL;
        }

        return $message;
    }

    private function createAuthTable()
    {
        $table = 'auth';

        $table = new Ddl\CreateTable($table);

        $table->addColumn(new Column\Integer('id', false, null, ['autoincrement' => true]));
        $table->addColumn(new Column\Varchar('uname', 50));
        $table->addColumn(new Column\Varchar('password', 255));

        $table->addConstraint(new Constraint\PrimaryKey('id'));
        $table->addConstraint(new Constraint\UniqueKey('uname'));

        $sql = new Sql($this->adapter);

        $this->adapter->query($sql->buildSqlString($table), Adapter::QUERY_MODE_EXECUTE);
    }
}
