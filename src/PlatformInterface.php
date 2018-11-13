<?php
/**
 * Created by PhpStorm.
 * User: guilherme
 * Date: 09/11/18
 * Time: 00:10
 */

namespace Gpsa\SQLDumpParser;

/**
 * Interface PlatformInterface
 *
 * @package Gpsa\SQLDumpParser
 */
interface PlatformInterface
{


    /**
     * Load File
     *
     * @param  string $file select file
     * @param  integer $startLine Start from line of file
     * @return static return the class
     */
    public function loadFile($file, int $startLine = null);


    /**
     * Load String
     *
     * @param  string  $string    string to be parsed
     * @param  integer $startLine Start from line of file
     * @return static return the class
     */
    public function loadString($string, int $startLine = null);
}//end interface
