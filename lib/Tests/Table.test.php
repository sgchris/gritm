<?php

require_once __DIR__ . '/UnitTest.php';
require_once __DIR__ . '/../HTMLElement/Field.php';
require_once __DIR__ . '/../HTMLCollection/Table.php';

class TableTest extends UnitTest {

    public function testSetThruCall() {
        $t = new Table('Test table', 'test');
        
        try {
            // camelCase vars check
            $this->assertEquals($t->getTotalRows(), 30);

            $this->assertEqualsStrict($t->getName(), 'Test table');
            $this->assertEqualsStrict($t->getDbName(), 'test');

            $t->setTotalRows(50);
            $this->assertEquals($t->getTotalRows(), 50);
            
        } catch (Exception $e) {
            echo 'Exception:', $e->getMessage(), '<br>';
        }
    }

    public function testRecordSet() {
        $f1 = new Field('Key', 'key', 100);
        $f2 = new Field('Value', 'value', 300);
        
        $t = new Table('Test table', 'test');
        $t->add($f1)->add($f2);
        
        $this->assertGte(strlen($t->getHtml()), 5);
    }

}

$pt = new TableTest;
$pt->run();