<?php

namespace App\Tests\Validator\Constraint;

use App\Storage\ArrayStorage;
use App\Validator\Constraint\NotTooManyAttempt;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class NotTooManyAttemptTest extends TestCase
{
    public function testOptionsCanBeSet()
    {
        $today = '2019-10-25';
        $maxAllowed = 2;
        $message = 'too_many_attempts';
        $numWorkdays = 5;
        $workdays = [
            'Mon',
            'Tue',
            'Wed'
        ];
        $storage = new ArrayStorage();

        $notTooManyAttempt = new NotTooManyAttempt([
            'today' => $today,
            'maxAllowed' => $maxAllowed,            
            'numWorkdays' => $numWorkdays,            
            'workdays' => $workdays,            
            'message' => $message,
            'storage' => $storage,
        ]);

        $this->assertEquals($maxAllowed, $notTooManyAttempt->maxAllowed);
        $this->assertEquals($numWorkdays, $notTooManyAttempt->numWorkdays);
        $this->assertEquals($workdays, $notTooManyAttempt->workdays);
        $this->assertEquals($message, $notTooManyAttempt->message);
        $this->assertEquals($today, $notTooManyAttempt->today);
        $this->assertEquals($storage, $notTooManyAttempt->storage);
    }
}