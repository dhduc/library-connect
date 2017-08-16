<?php

namespace Core;

/**
 * Class Database
 */
class Database
{
    /**
     * @var \mysqli
     */
    private $conn;

    /**
     * @var
     */
    protected $table;

    /**
     * @var string
     */
    protected $model = '';

    /**
     * @var string
     */
    protected $msg = 'successful';

    /**
     * Database constructor.
     */
    public function __construct()
    {
        if (!$this->conn) {
            $this->conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die('Connect Failed!');
            mysqli_query($this->conn, "set names 'utf8'");
            date_default_timezone_set("Asia/Ho_Chi_Minh");
            echo 'Connect Successful!';

            return true;
        }
    }

    /**
     * __destruct
     */
    public function __destruct()
    {
        if ($this->conn) {
            mysqli_close($this->conn);
        }
    }

    /**
     * @param $sql
     * @return bool|\mysqli_result
     */
    public function query($sql)
    {
        return mysqli_query($this->conn, $sql);
    }

    /**
     * @param $data
     * @return bool|\mysqli_result
     */
    public function insert($data)
    {
        $table = $this->table;
        $model = $this->model;
        $field_list = '';
        $value_list = '';
        foreach ($data as $key => $value) {
            $field_list .= ",$key";
            $value_list .= ",'" . mysql_escape_string($value) . "'";
        }
        $sql = 'INSERT INTO ' . $table . '(' . trim($field_list, ',') . ') VALUES (' . trim($value_list, ',') . ')';
        $result = mysqli_query($this->conn, $sql);
        if (!$result) {
            echo $sql . "<br>";
            die('Query failed: function insert()');
        } else {
            echo 'Insert to '.$model.' '.$this->msg;
        }

        return $result;
    }

    /**
     * @param $data
     * @param $where
     * @return bool|\mysqli_result
     */
    public function update($data, $where)
    {
        $sql = '';
        $model = $this->model;
        $table = $this->table;
        foreach ($data as $key => $value) {
            $sql .= "$key = '" . mysql_escape_string($value) . "',";
        }
        $sql = 'UPDATE ' . $table . ' SET ' . trim($sql, ',') . ' WHERE ' . $where;
        $result = mysqli_query($this->conn, $sql);
        if (!$result) {
            echo $sql . "<br>";
            die('Query failed: function update()');
        } else {
            echo 'Update to '.$model.' '.$this->msg;
        }

        return $result;
    }

    /**
     * @param $where
     * @return bool|\mysqli_result
     */
    public function remove($where)
    {
        $table = $this->table;
        $model = $this->model;
        $sql = "DELETE FROM $table WHERE $where";
        $result = mysqli_query($this->conn, $sql);

        if (!$result) {
            echo $sql . "<br>";
            die('Query failed: function remove()');
        } else {
            echo 'Remove record in '.$model.' '.$this->msg;
        }

        return $result;
    }

    /**
     * @return bool|\mysqli_result
     */
    public function deleteAll()
    {
        $table = $this->table;
        $model = $this->model;
        $sql = "DELETE FROM $table";
        $result = mysqli_query($this->conn, $sql);

        if (!$result) {
            echo $sql . "<br>";
            die('Query failed: function delete_all()');
        } else {
            echo 'Delete al record of '.$model.' '.$this->msg;
        }

        return $result;
    }

    /**
     * @param $sql
     * @return array
     */
    public function getList($sql)
    {
        $result = mysqli_query($this->conn, $sql);
        if (!$result) {
            echo $sql . "<br>";
            die('Query failed: function get_list()');
        }
        $return = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $return[] = $row;
        }
        mysqli_free_result($result);
        return $return;
    }

    /**
     * @param $sql
     * @return array|bool|null
     */
    public function getRow($sql)
    {
        $result = mysqli_query($this->conn, $sql);
        if (!$result) {
            echo $sql . "<br>";
            die('Query failed: function get_row()');
        }
        $row = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        if ($row) {
            return $row;
        }
        return false;
    }
}
