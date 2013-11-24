<?php

/**
 * Tests_Methodlist 
 * 
 * @group App
 */
class Tests_Methodlist extends \TestCase
{
	protected $method;
	protected function setUp()
	{
		parent::setUp();
	}

	protected function tearDown()
	{
		parent::tearDown();
	}

	function test_form_returnObj()
	{
		$obj = 'fieldset';
		$data = Controller_Methodlist::_form();
		$this->assertInstanceOf($obj,$data);
	}
	function test_form_hasCSRFfield()
	{
		$obj = 'fieldset_field';
		$key = 'fuel_csrf_token';
		$data = Controller_Methodlist::_form()->field($key);
		$this->assertInstanceOf($obj,$data);
	}

	function test_sourceview()
	{
		$classname = 'Date';
		$expected = 'クラス名:'.$classname;
		$data = Controller_Methodlist::_sourceview($classname);
		$title = $data->title;
		$this->assertEquals($expected,$title);
	}
	/**
	 * @expectedException InvalidArgumentException
	 **/
	function test_sourceview_argument_null_raises_exception()
	{
		$data = Controller_Methodlist::_sourceview(NULL);
	}
}
