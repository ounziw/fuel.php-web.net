<?php

/**
 * dummyclass 
 * Used for Tests
 */
class dummyclass
{
	function outhtml()
	{
		return '<b>hello</b>';
	}
	function outtext()
	{
		return 'hello';
	}
}

class dummysub extends dummyclass
{
	function outnull()
	{
		return "";
	}
}
/**
 *
 * @group App
 */
class Tests_SourceView extends \TestCase
{
	protected $reflect;
	protected $sub;

	public function setUp()
	{
		$this->reflect = new SourceView('dummyclass');
		$this->sub = new SourceView('dummysub');
	}

	public function test_getMethodStartEnd()
	{
		$expected = array(
			array(
				'method'=>'outhtml',
				'start'=>9,
				'end'=>12
			),
			array(
				'method'=>'outtext',
				'start'=>13,
				'end'=>16
			),
		);
		$data = $this->reflect->getMethodStartEnd();
		$this->assertEquals($expected,$data);
	}
	public function test_subgetMethodStartEnd()
	{
		$expected = array(
			array(
				'method'=>'outnull',
				'start'=>21,
				'end'=>24
			),
		);
		$data = $this->sub->getMethodStartEnd();
		$this->assertEquals($expected,$data);
	}
	public function test_subInherited_methods()
	{
		$expected = array(
			array(
				'method'=>'outhtml',
				'class'=>'dummyclass',
			),
			array(
				'method'=>'outtext',
				'class'=>'dummyclass',
			),
		);
		$data = $this->sub->getInheritedMethods();
		$this->assertEquals($expected,$data);
	}
	public function test_outData_escape()
	{
		$expected = array(
			7 =>'class dummyclass
',
			8 =>'{
',
					9 =>'	function outhtml()
',
					10 =>	'	{
',
							11 =>'		return &#039;&lt;b&gt;hello&lt;/b&gt;&#039;;
',
							12 =>'	}
',
							13 =>'	function outtext()
',
							14 =>'	{
',
									15 =>'		return &#039;hello&#039;;
',
									16 =>'	}
',
									17 =>'}
',
		);
		$data = $this->reflect->outData();
		$this->assertEquals($expected,$data);
	}
	public function test_outData_noescape()
	{
		$expected = array(
			7 =>'class dummyclass
',
			8 =>'{
',
					9 =>'	function outhtml()
',
					10 =>	'	{
',
							11 =>"		return '<b>hello</b>';
",
							12 =>'	}
',
							13 =>'	function outtext()
',
							14 =>'	{
',
									15 =>"		return 'hello';
",
									16 =>'	}
',
									17 =>'}
',
		);


		$data = $this->reflect->outData('not-escape');
		$this->assertEquals($expected,$data);
	}
	/**
	 * @expectedException RuntimeException
	 */
	public function test_createFileData_NotFileExistsException()
	{
		new Sourceview('Reflectionclass');
	}
}
