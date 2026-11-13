<?php

/**
 * @copyright  Copyright (C) 2005 - 2021 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Model\Tests;

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

    #[TestDox('The exception message names the runtime class of the model')]
    public function testGetStateExceptionNamesRuntimeClass()
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage('State not set in ' . TestChildModelObject::class);

        $object = new TestChildModelObject();
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
}
