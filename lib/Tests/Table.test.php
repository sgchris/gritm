<?php

require_once __DIR__.'/UnitTest.php';
require_once __DIR__.'/../HTMLCollection/Table.php';

class TableTest extends UnitTest {

	public function testSetThruCall() {
		$t = new Table;

		try {
			// camelCase vars check
			$this->assertEquals($t->getTotalRows(), 30);

			$this->assertEqualsStrict($t->getName(), null);

			$t->setTotalRows(50);
			$this->assertEquals($t->getTotalRows(), 50);

		} catch (Exception $e) {
			echo 'Exception:', $e->getMessage(), '<br>';
		}
	}

}


$pt = new TableTest;
$pt->run();