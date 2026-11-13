<?php

/**
 * @copyright  Copyright (C) 2005 - 2021 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Model\Tests;

use Joomla\Database\DatabaseInterface;
use Joomla\Model\DatabaseModelTrait;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Tests for \Joomla\Model\DatabaseModelTrait.
 */
class DatabaseModelTraitTest extends TestCase
{
    /**
     * @testdox  Calling getDb() without a DatabaseDriver set will throw an Exception
     *
     * @covers   Joomla\Model\DatabaseModelTrait
     */
    public function testGetDbException()
    {
        $this->expectException(\UnexpectedValueException::class);

        $object = new TestModelObject();
        $object->getDb();
    }

    #[TestDox('The exception message names the runtime class of the model')]
    public function testGetDbExceptionNamesRuntimeClass()
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage('Database driver not set in ' . TestChildModelObject::class);

        $object = new TestChildModelObject();
        $object->getDb();
    }

    /**
     * @testdox  A DatabaseDriver is set and retrieved
     *
     * @covers   Joomla\Model\DatabaseModelTrait
     */
    public function testSetAndGetDb()
    {
        $object = new TestModelObject();

        /** @var DatabaseInterface|MockObject $db */
        $db = $this->createMock(DatabaseInterface::class);

        $object->setDb($db);

        $this->assertSame($db, $object->getDb());
    }
}
