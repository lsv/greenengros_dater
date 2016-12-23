<?php

class DateTest extends \PHPUnit_Framework_TestCase
{

    public function test_time()
    {
        $current = new \DateTime();
        $current->setTime(10, 0);
        $newDate = findDate($current, null, [], [], [], []);

        $expected = new \DateTime();
        $this->assertEquals($newDate->format('d-m-Y'), $expected->format('d-m-Y'));
    }

    public function test_time_2()
    {
        $current = new \DateTime();
        $current->setTime(16, 0);
        $newDate = findDate($current, '15:00', [], [], [], []);

        $expected = new \DateTime();
        $this->assertEquals($newDate->format('d-m-Y'), $expected->add(new \DateInterval('P1D'))->format('d-m-Y'));
    }

    public function test_time_3()
    {
        $current = new \DateTime();
        $current->setTime(16, 0);
        $newDate = findDate($current, '16:01', [], [], [], []);

        $expected = new \DateTime();
        $this->assertEquals($newDate->format('d-m-Y'), $expected->format('d-m-Y'));
    }

    public function test_time_4()
    {
        $current = new \DateTime();
        $current->setTime(16, 2);
        $newDate = findDate($current, '16:01', [], [], [], []);

        $expected = new \DateTime();
        $this->assertEquals($newDate->format('d-m-Y'), $expected->add(new \DateInterval('P1D'))->format('d-m-Y'));
    }

    public function test_availibledays()
    {
        $current = new \DateTime('2016-12-25');
        $availible = ['25-12-2016'];
        $notAvailible = ['25-12-2016'];
        $newDate = findDate($current, null, $availible, [], $notAvailible, []);

        $expected = new \DateTime('2016-12-25');
        $this->assertEquals($newDate->format('d-m-Y'), $expected->format('d-m-Y'));
    }

    public function test_excluding()
    {
        $current = new \DateTime('2016-12-25');
        $excluding = [7];
        $notAvailible = ['25-12-2016'];
        $newDate = findDate($current, null, [], $excluding, $notAvailible, []);

        $expected = new \DateTime('2016-12-26');
        $this->assertEquals($newDate->format('d-m-Y'), $expected->format('d-m-Y'));
    }

    public function test_notavailible()
    {
        $current = new \DateTime('2016-12-25');
        $excluding = [7];
        $notAvailible = ['26-12-2016'];
        $holidays = ['27-12'];
        $newDate = findDate($current, null, [], $excluding, $notAvailible, $holidays);

        $expected = new \DateTime('2016-12-28');
        $this->assertEquals($newDate->format('d-m-Y'), $expected->format('d-m-Y'));
    }

}
