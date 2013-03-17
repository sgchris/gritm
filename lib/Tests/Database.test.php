<?php

require_once __DIR__.'/UnitTest.php';
require_once __DIR__.'/../Tools/Database.php';

class DatabaseTest extends UnitTest {

	public function testDatabaseInstance() {
		try {
			$db1 = Database::get();
			$db2 = Database::get();
		} catch (Exception $e) {
			$this->assertFalse($e->getMessage());
			return;
		}

		// compare the two items strictly
		$this->assertEqualsStrict($db1, $db2);

		// compare the two items strictly
		$this->assertEqualsStrict(var_export($db1, true), var_export($db2, true));
	}

}

$dt = new DatabaseTest;
$dt->run();