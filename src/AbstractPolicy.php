<?php

namespace JcFrane\Policy;

abstract class AbstractPolicy
{
	private $violation; 

	public function forbid(bool $condition, string $violationMessage)
	{
		$this->allow($condition, $violationMessage);
	}

	public function allow(bool $condition, string $violationMessage)
	{
		if (!$condition) {
			throw new ViolationException($violationMessage);
		}
	}
}
