<?php
class db {
    public $link = null;
    public $last_query = null;

    public $host = 'localhost';
    public $user = 'root';
    public $password = '';

    public $dbName = 'ajaxchat';

    public function __construct() {
        $this->link = mysqli_connect($this->host, $this->user, $this->password, $this->dbName) or die('');

        mysqli_query($this->link, "SET NAMES utf8");
    }

    public function query($q = null) {
        $this->last_query = mysqli_query($this->link, $q);

        return $this->last_query;
    }

    /*
     Создание записи в таблице. Пример использования:

     $db->insert('users', array('id' => NULL, 'login' => 'test'));
    */
    public function insert($tableName = null, $params = null) {
        foreach($params as $key => $value) {
            $keys[] = '`'.$key.'`';
            $values[] = "'".$this->escape($value)."'";
        }

        return $this->query("INSERT INTO `".$this->dbName."`.`".$tableName."` (".implode(', ', $keys).") VALUES (".implode(', ', $values).");");
    }

    /*
     Извлечение записи из таблицы. Пример использования:

     $db->get("users", array("id" => 5));

     public function get($tname = null, $args = null) {
       $req = "WHERE ";
       foreach ($args as $key => $value) {
         $req .= $key." = ".$value."";
       }
     }
   */
    /*
     Изменение записи в таблице. Примеры использования:

     $db->update('users', array('login' => 'new_login'), array('user_id' => 1));
     $db->update('users', array('reputation:+' => 1), array('user_id' => 1)); // прибавит +1 к reputation
    */
    public function update($tableName = null, $params = null, $where = null) {
        foreach($params as $key => $value) {
            if(preg_match('/\:/is', $key)) {
                preg_match('/[\+\-\*]/is', $key, $sign);

                $result[] = "`".str_replace(':'.$sign[0], '', $key)."` = `".str_replace(':'.$sign[0], '', $key)."` ".$sign[0]." ".$value."";
            } else {
                $result[] = "`".$key."` = '".$this->escape($value)."'";
            }
        }

        foreach($where as $key => $value) {
            $result_where[] = "`".$tableName."`.`".$key."` = '".$this->escape($value)."'";
        }

        $where = ((isset($where)) ? " WHERE ".implode(' AND ', $result_where)."" : '');

        return $this->query("UPDATE `".$this->dbName."`.`".$tableName."` SET ".implode(', ', $result)."".$where.";");
    }

    public function in($tableName = null, $fields = array(), $in_field = null, $in = null, $where = null) {
        for($i = 0; $i < count($fields); $i++) {
            $result_fields[] = '`'.$fields[$i].'`';
        }

        for($i = 0; $i < count($in); $i++) {
            $result_in[] = '\''.$in[$i].'\'';
        }

        if($where) {
            foreach($where as $key => $value) {
                $result_where[] = "`".$tableName."`.`".$key."` = '".$this->escape($value)."'";
            }
        }

        $where = ((isset($where)) ? implode(' AND ', $result_where)."" : '');

        $q = $this->query("SELECT ".implode(',', $result_fields)." FROM `".$tableName."` WHERE `".$in_field."` IN(".implode(',', $result_in).") ".$where.";");

        $result_d = array();

        while($d = $this->assoc($q)) {
            $result_d[$d[$in_field]] = $d;
        }

        return $result_d;
    }

    public function fetch($q = null) {
        return mysqli_fetch_array($q);
    }

    public function assoc($q = null) {
        return mysqli_fetch_assoc($q);
    }

    public function escape($q = null) {
        return mysqli_real_escape_string($this->link, $q);
    }

    public function insertId() {
        return mysqli_insert_id($this->link);
    }

    public function filter($text = null) {
        return htmlspecialchars(stripslashes($text));
    }

    public function br($text = null) {
        return str_replace("\n", "<br />", $text);
    }

    public function error() {
        return mysqli_error($this->link);
    }

    public function __destruct() {
        return mysqli_close($this->link);
    }
}

$db = new db;
?>