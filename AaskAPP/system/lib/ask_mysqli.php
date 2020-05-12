<?php

/**
 * Description of MySqli
 *
 * @author asksoft
 */
require_once getcwd() . '/AaskAPP/system/_configuration.php';
error_reporting(0);

class ask_mysqli extends _configuration {

    public function __construct() {
        parent::__construct();
        return;
    }

    public function _dbConnection() {
        try {
            $tempObject[$this->_mysqliConfiguration["database"]] = new mysqli($this->_mysqliConfiguration["host"], $this->_mysqliConfiguration["username"], $this->_mysqliConfiguration["password"], $this->_mysqliConfiguration["database"]);
            if (!$this->_mysqliConfiguration["single"]) {
                return $this->addMoreDatabases("master_db", $tempObject[$this->_mysqliConfiguration["database"]]);
            } else {
                $this->checkMysqliConnectinError($tempObject[$this->_mysqliConfiguration["database"]]);
                $_SESSION["db_1"] = $this->_mysqliConfiguration["database"];
                return $tempObject;
            }
        } catch (Exception $ex) {
            error_log($ex, 3, "error.log");
        }
        return true;
    }

    function addMoreDatabases($master_db, $tempObject) {
        try {
            $sql = "SELECT * FROM `" . $master_db . "`";
            $resultQuerty = $tempObject->query($sql);
            $i = 1;
            while ($row = $resultQuerty->fetch_assoc()) {
                $_SESSION["db_" . $i] = $row["user"];
                $i++;
                $tempObjArray[$row["user"]] = new mysqli($row["host"], $row["username"], $row["password"], $row["db"]);
                $this->checkMysqliConnectinError($tempObjArray[$row["user"]]);
            }
            return $tempObjArray;
        } catch (Exception $ex) {
            error_log($ex, 3, "error.log");
        }
    }

    function checkMysqliConnectinError($connection) {
        if (mysqli_connect_errno($connection)) {
            throw new Exception(mysqli_connect_error());
        }
        return true;
    }

    //query Builder
    public function insert($table, $data) {
        $sql = "INSERT INTO " . $table;
        $t = "( ";
        $t2 = "( ";
        $i = 1;
        foreach ($data as $key => $val) {
            if ($i != count($data)) {
                $t = $t . $key . ",";
                $t2 = $t2 . "'" . $val . "'" . ",";
            } else {
                $t = $t . $key . " )";
                $t2 = $t2 . "'" . $val . "'" . " )";
            }
            $i++;
        }
        return $sql = $sql . " " . $t . " values " . $t2;
        //return $this->adminDB[$db]->query($sql);
    }

    public function insertSpecialChar($table, $data) {
        $sql = "INSERT INTO " . $table;
        $t = "( ";
        $t2 = "( ";
        $i = 1;
        foreach ($data as $key => $val) {
            if ($i != count($data)) {
                $t = $t . "`" . $key . "`" . ",";
                $t2 = $t2 . "'" . $val . "'" . ",";
            } else {
                $t = $t . "`" . $key . "`" . " )";
                $t2 = $t2 . "'" . $val . "'" . " )";
            }
            $i++;
        }
        return $sql = $sql . " " . $t . " values " . $t2;
        //return $this->adminDB[$db]->query($sql);
    }

    public function select($table, $db) {
        return $sql = "SELECT * FROM " . $db . "." . $table . " ";
    }

    public function selectSpacific($data, $table) {
        $sql = "SELECT ";
        $pad = count($data) - 1;
        for ($i = 0; $i < count($data) - 1; $i++) {
            $sql.="`" . $data[$i] . "`, ";
        }
        $sql.="`" . $data[$pad] . "`  FROM " . $table . " ";
        return $sql;
    }

    public function selectDistinct($table, $id) {
        return "SELECT DISTINCT " . $id . " FROM " . $table . " ";
    }

    function selectJoinData($data1, $data2, $jointype, $table, $oncol) {
        $s = "SELECT ";
        foreach ($data1 as $k1 => $d1) {
            foreach ($d1 as $kk1 => $dd1) {
                $s.=$k1 . "." . $dd1 . " , ";
            }
        }
        foreach ($data2 as $k1 => $d1) {
            $i = 1;
            foreach ($d1 as $kk1 => $dd1) {
                if ($i != count($d1)) {
                    $s.=$k1 . "." . $dd1 . " , ";
                } else {
                    $s.=$k1 . "." . $dd1 . " ";
                }$i++;
            }
        }
        $s.=" FROM ";
        $i = 1;
        foreach ($table as $kt => $tb) {
            if ($i != count($table)) {
                $s.= $tb . " " . $jointype . " ";
            } else {
                $s.= $tb . " ";
            }$i++;
        }
        $s.=" ON ";
        $i = 1;
        foreach ($oncol as $kt => $tb) {
            if ($i != count($oncol)) {
                $s.= $kt . "." . $tb . " = ";
            } else {
                $s.= $kt . "." . $tb . " ";
            }$i++;
        }
        return $s;
    }

