<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Filter;

class OrderByFilterTest extends \PHPUnit_Framework_TestCase
{
    public function orderByProvider()
    {
        return [
            [
                ['name'],
                [
                    'B' => ['name' => 'B'],
                    'A' => ['name' => 'A'],
                    'C' => ['name' => 'C']
                ],
                [
                    'A' => ['name' => 'A'],
                    'B' => ['name' => 'B'],
                    'C' => ['name' => 'C']
                ]
            ],
            [
                ['name', 'age'],
                [
                    'C30' => ['name' => 'C', 'age' => 30],
                    'A30' => ['name' => 'A', 'age' => 30],
                    'A20' => ['name' => 'A', 'age' => 20],
                    'A10' => ['name' => 'A', 'age' => 10]
                ],
                [
                    'A10' => ['name' => 'A', 'age' => 10],
                    'A20' => ['name' => 'A', 'age' => 20],
                    'A30' => ['name' => 'A', 'age' => 30],
                    'C30' => ['name' => 'C', 'age' => 30],
                ]
            ],
            [
                ['name', 'age'],
                [
                    'A20' => ['name' => 'A', 'age' => 20],
                    'C30' => ['name' => 'C', 'age' => 30],
                    'A30' => ['name' => 'A', 'age' => 30],
                    'A10' => ['name' => 'A', 'age' => 10]
                ],
                [
                    'A10' => ['name' => 'A', 'age' => 10],
                    'A20' => ['name' => 'A', 'age' => 20],
                    'A30' => ['name' => 'A', 'age' => 30],
                    'C30' => ['name' => 'C', 'age' => 30],
                ]
            ]
        ];
    }

    /**
     * @dataProvider orderByProvider
     */
    public function testOrderBy(array $keys, array $unsorted, array $sorted)
    {
        $this->assertEquals(
            $sorted,
            iterator_to_array(
                (new OrderByFilter(...$keys))->filter(new \ArrayIterator($unsorted))
            )
        );
    }
}
