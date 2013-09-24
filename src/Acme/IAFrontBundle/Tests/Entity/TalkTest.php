<?php

namespace Acme\IAFrontBundle\Tests\Entity;

use Acme\IAFrontBundle\Entity\Talk;

class TalkTest extends \PHPUnit_Framework_TestCase
{
	public function testCtorTalk()
	{
		$talk = new Talk('test text', 'test previous');

		$this->assertTrue($talk->text == 'test text');
		$this->assertTrue($talk->previous == 'test previous');
	}
}
