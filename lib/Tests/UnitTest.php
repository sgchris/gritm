<?php
/**
 * implementation of a very basic unit testing class
 */


abstract class UnitTest {

	/**
	 *
	 * check the value is true
	 * @param mixed $expr
	 */
	public function assertTrue($expr) {
		if (!$expr) {
			$this->_printAssertResult("\"{$expr}\" - assertTrue failed!");
		}
	}
	
	/**
	 *
	 * check the value is false
	 * @param mixed $expr
	 */
    public function assertFalse($expr) {
		if ($expr) {
			$this->_printAssertResult("\"{$expr}\" - assertFalse failed!");
		}
	}
	
	/**
	 *
	 * check the two values are equal
	 * @param mixed $expr1
	 * @param mixed $expr2
	 */
	public function assertEquals($expr1, $expr2) {
		if ($expr1 != $expr2) {
			$this->_printAssertResult("\"{$expr1}\" not equals \"{$expr2}\"");
		}
	}
	
	/**
	 *
	 * check if $expr1 is Greater Than $expr2
	 * @param mixed $expr1
	 * @param mixed $expr2
	 */
	public function assertGt($expr1, $expr2) {
		if ($expr1 > $expr2) {
			$this->_printAssertResult("\"{$expr1}\" not greater than \"{$expr2}\"");
		}
	}

	/**
	 *
	 * check if $expr1 is Greater Than or Equal $expr2
	 * @param mixed $expr1
	 * @param mixed $expr2
	 */
	public function assertGte($expr1, $expr2) {
		if ($expr1 >= $expr2) {
			$this->_printAssertResult("\"{$expr1}\" not greater than or equal \"{$expr2}\"");
		}
	}
	
	/**
	 *
	 * check if $expr1 is Lower Than $expr2
	 * @param mixed $expr1
	 * @param mixed $expr2
	 */
	public function assertLt($expr1, $expr2) {
		if ($expr1 < $expr2) {
			$this->_printAssertResult("\"{$expr1}\" not lower than \"{$expr2}\"");
		}
	}

	/**
	 *
	 * check if $expr1 is Greater Than or Equal $expr2
	 * @param mixed $expr1
	 * @param mixed $expr2
	 */
	public function assertLte($expr1, $expr2) {
		if ($expr1 <= $expr2) {
			$this->_printAssertResult("\"{$expr1}\" not lower than or equal \"{$expr2}\"");
		}
	}

	/**
	 *
	 * check the two values are equal and have the same type
	 * @param mixed $expr1
	 * @param mixed $expr2
	 */
	public function assertEqualsStrict($expr1, $expr2) {
		if ($expr1 !== $expr2) {
			$this->_printAssertResult("\"{$expr1}\" not equals \"{$expr2}\"");
		}
	}
	
	/**
	 *
	 * execute the tests in the extending class.
	 * All testing method should start with "test" (lowercase)
	 */
	protected $errors = false;
	public function run() {
		echo '---- Starting the Test (',date('d.m.Y H:i:s'),') -----', "<br>\r\n";

		// read all methods, and execute tests
		$methods_list = get_class_methods($this);
		if (!empty($methods_list)) {
			foreach ($methods_list as $method) {
				if (preg_match('%^test%', $method)) {
					echo '<span style="color:green;">testing ', preg_replace('%^test%', '', $method), "</span><br/>\n";
					$this->$method();
				}
			}
		}

		echo '<br/><br/><hr/>';
		if ($this->errors) {
			echo '<span style="color:#C11;">ERRORS FOUND</span>';
		} else {
			echo '<span style="color:#1C1;">Test passed</span>';
		}
	}
	
	/** ************ PROTECTED SECTION *************** **/
	
	/**
	 *
	 * print assertion result
	 * @param string $message
	 */         
	protected function _printAssertResult($message, $error = true) {
		$this->errors = true;
		echo $error ? '<span style="color:#C11;">' : '<span style="color:green;">';
		echo $message;
		echo "</span><br>\n";
	}
			   
}