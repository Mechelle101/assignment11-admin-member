<?php

class DatabaseObject {

  static protected $database;
  static protected $table_name = "";
  static protected $columns = [];
  static protected $db_columns;
  public $errors = [];

  static public function set_database($database) {
    self::$database = $database;
  }

  static public function find_by_sql($sql) {
    $result = self::$database->query($sql);
    if(!$result) {
      exit("Database query failed.");
    }

    // results into objects
    $object_array = [];
    while($record = $result->fetch_assoc()) {
      $object_array[] = static::instantiate($record);
    }

    $result->free();

    return $object_array;
  }

  static public function find_all() {
    // where do we grab the $table_name? - Bird class
    $sql = "SELECT * FROM " . static::$table_name;
    return static::find_by_sql($sql);
  }

  static public function find_by_id($id) {
    $sql = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE id='" . self::$database->escape_string($id) . "'";
    $obj_array = static::find_by_sql($sql);
    if(!empty($obj_array)) {
      return array_shift($obj_array);
    } else {
      return false;
    }
  }

  static protected function instantiate($record) {
    $object = new static;
    // You can either do this manually which makes your code brittle or
    // run it through a loop and make the code reusable. 
    
    foreach($record as $property => $value) {
      if(property_exists($object, $property)) {
        $object->$property = $value;
      }
    }
    return $object;
  }

  /**
   * Generic validation, add custom ones on separate classes
   *
   * @return void
   */
  protected function validate() {
    $this->errors = [];

    // add here

    return $this->errors;
  }

  /**
   * Instance method which creates a new database object based on the input
   *
   * @return boolean 
   */
  protected function create() {
    $this->validate();
    if(!empty($this->errors)) {return false; }

    $attributes = $this->sanitized_attributes();
    $sql = "INSERT INTO " . static::$table_name . " (";
    $sql .= join(', ', array_keys($attributes));
    $sql .= ") VALUES ('";
    $sql .= join("', '", array_values($attributes));
    $sql .= "')";
    $result = self::$database->query($sql);
    if($result) {
      $this->id = self::$database->insert_id;
    }
    return $result;
  }

  /**
   * Creates and runs a SQL statement that updates the existing record from the database with the input
   *
   * @return boolean
   */
  protected function update() {
    $this->validate();
    if(!empty($this->errors)) {return false; }

    $attributes = $this->sanitized_attributes();
    $attribute_pairs = [];
    foreach($attributes as $key => $value) {
      $attribute_pairs[] = "{$key}='{$value}'";
    }
    $sql = "UPDATE " . static::$table_name . " SET ";
    $sql .= join(', ', $attribute_pairs);
    $sql .= " WHERE id='" . self::$database->escape_string($this->id) . "' ";
    $sql .= "LIMIT 1";
    $result = self::$database->query($sql);
    return $result;
  }

  /**
   * Checks whether the user is updating or creating a new record by looking if ID is set, then it calls appropriate method
   *
   * @return void
   */
  public function save() {
    if(isset($this->id)) {
      return $this->update();
    } else {
      return $this->create();
    }
  }

  /**
   * Updates the properties of the object based on whether there was a change submitted
   *
   * @return void
   */
  public function merge_attributes($args=[]) {
    foreach($args as $key => $value) {
      if(property_exists($this, $key) && !is_null($value)) {
        $this->$key = $value;
      }
    }
  }

  /**
   * Creates an array of attributes in a form of key-value pair
   *
   * @return array
   */
  public function attributes() {
    
    $attributes = [];
    foreach(static::$db_columns as $column) {
      if($column == 'id') {continue;}
      $attributes[$column] = $this->$column;
    }
    return $attributes;
  }

  /**
   * Takes the values from the attributes array and sanitizes them to prevent SQL injection
   *
   * @return array
   */
  protected function sanitized_attributes() {
    $sanitized = [];
    foreach($this->attributes() as $key => $value) {
      $sanitized[$key] = self::$database->escape_string($value);
    }
    return $sanitized;
  }

  /**
   * Deletes from the database an entry with the selected ID
   *
   * @return boolean
   */
  public function delete() {
    $sql = "DELETE FROM " . static::$table_name . " ";
    $sql .= "WHERE id='" . self::$database->escape_string($this->id) . "' ";
    $sql .= "LIMIT 1";
    $result = self::$database->query($sql);
    return $result;
  }

}
