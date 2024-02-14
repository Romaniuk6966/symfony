<?php

namespace App\Tests\Test;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AppTest extends KernelTestCase
{
    /**
     * @dataProvider sumProvider
     */
    public function testSum($a, $b, $expected): void
    {
        $this->assertSame($expected, $a + $b);
    }

    /**
     * @dataProvider sumProvider
     */
    public function testMinus($expected, $a, $b): void
    {
        $this->assertSame($expected, $b - $a);
    }

    /**
     * @dataProvider sumProvider
     */
    public function testMultiple($a, $b, $c, $expected): void
    {
        $this->assertSame($expected, $a * $b);
    }

    /**
     * @dataProvider sumProvider
     */
    public function testDivide($expected, $a, $b, $c): void
    {
        $this->assertSame($expected, $c / $a);
    }

    public function sumProvider(): array
    {
        return [
            [2, 2, 4, 4],
            [2, 6, 8, 12],
            [-1, 4, 3, -4],
            [3, -2, 1, -6],
            [1234, 12345, 13579, 15233730],
        ];
    }
}
