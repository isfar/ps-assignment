<?php

namespace App\Tests\Validator\Constraint;

use App\Document\RequestLimit;
use App\Storage\ArrayStorage;
use App\Util\Day;
use App\Validator\Constraint\NotTooManyAttempt;
use PHPUnit\Framework\TestCase;

class NotTooManyAttemptTest extends TestCase
{
    public function testOptionsCanBeSet()
    {
        $today = '2019-10-25';
        $message = 'too_many_attempts';
        $workdays = [
            Day::MON,
            Day::TUE,
            Day::WED
        ];

        $limit = new RequestLimit(
            2,
            5,
            $workdays
        );

        $storage = new ArrayStorage();

        $notTooManyAttempt = new NotTooManyAttempt([
            'today' => $today,
            'limit' => $limit,
            'message' => $message,
            'storage' => $storage,
        ]);

        $this->assertEquals($limit, $notTooManyAttempt->limit);
        $this->assertEquals($message, $notTooManyAttempt->message);
        $this->assertEquals($today, $notTooManyAttempt->today);
        $this->assertEquals($storage, $notTooManyAttempt->storage);
    }
}
