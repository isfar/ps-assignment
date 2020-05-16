<?php

namespace App\Tests\Storage;

use App\Storage\ArrayStorage;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;

class ArrayStorageTest extends TestCase
{
    /** @var ArrayStorage */
    private $storage;

    /** @var ReflectionProperty */
    private $storeReflection;

    public function setUp(): void
    {
        $this->storage = new ArrayStorage();
        $this->storeReflection = new ReflectionProperty(ArrayStorage::class, 'store');
        $this->storeReflection->setAccessible(true);
    }

    public function tearDown(): void
    {
        $this->storage = null;
        $this->storeReflection = null;
    }

    public function testAdd()
    {
        $this->storage->add('111', '2019-10-11');
        $this->storage->add('111', '2019-10-12');
        $this->storage->add('112', '2019-10-01');

        $store = $this->storeReflection->getValue($this->storage);

        $exptected = [
            '111' => [
                '2019-10-11',
                '2019-10-12',
            ],
            '112' => [
                '2019-10-01',
            ]
        ];

        $this->assertEquals($exptected, $store);
    }

    public function testGet()
    {
        $this->storeReflection->setValue($this->storage, [
            '111' => [
                '3',
            ],
            '222' => [
                '1',
                '2'
            ]
        ]);

        $output = $this->storage->get('111');
        $expected = [ '3' ];

        $this->assertEquals($expected, $output);

        $output = $this->storage->get('123');
        
        $this->assertNull($output);
    }

    /**
     * @dataProvider provideTestGetByOffset
     */
    public function testGetByOffset(
        $offset,
        $expected
    ) {
        $this->storeReflection->setValue($this->storage, [
            '111' => [
                '1',
                '2',
                '3',
                '4',
            ],
        ]);

        $output = $this->storage->getByOffset('111', $offset);

        $this->assertEquals($expected, $output);
    }

    public function provideTestGetByOffset()
    {
        return [
            [ 0, '1' ],
            [ 8, null ],
            [ -3, '2' ],
            [-10, null ]
        ];
    }
}
