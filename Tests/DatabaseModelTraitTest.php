<?php
/**
 * @copyright  Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Model\Tests;

/**
 * Tests for \Joomla\Model\DatabaseModelTrait.
 */
class DatabaseModelTraitTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @testdox  Calling getDb() without a DatabaseDriver set will throw an Exception
	 *
	 * @covers              Joomla\Model\DatabaseModelTraitTest::getDb
	 * @expectedException   \UnexpectedValueException
	 */
	public function testGetDbException()
	{
		/** @var \Joomla\Model\DatabaseModelTrait $object */
		$object = $this->getObjectForTrait('\\Joomla\\Model\\DatabaseModelTrait');
		$object->getDb();
	}

	/**
	 * @testdox  A DatabaseDriver is set and retrieved
	 *
	 * @covers    Joomla\Model\DatabaseModelTraitTest::getDb
	 * @covers    Joomla\Model\DatabaseModelTraitTest::setDb
	 */
	public function testSetAndGetDb()
	{
		/** @var \Joomla\Model\DatabaseModelTrait $object */
		$object = $this->getObjectForTrait('\\Joomla\\Model\\DatabaseModelTrait');

		/** @var \Joomla\Database\DatabaseInterface $db */
		$db = $this->getMockBuilder('\\Joomla\\Database\\DatabaseInterface')
			->disableOriginalConstructor()
			->getMock();

		$object->setDb($db);

		$this->assertSame($db, $object->getDb());
	}
}
