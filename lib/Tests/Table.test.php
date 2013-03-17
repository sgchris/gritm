<?php

require_once __DIR__ . '/UnitTest.php';
require_once __DIR__ . '/../HTMLElement/Field/Text.php';
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
        // create test fields
        $f1 = new Field_Text('Key', 'key', 100);
        $f2 = new Field_Text('Value', 'value', 300);

        // create the table
        $t = new Table('Test table', 'test');
        $t->add($f1)->add($f2);

        // check that the getHtml returned value
        $this->assertGt(strlen($t->getHtml()), 0);
        
        // check that the table starts with a header
        $this->assertTrue(preg_match('%^<h\d+%i', $t->getHtml()));
    }

    public function testTableHtml() {
        // create test fields
        $f1 = new Field_Text('Key', 'key', 100);
        $f2 = new Field_Text('Value', 'value', 300);

        // create the table
        $t = new Table('Test table', 'test');
        $t->add($f1)->add($f2);

        // check that the getHtml returned value
        echo $t->getHtml();
    }

}

$pt = new TableTest;
$pt->run();