<?php namespace Aaronbullard\Collections;

use Laracasts\TestDummy\Factory as TestDummy;

class RoleCollection extends BaseCollection {
	protected static $type = 'Viimed\\Roles\\Role';
}

class TestCollection extends BaseCollection {}

class BaseCollectionTest extends \Codeception\TestCase\Test {
   /**
	* @var \UnitTester
	*/
	protected $tester;
	protected $roles;
	protected static $type = 'Viimed\\Roles\\Role';
	protected function _before()
	{
		$this->roles = [
			TestDummy::build('Viimed\\Roles\\Role'),
			TestDummy::build('Viimed\\Roles\\Role'),
			TestDummy::build('Viimed\\Roles\\Role'),
			TestDummy::build('Viimed\\Roles\\Role')
		];
	}
	
	public function testAccessingElement()
	{
		$collection = new RoleCollection( $this->roles );
		$this->assertInstanceOf(static::$type, $collection[0]);
	}

	public function testCountingElementsInArray()
	{
		$collection = new RoleCollection( $this->roles );
		$this->assertEquals( count($collection), count($this->roles));
	}

	public function testAddingAnInvalidObjectWithinConstructorToCollection()
	{
		$this->setExpectedException('Viimed\Core\Exceptions\InvalidArgumentException', "Collection can only accept objects of type Viimed\Roles\Role");
		$this->roles[] = TestDummy::build('Viimed\\Users\\User');
		$collection = new RoleCollection( $this->roles );
	}

	public function testResolvingTypeFromReflection()
	{
		$this->setExpectedException('Viimed\Core\Exceptions\InvalidArgumentException', "Collection can only accept objects of type Viimed\Framework\Models\Test");
		$collection = new TestCollection( $this->roles );
	}

	public function testPushingAnInvalidObject()
	{
		$collection = new RoleCollection( $this->roles );
		$this->setExpectedException('Viimed\Core\Exceptions\InvalidArgumentException', "Collection can only accept objects of type Viimed\Roles\Role");
		$user = TestDummy::build('Viimed\\Users\\User');
		$collection[] = $user;
	}

	public function testLooping()
	{
		$collection = new RoleCollection( $this->roles );
		$count = 0;
		$total = count($collection);
		foreach($collection as $item)
		{
			$count++;
		}
		$this->assertEquals($count, $total);
	}
}