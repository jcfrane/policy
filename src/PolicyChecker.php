<?php

namespace JcFrane\Policy;

class PolicyChecker
{
	public function check(string $policyClassName, $subject, string $action): bool
	{
		$policy = new $policyClassName;
		$methodName = 'can' . ucfirst($action);

		if (!method_exists($policy, $methodName)) {
			throw new \InvalidArgumentException('Specified action doesn\'t exist.');
		}

		$policy->$methodName($subject);

		return true;
	}
}
