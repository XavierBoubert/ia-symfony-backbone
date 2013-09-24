<?php

namespace Acme\IAFrontBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Talk
{
	/**
	 * @Assert\NotBlank()
	 */
	public $text;
	public $previous;

	public function __construct($text, $previous = '') {
		$this->text = $text;
		$this-> previous = $previous;
	}
}
