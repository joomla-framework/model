<?php

/**
 * @copyright  Copyright (C) 2005 - 2021 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Model\Tests;

use Joomla\Database\DatabaseInterface;
use Joomla\Model\DatabaseModelInterface;
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

    #[TestDox('The interface declares the typed getter and setter')]
    public function testInterfaceDeclaresTypedAccessors()
    {
        $interface = new \ReflectionClass(DatabaseModelInterface::class);

        $this->assertSame(DatabaseInterface::class, (string) $interface->getMethod('getDb')->getReturnType());
        $this->assertTrue($interface->hasMethod('setDb'), 'setDb() is declared on the interface');
        $this->assertSame(DatabaseInterface::class, (string) $interface->getMethod('setDb')->getParameters()[0]->getType());
        $this->assertSame('void', (string) $interface->getMethod('setDb')->getReturnType());
    }

    #[TestDox('The driver is injected through the interface')]
    public function testSetDbThroughInterface()
    {
        $model = $this->createModel();
        $value = $this->createStub(DatabaseInterface::class);

        $model->setDb($value);

        $this->assertSame($value, $model->getDb());
    }

    private function createModel(): DatabaseModelInterface
    {
        return new TestModelObject();
    }
}
