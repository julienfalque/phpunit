<?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestListener;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Test;

/**
 * @since      Class available since Release 2.0.0
 * @covers     TestCase
 */
class Framework_TestListenerTest extends TestCase implements TestListener
{
    protected $endCount;
    protected $errorCount;
    protected $failureCount;
    protected $warningCount;
    protected $notImplementedCount;
    protected $riskyCount;
    protected $skippedCount;
    protected $result;
    protected $startCount;

    public function addError(Test $test, Exception $e, $time)
    {
        $this->errorCount++;
    }

    public function addWarning(Test $test, PHPUnit_Framework_Warning $e, $time)
    {
        $this->warningCount++;
    }

    public function addFailure(Test $test, AssertionFailedError $e, $time)
    {
        $this->failureCount++;
    }

    public function addIncompleteTest(Test $test, Exception $e, $time)
    {
        $this->notImplementedCount++;
    }

    public function addRiskyTest(Test $test, Exception $e, $time)
    {
        $this->riskyCount++;
    }

    public function addSkippedTest(Test $test, Exception $e, $time)
    {
        $this->skippedCount++;
    }

    public function startTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
    }

    public function endTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
    }

    public function startTest(Test $test)
    {
        $this->startCount++;
    }

    public function endTest(Test $test, $time)
    {
        $this->endCount++;
    }

    protected function setUp()
    {
        $this->result = new PHPUnit_Framework_TestResult;
        $this->result->addListener($this);

        $this->endCount            = 0;
        $this->failureCount        = 0;
        $this->notImplementedCount = 0;
        $this->riskyCount          = 0;
        $this->skippedCount        = 0;
        $this->startCount          = 0;
    }

    public function testError()
    {
        $test = new TestError;
        $test->run($this->result);

        $this->assertEquals(1, $this->errorCount);
        $this->assertEquals(1, $this->endCount);
    }

    public function testFailure()
    {
        $test = new Failure;
        $test->run($this->result);

        $this->assertEquals(1, $this->failureCount);
        $this->assertEquals(1, $this->endCount);
    }

    public function testStartStop()
    {
        $test = new Success;
        $test->run($this->result);

        $this->assertEquals(1, $this->startCount);
        $this->assertEquals(1, $this->endCount);
    }
}
