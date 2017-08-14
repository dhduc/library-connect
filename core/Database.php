<?php
header('Content-Type: text/html; charset=utf-8');

/**
 * Class Database
 */
class Database
{
    /**
     * @var mysqli
     */
    private $__conn;

    /**
     * @var
     */
    protected $_table;

    /**
     * @var string
     */
    protected $_model = '';

    /**
     * @var string
     */
    protected $_msg = '';

    /**
     * Database constructor.
     */
    function __construct()
    {
        if (!$this->__conn) {
            $this->__conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die ('Lỗi kết nối');
            mysqli_query($this->__conn, "set names 'utf8'");
            date_default_timezone_set("Asia/Ho_Chi_Minh");
            echo 'Connect Successful';
        }
    }

    /**
     * __destruct
     */
    function __destruct()
    {
        if ($this->__conn) {
            mysqli_close($this->__conn);
        }
    }

    /**
     * @param $sql
     * @return bool|mysqli_result
     */
    function query($sql)
    {
        return mysqli_query($this->__conn, $sql);
    }

    /**
     * @param $data
     * @return bool|mysqli_result
     */
    function insert($data)
    {
        $table = $this->_table;
        $model = $this->_model;
        $msg = $this->_msg;
        $field_list = '';
        $value_list = '';
        foreach ($data as $key => $value) {
            $field_list .= ",$key";
            $value_list .= ",'" . mysql_escape_string($value) . "'";
        }
        $sql = 'INSERT INTO ' . $table . '(' . trim($field_list, ',') . ') VALUES (' . trim($value_list, ',') . ')';
        $result = mysqli_query($this->__conn, $sql);
        if (!$result) {
            echo $sql . "<br>";
            die ('Câu truy vấn bị sai: function insert()');
        } else {
            echo 'Insert to '.$model.' '.$msg;
        }

        return $result;
    }

    /**
     * @param $data
     * @param $where
     * @return bool|mysqli_result
     */
    function update($data, $where)
    {
        $sql = '';
        $model = $this->_model;
        $table = $this->_table;
        foreach ($data as $key => $value) {
            $sql .= "$key = '" . mysql_escape_string($value) . "',";
        }
        $sql = 'UPDATE ' . $table . ' SET ' . trim($sql, ',') . ' WHERE ' . $where;
        $result = mysqli_query($this->__conn, $sql);
        if (!$result) {
            echo $sql . "<br>";
            die ('Câu truy vấn bị sai: function update()');
        } else {
            echo 'Update to '.$model.' successful';
        }

        return $result;
    }

    /**
     * @param $where
     * @return bool|mysqli_result
     */
    function remove($where)
    {
        $table = $this->_table;
        $model = $this->_model;
        $sql = "DELETE FROM $table WHERE $where";
        $result = mysqli_query($this->__conn, $sql);

        if (!$result) {
            echo $sql . "<br>";
            die ('Câu truy vấn bị sai: function remove()');
        } else {
            echo 'Remove record in '.$model.' successful';
        }

        return $result;
    }

    /**
     * @return bool|mysqli_result
     */
    function delete_all()
    {
        $table = $this->_table;
        $model = $this->_model;
        $sql = "DELETE FROM $table";
        $result = mysqli_query($this->__conn, $sql);

        if (!$result) {
            echo $sql . "<br>";
            die ('Câu truy vấn bị sai: function delete_all()');
        } else {
            echo 'Delete al record of '.$model.' successful';
        }

        return $result;
    }

    /**
     * @param $sql
     * @return array
     */
    function get_list($sql)
    {
        $result = mysqli_query($this->__conn, $sql);
        if (!$result) {
            echo $sql . "<br>";
            die ('Câu truy vấn bị sai: function get_list()');
        }
        $return = array();
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
    function get_row($sql)
    {
        $result = mysqli_query($this->__conn, $sql);
        if (!$result) {
            echo $sql . "<br>";
            die ('Câu truy vấn bị sai: function get_row()');
        }
        $row = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        if ($row) {
            return $row;
        }
        return false;
    }

}

?>