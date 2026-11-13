<?php

/**
 * @copyright  Copyright (C) 2005 - 2021 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Model\Tests;

use Joomla\Model\StatefulModelInterface;
use Joomla\Model\StatefulModelTrait;
use Joomla\Registry\Registry;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Tests for \Joomla\Model\StatefulModelTrait.
 */
class StatefulModelTraitTest extends TestCase
{
    /**
     * @testdox  Calling getState() without a state set will throw an Exception
     *
     * @covers   Joomla\Model\StatefulModelTrait
     */
    public function testGetStateException()
    {
        $this->expectException(\UnexpectedValueException::class);

        $object = new TestModelObject();
        $object->getState();
    }

    /**
     * @testdox  A Registry representing the state is set and retrieved
     *
     * @covers   Joomla\Model\StatefulModelTrait
     */
    public function testSetAndgetState()
    {
        $object = new TestModelObject();

        /** @var Registry|MockObject $state */
        $state = $this->createMock(Registry::class);

        $object->setState($state);

        $this->assertSame($state, $object->getState());
    }

    #[TestDox('The interface declares the typed getter and setter')]
    public function testInterfaceDeclaresTypedAccessors()
    {
        $interface = new \ReflectionClass(StatefulModelInterface::class);

        $this->assertSame(Registry::class, (string) $interface->getMethod('getState')->getReturnType());
        $this->assertTrue($interface->hasMethod('setState'), 'setState() is declared on the interface');
        $this->assertSame(Registry::class, (string) $interface->getMethod('setState')->getParameters()[0]->getType());
        $this->assertSame('void', (string) $interface->getMethod('setState')->getReturnType());
    }

    #[TestDox('The state is injected through the interface')]
    public function testSetStateThroughInterface()
    {
        $model = $this->createModel();
        $value = $this->createStub(Registry::class);

        $model->setState($value);

        $this->assertSame($value, $model->getState());
    }

    private function createModel(): StatefulModelInterface
    {
        return new TestModelObject();
    }
}
