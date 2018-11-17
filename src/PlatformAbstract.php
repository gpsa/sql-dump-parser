<?php
/**
 * Created by PhpStorm.
 * User: guilherme
 * Date: 09/11/18
 * Time: 00:10
 */

namespace Gpsa\SQLDumpParser;

use Gpsa\SQLDumpParser\Entity\Command;
use Gpsa\SQLDumpParser\Exception\FileHandlerException;
use Gpsa\SQLDumpParser\Exception\StringHandlerException;

/**
 * Abstract Class PlatformAbstract
 */
abstract class PlatformAbstract implements PlatformInterface
{
    /**
     * File/String handler
     * @var resource
     */
    protected $handler;

    /**
     * Line to start generating SQL Commands
     * @var integer
     */
    protected $startLine = 0;

    /**
     * Start handler reading $file
     * @param string $file filename
     * @param integer $startLine startline
     * @return $this|PlatformInterface
     * @throws FileHandlerException
     */
    public function loadFile($file, $startLine = null)
    {
        if (($this->handler = @fopen($file, 'r')) === false) {
            throw new FileHandlerException("It's not possible to load file {$file}");
        }

        return $this->setStartLine($startLine);
    }//end loadFile()


    /**
     * @param string $string
     * @param integer $startLine
     * @return $this|PlatformInterface
     * @throws StringHandlerException
     */
    public function loadString($string, $startLine = null)
    {
        if (($this->handler = fopen('php://temp', 'a+')) === false) {
            // @codeCoverageIgnoreStart
            throw new StringHandlerException("It's not possible to load string");
            // @codeCoverageIgnoreEnd
        }

        fwrite($this->handler, $string);
        fseek($this->handler, 0);

        return $this->setStartLine($startLine);
    }//end loadString()


    /**
     * @return integer
     */
    protected function getStartLine()
    {
        return $this->startLine;
    }//end getStartLine()


    /**
     * @param integer $startLine
     * @return PlatformAbstract
     */
    protected function setStartLine($startLine = null)
    {
        $this->startLine = $startLine > 0 ? $startLine : 0;
        return $this;
    }//end setStartLine()


    /**
     * Generates next SQL Command;
     * Comments and empty lines are counted but ignored
     * @return Generator|Command
     */
    abstract public function getNext();
}//end class
