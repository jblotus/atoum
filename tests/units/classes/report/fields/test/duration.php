<?php

namespace mageekguy\atoum\tests\units\report\fields\test;

use \mageekguy\atoum;

require_once(__DIR__ . '/../../../../runner.php');

abstract class duration extends atoum\test
{
	abstract public function testSetWithRunner();
}

?>
