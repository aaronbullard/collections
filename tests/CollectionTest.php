<?php namespace Aaronbullard\Collections;

use InvalidArgumentException;

class MyClass {
	public $number;

	public function __construct($number)
	{
		$this->number = $number;
	}
}

class NotMyClass {}

class MyClassCollection extends BaseCollection {}

class BaseCollectionTest extends \PHPUnit_Framework_TestCase {

	protected function createMyClasses($count)
	{
		$classes = [];

		while($count--){
			$classes[$count] = new MyClass($count);
		}

		return $classes;
	}

	public function testAccessingElement()
	{
		$collection = new MyClassCollection($this->createMyClasses(3));
		$this->assertInstanceOf(MyClass::class, $collection[0]);
	}


	public function testCountingElementsInArray()
	{
		$collection = new MyClassCollection($this->createMyClasses(5));
		$this->assertEquals(5, count($collection));
	}

	public function testAddingAnInvalidObjectWithinConstructorToCollection()
	{
		$this->setExpectedException(
			InvalidArgumentException::class,
			"Collection can only accept objects of type Aaronbullard\Collections\MyClass"
		);
		$collection = new MyClassCollection([
			new NotMyClass,
			new NotMyClass
		]);
	}


	public function testPushingAnInvalidObject()
	{
		$collection = new MyClassCollection($this->createMyClasses(3));
		$this->setExpectedException(
			InvalidArgumentException::class,
			"Collection can only accept objects of type Aaronbullard\Collections\MyClass"
		);
		$collection[] = new NotMyClass;
	}

	public function testLooping()
	{
		$collection = new MyClassCollection($this->createMyClasses(3));

		foreach($collection as $item){
			$this->assertInstanceOf(MyClass::class, $item);
		}
	}

	public function testArrayAccess()
	{
		$collection = new MyClassCollection($this->createMyClasses(3));

		$this->assertEquals(2, $collection[2]->number);
	}

}
