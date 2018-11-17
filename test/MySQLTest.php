<?php
/**
 * Created by PhpStorm.
 * User: guilherme
 * Date: 08/11/18
 * Time: 19:56
 */

namespace Gpsa\SQLDumpParserTest;


use Gpsa\SQLDumpParser\Entity\Command;
use Gpsa\SQLDumpParser\Exception\FileHandlerException;
use Gpsa\SQLDumpParser\MySQL;
use PHPUnit\Framework\TestCase;


class MySQLTest extends TestCase
{
    private $dataSourceFile;

    public function sqlProvider()
    {
        $this->dataSourceFile = __DIR__ . '/data/filetest.sql';
        $sql = file_get_contents($this->dataSourceFile);
        return [[$sql]];
    }

    public function testHasSQLAndLineKeys()
    {
        $sql = <<<SQL
-- COMMENT 1
-- COMMENT 2

SELECT * FROM xpto;
SQL;

        $parser = new MySQL();
        $parser->loadString($sql);

        $item = $parser->getNext()->current();

        $this->assertInstanceOf(Command::class, $item);
        $this->assertObjectHasAttribute('sql', $item);
        $this->assertObjectHasAttribute('line', $item);
        $this->assertEquals('SELECT * FROM xpto;', $item->getSql());
        $this->assertEquals(4, $item->getLine());
    }

    /**
     * @dataProvider sqlProvider
     */
    public function testLoadString($sql)
    {
        $parser = new MySQL();
        $parser->loadString($sql);

        $lineCount = 0;

        foreach ($parser->getNext() as $item) {
            $lineCount++;
        }

        $this->assertEquals(3, $lineCount);
    }

    public function testLoadFile()
    {
        $parser = new MySQL();
        $parser->loadFile($this->dataSourceFile);

        $lineCount = 0;

        foreach ($parser->getNext() as $item) {
            $lineCount++;
        }

        $this->assertEquals(3, $lineCount);
    }

    /**
     * @throws FileHandlerException
     */
    public function testLoadFileStartLine()
    {
        $parser = new MySQL();
        $parser->loadFile($this->dataSourceFile, 9);

        $lineCount = 0;

        foreach ($parser->getNext() as $item) {
            $lineCount++;
        }

        $this->assertEquals(2, $lineCount);
    }

    /**
     * @expectedException Gpsa\SQLDumpParser\Exception\FileHandlerException
     */
    public function testInvalidFile()
    {

        (new MySQL)->loadFile('/tmp/test-random-' . rand(100000, 9999999));
    }

}