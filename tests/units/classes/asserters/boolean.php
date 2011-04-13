<?php

namespace mageekguy\atoum\tests\units\asserters;

use
	\mageekguy\atoum,
	\mageekguy\atoum\asserter,
	\mageekguy\atoum\asserters,
	\mageekguy\atoum\tools\diffs
;

require_once(__DIR__ . '/../../runner.php');

class boolean extends atoum\test
{
	public function test__construct()
	{
		$asserter = new asserters\boolean($generator = new asserter\generator($this));

		$this->assert
			->object($asserter->getScore())->isIdenticalTo($this->getScore())
			->object($asserter->getLocale())->isIdenticalTo($this->getLocale())
			->object($asserter->getGenerator())->isIdenticalTo($generator)
			->variable($asserter->getVariable())->isNull()
			->boolean($asserter->wasSet())->isFalse()
		;
	}

	public function testIsTrue()
	{
		$asserter = new asserters\boolean(new asserter\generator($test= new self($score = new atoum\score())));

		$this->assert
			->exception(function() use ($asserter) {
					$asserter->isTrue();
				}
			)
				->isInstanceOf('\logicException')
				->hasMessage('Variable is undefined')
		;

		$asserter->setWith(true);

		$score->reset();

		$this->assert
			->object($asserter->isTrue())->isIdenticalTo($asserter)
			->integer($score->getPassNumber())->isEqualTo(1)
			->integer($score->getFailNumber())->isZero()
		;

		$asserter->setWith(false);

		$diff = new diffs\variable();

		$this->assert
			->exception(function() use ($asserter) {
						$asserter->isTrue();
					}
				)
				->isInstanceOf('\mageekguy\atoum\asserter\exception')
				->hasMessage(sprintf($test->getLocale()->_('%s is not true'), $asserter) . PHP_EOL . $diff->setReference(true)->setData(false))
		;
	}

	public function testIsFalse()
	{
		$asserter = new asserters\boolean(new asserter\generator($test = new self($score = new atoum\score())));

		$this->assert
			->exception(function() use ($asserter) {
					$asserter->isFalse();
				}
			)
				->isInstanceOf('\logicException')
				->hasMessage('Variable is undefined')
		;

		$asserter->setWith(false);

		$score->reset();

		$this->assert
			->object($asserter->isFalse())->isIdenticalTo($asserter)
			->integer($score->getPassNumber())->isEqualTo(1)
			->integer($score->getFailNumber())->isZero()
		;

		$asserter->setWith(true);

		$diff = new diffs\variable();

		$this->assert
			->exception(function() use ($asserter) {
						$asserter->isFalse();
					}
				)
				->isInstanceOf('\mageekguy\atoum\asserter\exception')
				->hasMessage(sprintf($test->getLocale()->_('%s is not false'), $asserter) . PHP_EOL . $diff->setReference(false)->setData(true))
		;
	}

	public function testSetWith()
	{
		$asserter = new asserters\boolean(new asserter\generator($test = new self($score = new atoum\score())));

		$this->assert
			->exception(function() use (& $line, $asserter, & $variable) { $line = __LINE__; $asserter->setWith($variable = uniqid()); })
				->isInstanceOf('\mageekguy\atoum\asserter\exception')
				->hasMessage(sprintf($test->getLocale()->_('%s is not a boolean'), $asserter->toString($variable)))
			->integer($score->getFailNumber())->isEqualTo(1)
		;

		$this->assert
			->array($score->getFailAssertions())->isEqualTo(array(
					array(
						'case' => null,
						'class' => __CLASS__,
						'method' => $test->getCurrentMethod(),
						'file' => __FILE__,
						'line' => $line,
						'asserter' => get_class($asserter) . '::setWith()',
						'fail' => sprintf($test->getLocale()->_('%s is not a boolean'), $asserter->toString($variable))
					)
				)
			)
			->integer($score->getPassNumber())->isZero()
			->string($asserter->getVariable())->isEqualTo($variable)
		;

		$this->assert
			->object($asserter->setWith(true))->isIdenticalTo($asserter); $line = __LINE__
		;

		$this->assert
			->integer($score->getFailNumber())->isEqualTo(1)
			->integer($score->getPassNumber())->isEqualTo(1)
			->boolean($asserter->getVariable())->isTrue()
		;
	}
}

?>
