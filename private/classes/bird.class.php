<?php

class Bird extends DatabaseObject{

  static protected $table_name = 'birds';
  static protected $db_columns = 
  [
    'id', 
    'common_name', 
    'habitat', 
    'food', 
    'conservation_id', 
    'backyard_tips'
  ];

  public $id;
  public $common_name;
  public $habitat;
  public $food;
  public $conservation_id;
  public $backyard_tips;

  public const CONSERVATION = [ 
    1 => 'low',
    2 => 'moderate',
    3 => 'high',
    4 => 'extreme'
  ];

  public function __construct($args=[]) {
    $this->common_name = $args['common_name'] ?? '';
    $this->habitat = $args['habitat'] ?? '';
    $this->food = $args['food'] ?? '';
    $this->conservation_id = $args['conservation_id'] ?? 1;
    $this->backyard_tips = $args['backyard_tips'] ?? '';
  }

  public function conservation_level() {
    if($this->conservation_id > 0) {
      return self::CONSERVATION[$this->conservation_id];
    } else {
      return 'Unknown';
    }
  }

      /**
   * Checks whether there were any input errors and displays the according error message if there were
   *
   * @return void
   */
  protected function validate() {
    $this->errors = [];
    if(is_blank($this->common_name)) {
      $this->errors[] = "Name cannot be blank.";
    }
    if(is_blank($this->habitat)) {
      $this->errors[] = "Habitat cannot be blank.";
    }
    return $this->errors;
  }

}
