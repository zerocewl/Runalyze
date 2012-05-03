<?php

require_once dirname(__FILE__) . '/../../inc/system/class.Validator.php';

/**
 * Test class for Validator.
 * Generated by PHPUnit on 2012-03-02 at 20:03:36.
 */
class ValidatorTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var Validator
	 */
	protected $object;

	/**
	 * @covers Validator::dateToTimestamp
	 */
	public function testDateToTimestamp() {
		$this->assertEquals(mktime(0,0,0,1,1,2000), Validator::dateToTimestamp('1.1.2000'));
		$this->assertEquals(mktime(0,0,0,7,1,2000), Validator::dateToTimestamp('1.7.2000'));
		$this->assertEquals(mktime(0,0,0,12,31,2012), Validator::dateToTimestamp('31.12.2012'));
		$this->assertEquals(mktime(0,0,0,9,13,date('Y')), Validator::dateToTimestamp('13.9'));

		$this->assertEquals(0, Validator::dateToTimestamp(''));
		$this->assertEquals(0, Validator::dateToTimestamp('17'));
		$this->assertEquals(0, Validator::dateToTimestamp('1.1.2000.1'));

		$this->assertEquals(time(), Validator::dateToTimestamp('', time()));
	}

	/**
	 * @covers Validator::isInRange
	 */
	public function testIsInRange() {
		$this->assertEquals(false, Validator::isInRange(0,100, -1));
		$this->assertEquals(true, Validator::isInRange(0,100, 0));
		$this->assertEquals(true, Validator::isInRange(0,100, 57));
		$this->assertEquals(true, Validator::isInRange(0,100, 100));
		$this->assertEquals(false, Validator::isInRange(0,100, 101));
	}

	/**
	 * @covers Validator::isClose
	 */
	public function testIsClose() {
		$this->assertEquals(true, Validator::isClose(1, 1));
		$this->assertEquals(true, Validator::isClose(2, 1, 100));
		$this->assertEquals(false, Validator::isClose(2, 1));
		$this->assertEquals(true, Validator::isClose(101, 100));
		$this->assertEquals(false, Validator::isClose(101.01, 100, 1));
		$this->assertEquals(false, Validator::isClose(101, 100, 0.9));
		$this->assertEquals(true, Validator::isClose(99, 100));
	}

}

?>