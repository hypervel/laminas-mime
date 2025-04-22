<?php

declare(strict_types=1);
/**
 * This file is part of huangdijia/laminas-mime-double.
 *
 * @link     https://github.com/huangdijia/laminas-mime-double
 * @document https://github.com/huangdijia/laminas-mime-double/blob/main/README.md
 * @contact  Huang Dijia <huangdijia@gmail.com>
 */

namespace LaminasTest\Mime;

use Laminas\Mime\Decode;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class DecodeTest extends TestCase
{
    public function testSplitHeaderFieldWithoutQuotes()
    {
        $field = 'text/plain; charset=utf-8; format=flowed';

        $parts = Decode::splitHeaderField($field);
        $this->assertEquals('text/plain', $parts['0']);
        $this->assertEquals('utf-8', $parts['charset']);
        $this->assertEquals('flowed', $parts['format']);

        $this->assertEquals('text/plain', Decode::splitHeaderField($field, '0'));
        $this->assertEquals('utf-8', Decode::splitHeaderField($field, 'charset'));
        $this->assertEquals('flowed', Decode::splitHeaderField($field, 'format'));
    }

    public function testSplitHeaderFieldWithQuotes()
    {
        $field = 'text/plain; charset="utf-8"; filename="test file.txt"';

        $parts = Decode::splitHeaderField($field);
        $this->assertEquals('text/plain', $parts['0']);
        $this->assertEquals('utf-8', $parts['charset']);
        $this->assertEquals('test file.txt', $parts['filename']);

        $this->assertEquals('text/plain', Decode::splitHeaderField($field, '0'));
        $this->assertEquals('utf-8', Decode::splitHeaderField($field, 'charset'));
        $this->assertEquals('test file.txt', Decode::splitHeaderField($field, 'filename'));
    }

    public function testSplitHeaderFieldWithCustomFirstName()
    {
        $field = 'text/plain; charset=utf-8';

        $parts = Decode::splitHeaderField($field, null, 'content-type');
        $this->assertEquals('text/plain', $parts['content-type']);
        $this->assertEquals('utf-8', $parts['charset']);

        $this->assertEquals('text/plain', Decode::splitHeaderField($field, 'content-type', 'content-type'));
    }

    public function testSplitHeaderFieldWithNonExistentPart()
    {
        $field = 'text/plain; charset=utf-8';

        $this->assertNull(Decode::splitHeaderField($field, 'non-existent'));
    }

    public function testSplitHeaderFieldWithSpecialChars()
    {
        $field = 'text/plain; charset="utf-8"; filename="test file with spaces.txt"';

        $parts = Decode::splitHeaderField($field);
        $this->assertEquals('test file with spaces.txt', $parts['filename']);
        $this->assertEquals('test file with spaces.txt', Decode::splitHeaderField($field, 'filename'));
    }
}
