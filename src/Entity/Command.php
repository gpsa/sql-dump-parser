<?php
/**
 * Created by PhpStorm.
 * User: guilherme
 * Date: 12/11/18
 * Time: 18:57
 */

namespace Gpsa\SQLDumpParser\Entity;

/**
 * Class Command represents each SQL Command with the last line of the command
 */
class Command
{
    /**
     * The line of command
     * @var integer
     */
    private $line;

    /**
     * The SQL command
     * @var string
     */
    private $sql;

    /**
     * Command constructor.
     * @param integer $line
     * @param string  $sql
     */
    public function __construct($line, $sql)
    {
        return $this->setLine($line)->setSql($sql);
    }//end __construct()


    /**
     * @return integer
     */
    public function getLine()
    {
        return $this->line;
    }//end getLine()


    /**
     * @param integer $line
     * @return Command
     */
    public function setLine($line)
    {
        $this->line = $line;
        return $this;
    }//end setLine()


    /**
     * @return string
     */
    public function getSql()
    {
        return $this->sql;
    }//end getSql()


    /**
     * @param string $sql
     * @return Command
     */
    public function setSql($sql)
    {
        $this->sql = trim($sql);
        return $this;
    }//end setSql()
}//end class
