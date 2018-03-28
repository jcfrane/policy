<?php 

namespace JcFrane\Policy\Tests;

use PHPUnit_Framework_TestCase;

use JcFrane\Policy\AbstractPolicy;
use JcFrane\Policy\PolicyChecker;
use JcFrane\Policy\ViolationException;

class PolicyTest extends PHPUnit_Framework_TestCase
{
    public function testAllow() 
    {
        $checker = new PolicyChecker();
        
        $subject = new \stdClass();
        $subject->canCreate = true;
        $subject->canDelete = false;

        $result = $checker->check(SamplePolicy::class, $subject, 'create');
        $this->assertTrue($result);

        $this->expectException(ViolationException::class);
        $result = $checker->check(SamplePolicy::class, $subject, 'delete');
    }

    public function testForbid() 
    {
        $checker = new PolicyChecker();
        
        $subject = new \stdClass();
        $subject->canUpdate = true;
        $subject->canView = false;

        $result = $checker->check(SamplePolicy::class, $subject, 'update');
        $this->assertTrue($result);

        $this->expectException(ViolationException::class);
        $result = $checker->check(SamplePolicy::class, $subject, 'view');
    }

    public function testNotExistingAction()
    { 
        $checker = new PolicyChecker();
        
        $subject = new \stdClass();

        $this->expectException(\InvalidArgumentException::class);
        $result = $checker->check(SamplePolicy::class, $subject, 'something');              
    }
}

class SamplePolicy extends AbstractPolicy
{
    public function canCreate($subject)
    {
        $this->allow($subject->canCreate, 'Cannot create a subject');
    }

    public function canDelete($subject)
    {
        $this->allow($subject->canDelete, 'Cannot delete the subject');
    }

    public function canUpdate($subject)
    {
        $this->forbid($subject->canUpdate, 'Cannot update the subject');
    }

    public function canView($subject)
    {
        $this->forbid($subject->canView, 'Cannot view the subject');
    }
}