    public function selectCount($table, $col) {
        return "SELECT count(" . $col . ") FROM " . $table . " ";
    }

    public function selectMax($table, $col) {
        return "SELECT max(" . $col . ") FROM " . $table . " ";
    }

    public function selectSum($table, $col) {
        return "SELECT sum(" . $col . ") FROM " . $table . " ";
    }

    public function limitWithOffset($offset, $limit) {
        return " LIMIT " . $offset . " , " . $limit . " ";
    }

    public function limitWithOutOffset($limit) {
        return " LIMIT " . $limit . " ";
    }

    public function delete($table) {
        return "DELETE FROM " . $table . " ";
    }

    public function _updateINC($data, $table) {
        $sql = " UPDATE  " . $table . " SET ";
        $i = 1;
        foreach ($data as $key => $val) {
            if ($i != count($data)) {
                $sql.=$key . "=" . "" . $val . "" . ", ";
            } else {
                $sql.=$key . "=" . "" . $val . "" . " ";
            }
            $i++;
        }
        return $sql;
    }

    public function updateINC($data, $table) {
        $sql = " UPDATE  " . $table . " SET ";
        $i = 1;
        foreach ($data as $key => $val) {
            if ($i != count($data)) {
                $sql.=$key . "=" . $key . "+" . $val . "" . ", ";
            } else {
                $sql.=$key . "=" . $key . "+" . $val . "" . " ";
            }
            $i++;
        }
        return $sql;
    }

    public function updateDNC($data, $table) {
        $sql = " UPDATE  " . $table . " SET ";
        $i = 1;
        foreach ($data as $key => $val) {
            if ($i != count($data)) {
                $sql.=$key . "=" . $key . "-" . $val . "" . ", ";
            } else {
                $sql.=$key . "=" . $key . "-" . $val . "" . " ";
            }
            $i++;
        }
        return $sql;
    }

    public function update($data, $table) {
        $sql = " UPDATE  " . $table . " SET ";
        $i = 1;
        foreach ($data as $key => $val) {
            if ($i != count($data)) {
                $sql.="`" . $key . "`" . "=" . "'" . $val . "'" . ", ";
            } else {
                $sql.="`" . $key . "`" . "=" . "'" . $val . "'" . " ";
            }
            $i++;
        }
        return $sql;
    }

    //where clouse
    public function orderBy($order, $id) {
        return " ORDER BY " . $id . " " . $order . " ";
    }

    public function whereSingleLike($data) {
        $sql = " WHERE ";
        $i = 1;
        foreach ($data as $key => $val) {
            if ($i == count($data)) {
                $sql.=$key . " LIKE " . "'%" . $val . "%'";
            }
        }
        return $sql;
    }

    public function whereSingleLikeAndArray($data, $data2) {
        $sql = " WHERE ";
        $i = 1;
        foreach ($data as $key => $val) {
            if ($i == count($data)) {
                $sql.=$key . " LIKE " . "'%" . $val . "%'";
            }
        }
        $sql.=" AND ";
        $and = "AND";
        foreach ($data2 as $key => $val) {
            if ($i != count($data)) {
                $sql.=$key . "=" . "'" . $val . "'" . " " . $and . " ";
            } else {
                $sql.=$key . "=" . "'" . $val . "'" . " ";
            }
            $i++;
        }
        return $sql;
    }

    public function whereSearchLike($coloum, $data) {
        $sql = " WHERE CONCAT_WS(";
        $i = 1;
        foreach ($coloum as $val) {
            if ($i == count($coloum)) {
                $sql.=$val;
            } else {
                $sql.=$val . ",";
            }
            $i++;
        }
        $sql.=" ) ";
        $i = 1;
        foreach ($data as $key => $val) {
            if ($i == count($data)) {
                $sql.=" LIKE " . "'%" . $val . "%'";
            }
        }
        return $sql;
    }

