Policy
=========================

A naive and simple implementation for Policy classes.

Benefits
--------

* Avoid nested if's in your code.
* Aggregate conditional logic in once place.

How to use?
---------

Create a class that extends **AbstractPolicy**

```php
use JcFrane\Policy\AbstractPolicy;

class BlogPolicy extends AbstractPolicy
{

}
```

Create methods inside the your Policy class that represent each
conditional logic for the said policy.

```php
use JcFrane\Policy\AbstractPolicy;

class BlogPolicy extends AbstractPolicy
{
    public function canCreate($subject)
    {
        $this->allow($subject->canCreate, 'Cannot create a subject.');
    }

    public function canView($subject)
    {
        $this->allow($subject->canView, 'Cannot view the subject.');
    }

    public function canDelete($subject)
    {
        $this->forbid($subject->canDelete, 'Cannot delete the subject.');
    }

    public function canUpdate($subject)
    {
        $this->forbid($subject->canUpdate, 'Cannot update the subject');
    }
}

```

Evaluate your Policy Class

```php

use JcFrane\Polcy\PolicyChecker;

use Some\Namespace\BlogPolicy;

$checker = new PolicyChecker();

$subject = new \stdClass();
$subject->canCreate = true;
$subject->canView = false;
$subject->canDelete = true;
$subject->canUpdate = false;

$result = $checker->check(BlogPolicy::class, $subject, 'create'); // returns true

$result = $checker->check(BlogPolicy::class, $subject, 'view'); // throws JcFrane/PolicyViolationException

$result = $checker->check(BlogPolicy::class, $subject, 'delete'); // returns true

$result = $checker->check(BlogPolicy::class, $subject, 'update'); // throws JcFrane/PolicyViolationException
```

That's it! You can now create multiple policy classes that aggregates your conditional logic inside your code.

The allow() and forbid() methods
---------

The **allow()** accepts a boolean and a violation message. If first argument is true, then the **check()** will return true. Otherwise, will throw a ViolationException.

The **forbid()** accepts a boolean and a violation message. If first argument is false, then the **check()** will throw a ViolationException. Otherwise, will return true.

Installation
------------

```sh
$ composer install jcfrane/policy
```
