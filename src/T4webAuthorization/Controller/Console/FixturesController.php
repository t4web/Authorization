<?php

namespace T4webAuthorization\Controller\Console;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;

class FixturesController extends AbstractActionController implements AdapterAwareInterface
{

    use AdapterAwareTrait;

    public function __construct(Adapter $adapter)
    {
        $this->setDbAdapter($adapter);
    }

    public function runAction()
    {
        echo "Run data fixtures" . PHP_EOL;

        $result = $this->createRootUser();

        return $result === true ? "Fixtures success completed" . PHP_EOL : '';
    }

    private function createRootUser()
    {

        $table = 'auth';
        $id = 3;
        $uname = 'root@t4web.com.ua';
        $password = '737c0b0633a8ed6f4c104824bc1221621defbff2';

        $sql = new Sql($this->adapter);
        $select = $sql->select()
            ->from($table)
            ->where(['uname' => $uname]);

        $result = $this->adapter
            ->query($sql->buildSqlString($select), Adapter::QUERY_MODE_EXECUTE)
            ->count();

        if(!empty($result)) {
            echo "Auth fixtures already exists" . PHP_EOL;
            return true;
        }

        $insert = $sql->insert($table);

        $insert->values(
            [
                'id' => $id,
                'uname' => $uname,
                'password' => $password,
            ]
        );

        try {
            $this->adapter->query($sql->buildSqlString($insert), Adapter::QUERY_MODE_EXECUTE);
        } catch (\PDOException $e) {
            echo $e->getMessage() . PHP_EOL;

            return false;
        }

        return true;

    }
}
