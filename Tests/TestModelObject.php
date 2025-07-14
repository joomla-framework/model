<?php

/**
 * @copyright  Copyright (C) 2005 - 2021 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Model\Tests;

use Joomla\Model\DatabaseModelInterface;
use Joomla\Model\DatabaseModelTrait;
use Joomla\Model\StatefulModelInterface;
use Joomla\Model\StatefulModelTrait;

class TestModelObject implements DatabaseModelInterface, StatefulModelInterface
{
    use DatabaseModelTrait,
        StatefulModelTrait;
}
