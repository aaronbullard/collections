<?php namespace Aaronbullard\Collections;

use ArrayAccess, Countable, Iterator;
use InvalidArgumentException;

abstract class BaseCollection implements ArrayAccess, Countable, Iterator {

	protected static $type;
	protected $resolvedType;
	protected $container = [];

	public function __construct(array $items)
	{
		$this->setDefaultType();
		$this->validateItems( $items );
		$this->container = $items;
	}

	protected function validateItems(array $items)
	{
		foreach( $items as $item )
		{
			$this->validateItem($item);
		}
	}
	
	protected function setDefaultType()
	{
		// Set default type
		if( is_null(static::$type))
		{
			$self = get_class($this);
			$this->resolvedType = substr($self, 0, strlen($self) - strlen('Collection'));
		}else{
			$this->resolvedType = static::$type;
		}
	}

	protected function validateItem($item)
	{
		if( is_object($item) && get_class($item) === $this->resolvedType )
		{
			return NULL;
		}
		if( gettype($item) === $this->resolvedType)
		{
			return NULL;
		}
		throw new InvalidArgumentException("Collection can only accept objects of type " . $this->resolvedType);
	}

	// ArrayAccess
	public function offsetSet($offset, $value)
	{
		$this->validateItem( $value );
		if (is_null($offset))
		{
			$this->container[] = $value;
		} 
		else
		{
			$this->container[$offset] = $value;
		}
	}

	public function offsetExists($offset)
	{
		return isset($this->container[$offset]);
	}

	public function offsetUnset($offset) 
	{
		unset($this->container[$offset]);
	}

	public function offsetGet($offset)
	{
		return isset($this->container[$offset]) ? $this->container[$offset] : null;
	}

	// Countable
	public function count()
	{
		return count( $this->container );
	}

	// Iterator
	public function rewind()
	{
		return reset( $this->container );
	}

	public function current()
	{
		return current( $this->container );
	}

	public function key()
	{
		return key( $this->container );
	}

	public function next()
	{
		return next( $this->container );
	}
	\
	public function valid()
	{
		return (key( $this->container ) !== NULL);
	}
}