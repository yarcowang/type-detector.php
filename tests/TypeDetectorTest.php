<?php
use PHPUnit\Framework\TestCase;

class TypeDetectorTest extends TestCase
{
    public function testSimpleDetect()
    {
        $data = ['name' => 'yarco', 'age' => 36, 'email' => 'yarco.wang@gmail.com', 'score' => 18.7, 'price' => 27.33];
        $result = ['name' => 'string', 'age' => 'smallint', 'email' => 'email', 'score'=> 'float', 'price' => 'decimal'];
        $this->assertEquals($result, \Yarco\TypeDetector\TypeDetector::detect($data));
    }
}