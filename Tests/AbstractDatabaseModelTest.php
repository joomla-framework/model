<?php
/**
 * @copyright  Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Model\Tests;

use Joomla\Database\DatabaseInterface;
use Joomla\Model\AbstractDatabaseModel;

/**
 * Tests for the Joomla\Model\AbstractDatabaseModel class.
 *
 * @since  1.0
 */
class AbstractDatabaseModelTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var    AbstractDatabaseModel|\PHPUnit_Framework_MockObject_MockObject
	 * @since  1.0
	 */
	private $instance;

	/**
	 * Tests the __construct method.
	 *
	 * @return  void
	 *
	 * @covers  Joomla\Model\AbstractDatabaseModel::__construct
	 * @since   1.0
	 */
	public function test__construct()
	{
		$this->assertInstanceOf(DatabaseInterface::class, $this->instance->getDb());
	}

	/**
	 * Tests the setDb method.
	 *
	 * @return  void
	 *
	 * @covers  Joomla\Model\AbstractDatabaseModel::getDb
	 * @covers  Joomla\Model\AbstractDatabaseModel::setDb
	 * @since   1.0
	 */
	public function testSetDb()
	{
		$db = $this->getMockBuilder(DatabaseInterface::class)
			->getMock();

		$this->instance->setDb($db);

		$this->assertSame($db, $this->instance->getDb());
	}

	/**
	 * Setup the tests.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	protected function setUp()
	{
		parent::setUp();

		$mockDb = $this->getMockBuilder(DatabaseInterface::class)
			->getMock();

		$this->instance = $this->getMockForAbstractClass(AbstractDatabaseModel::class, [$mockDb]);
	}
}
