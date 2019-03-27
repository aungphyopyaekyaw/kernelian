<?php
require "../kernel/lib/ConfigReader.php";

class DB extends PDO {

    private $engine;
    private $host;
    private $database;
    private $user;
    private $pass;

    private static $_instance;

    private $table_name;
    private $selected;
    private $where;
	private $if_select;
    private $if_where = null;

    public static function table($table_name) {
        if(!self::$_instance instanceof DB) {
            self::$_instance = new DB();
        }
        self::$_instance->table_name = $table_name;
        self::$_instance->if_select = false;
        return self::$_instance;
    }

    public function insert($fields) {
        $sql = "INSERT INTO " . $table_name . "(";
        $keys = array_keys($fields);
        $values = array_values($fields);
        $i_keys = implode(",", $keys);
        $i_values = implode('","', $values);
        $sql .= $i_keys . ') VALUES ("' . $i_values . '")';
	$prep = $this->prepare($sql)->execute();
    }

    public function get() {
        if($this->if_where) {
          if($this->if_select == true) {
              $prep = $this->prepare($this->selected . " FROM " . $this->table_name . $this->where);
          } else {
              $prep = $this->prepare("SELECT * FROM " .$this->table_name . $this->where);
          }
        } else {
          if($this->if_select == true) {
              $prep = $this->prepare($this->selected . " FROM " . $this->table_name);
          } else {
              $prep = $this->prepare("SELECT * FROM " .$this->table_name);
          }
        }
        $prep->execute();
        return $prep->fetchAll(PDO::FETCH_ASSOC);
    }

  public function where() {
    $this->if_where = true;
    $args = func_get_args();
    call_user_func_array(array('DB','i_where'), array($args));
    return $this;
  }

  public function i_where($values) {
    $end_value = "'".end($values)."'";
    array_pop($values);
    array_push($values, $end_value);
    $where_i = implode(" ", $values);
    $this->where .= " where ".$where_i;
    return $this;
  }

	public function select() {
		$this->if_select = true;
		$args = func_get_args();
		call_user_func_array(array('DB','toImplode'), array($args));
		return $this;
	}

	public function toImplode($values) {
        $this->selected = "SELECT ";
		$selected_value = implode(", ", $values);
		$this->selected .= $selected_value;
		return $this;
	}
	/* only usable with php 5.6 and above
	public function select(string ...$values) {
        $this->if_select = true;
        $selected_value = implode(", ", $values);
        $this->select .= $selected_value;
        return $this;
	} */

    public function __construct(){
        $this->engine = 'mysql';
        $this->host = Config::get('database.hostname');
        $this->database = Config::get('database.dbname');
        $this->user = Config::get('database.username');
        $this->pass = Config::get('database.password');
        $dns = $this->engine.':dbname='.$this->database.";host=".$this->host;
        parent::__construct( $dns, $this->user, $this->pass );
    }

}
?>