    public function searchFullText($coloum, $data) {
        $sql = " WHERE MATCH(";
        $i = 1;
        foreach ($coloum as $val) {
            if ($i == count($coloum)) {
                $sql.=$val;
            } else {
                $sql.=$val . ",";
            }
            $i++;
        }
        $sql.=" ) AGAINST ( ";
        $i = 1;
        foreach ($data as $key => $val) {
            if ($i == count($data)) {
                $sql.=" " . "'" . $val . "'IN NATURAL LANGUAGE MODE )";
            }
        }
        return $sql;
    }

    public function whereSingleIndex($data, $keys, $and) {
        $sql = " WHERE ";
        $i = 1;
        foreach ($data as $key => $val) {
            if ($i != count($data)) {
                $sql.=$keys . "=" . "'" . $val . "'" . " " . $and . " ";
            } else {
                $sql.=$keys . "=" . "'" . $val . "'" . " ";
            }
            $i++;
        }
        return $sql;
    }

    public function where($data, $and) {
        $sql = " WHERE ";
        $i = 1;
        foreach ($data as $key => $val) {
            if ($i != count($data)) {
                $sql.=$key . "=" . "'" . $val . "'" . " " . $and . " ";
            } else {
                $sql.=$key . "=" . "'" . $val . "'" . " ";
            }
            $i++;
        }
        return $sql;
    }

    public function whereWithoutQout($data, $and) {
        $sql = " WHERE ";
        $i = 1;
        foreach ($data as $key => $val) {
            if ($i != count($data)) {
                $sql.=$key . "=" . "" . $val . "" . " " . $and . " ";
            } else {
                $sql.=$key . "=" . "" . $val . "" . " ";
            }
            $i++;
        }
        return $sql;
    }

    public function whereSingle($data) {
        $sql = " WHERE ";
        $i = 1;
        foreach ($data as $key => $val) {
            if ($i == count($data)) {
                $sql.=$key . "=" . "'" . $val . "'";
            }
        }
        return $sql;
    }

    public function whereSingleWithoutQout($data) {
        $sql = " WHERE ";
        $i = 1;
        foreach ($data as $key => $val) {
            if ($i == count($data)) {
                $sql.=$key . "=" . "" . $val . "";
            }
        }
        return $sql;
    }

    public function whereNesQuery($data) {
        $sql = " WHERE ";
        $i = 1;
        foreach ($data as $key => $val) {
            if ($i == count($data)) {
                $sql.=$key . "=" . "(" . $val . ")";
            }
        }
        return $sql;
    }

    public function whereOnlyQuery($data) {
        $sql = "  ";
        $i = 1;
        foreach ($data as $key => $val) {
            if ($i == count($data)) {
                $sql.= "(" . $val . ")";
            }
        }
        return $sql;
    }

    public function whereBetweenDates($colname, $d1, $d2) {
        $sql = " WHERE ";
        $sql.="DATE(" . $colname . ") BETWEEN '" . $d1 . "' AND '" . $d2 . "'";
        return $sql;
    }

    public function whereBetweenDatesID($colname, $d1, $d2, $key, $id) {
        $sql = " WHERE ";
        $sql.="DATE(" . $colname . ") BETWEEN '" . $d1 . "' AND '" . $d2 . "'" . " AND " . $key . "='" . $id . "'";
        return $sql;
    }

    public function whereBetweenDatesArray($colname, $d1, $d2, $data) {
        $sql = " WHERE ";
        $sql.="DATE(" . $colname . ") BETWEEN '" . $d1 . "' AND '" . $d2 . "'" . " AND ";
        $i = 1;
        $and = "AND";
        foreach ($data as $key => $val) {
            if ($i != count($data)) {
                $sql.=$key . "=" . "'" . $val . "'" . " " . $and . " ";
            } else {
                $sql.=$key . "=" . "'" . $val . "'" . " ";
            }
            $i++;
        }
        return $sql;
    }

    public function whereSinglelessthanequal($data) {
        $sql = " WHERE ";
        $i = 1;
        foreach ($data as $key => $val) {
            if ($i == count($data)) {
                $sql.=$key . "<=" . "'" . $val . "'";
            }
        }
        return $sql;
    }

    public function whereSinglegreaterthanequal($data) {
        $sql = " WHERE ";
        $i = 1;
        foreach ($data as $key => $val) {
            if ($i == count($data)) {
                $sql.=$key . ">=" . "'" . $val . "'";
            }
        }
        return $sql;
    }

    

}

//
