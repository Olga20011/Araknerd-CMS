<?php
//namespace include;

use model\Auth\Environment;

/**
 * MySQLi database; only one connection is allowed. 
 */
class Database {
  private $_connection;
  // Store the single instance.
  private static $_instance;
  /**
   * Get an instance of the Database.
   * @return Database 
   */
  public static function getInstance() {
    if (!self::$_instance) {
      self::$_instance = new self();
    }
    return self::$_instance;
  }
  /**
   * Constructor.
   */
  public function __construct() {
    // (new Environment())->load();//loads from index folder
    $this->_connection = new mysqli(
      getenv('DATABASE_HOST'), 
      getenv('DATABASE_USER'), 
      getenv('DATABASE_PASSWORD'), 
      getenv('DATABASE_NAME'));
  
    // Error handling.
    if (mysqli_connect_error()) {
      trigger_error('Failed to connect to MySQL: ' . mysqli_connect_error(), E_USER_ERROR);
    }
  }
  /**
   * Empty clone magic method to prevent duplication. 
   */
  private function __clone() {}
  
  /**
   * Get the mysqli connection. 
   */
  public function getConnection() {
    return $this->_connection;
  }
    
public function real_escape_string($string)
{
    return $this->_connection->real_escape_string($string);
}
}