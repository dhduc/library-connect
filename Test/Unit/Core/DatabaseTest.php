<?php


namespace Test\Unit\Core;

require '../../../Core/Database.php';

use PHPUnit\Framework\TestCase;
use Core\Database;
/**
 * Class DatabaseTest
 * @package Test\Unit\Core
 */
class DatabaseTest extends TestCase
{
    /**
     * testDBConnect
     */
    public function testDBConnect() {
        $this->assertEquals(
            true,
            Database::__construct()
        );
    }
}