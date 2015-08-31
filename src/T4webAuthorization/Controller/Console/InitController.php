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

        $result = $this->createTable();

        return $result === true ? "Success completed" . PHP_EOL : '';
    }

    private function createTable()
    {
        $table = 'auth';

        $table = new Ddl\CreateTable($table);

        $table->addColumn(new Column\Integer('id', false, null, ['autoincrement' => true]));
        $table->addColumn(new Column\Varchar('uname', 50));
        $table->addColumn(new Column\Varchar('password', 255));

        $table->addConstraint(new Constraint\PrimaryKey('id'));
        $table->addConstraint(new Constraint\UniqueKey('uname'));

        try {
            $sql = new Sql($this->adapter);

            $this->adapter->query($sql->buildSqlString($table), Adapter::QUERY_MODE_EXECUTE);
        } catch (\PDOException $e) {
            echo $e->getMessage() . PHP_EOL;

            return false;
        }

        return true;
    }
}
