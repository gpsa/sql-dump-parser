<?php
/**
 * Created by PhpStorm.
 * User: guilherme
 * Date: 08/11/18
 * Time: 19:17
 */

namespace Gpsa\SQLDumpParser;

use Gpsa\SQLDumpParser\Entity\Command;

/**
 * Class for parsing MySQL Dump SQL
 */
class MySQL extends PlatformAbstract
{
    /**
     * Delimiter Char
     * @var string
     */
    private $delimiterChar = ';';
    /**
     * Delimiter string length
     * @var integer
     */
    private $delimiterLength = 1;

    /**
     * @inheritdoc
     */
    public function getNext()
    {
        // Temporary variable, used to store current query
        $templine = '';
        $currentLine = 0;

        // Loop through each line
        while (feof($this->handler) === false) {
            $line = fgets($this->handler);

            // Starts from given Line
            if (++$currentLine < $this->getStartLine()) {
                continue;
            }

            // Skip it if it's a comment
            if (substr($line, 0, 2) === '--' || trim($line) === '') {
                continue;
            }

            if (stristr($line, 'DELIMITER')) {
                $this->delimiterChar = trim(str_ireplace('delimiter', '', $line));
                $this->delimiterLength = strlen($this->delimiterChar);

                continue;
            }

            // Add this line to the current segment
            $templine .= $line;

            $lineFiltered = substr(trim($line), -$this->delimiterLength, $this->delimiterLength);

            // If it has a semicolon at the end, it's the end of the query
            if (strcmp($lineFiltered, $this->delimiterChar) === 0) {
                yield new Command($currentLine, $templine);

                // Reset temp variable to empty
                $templine = '';
            }
        }//end while

        fclose($this->handler);
    }//end getNext()
}//end class
