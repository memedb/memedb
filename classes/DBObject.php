<?php
class DBObject {

    function __construct($idType, $table) {
        $this->idType = $idType;
        $this->table = $table;
    }
    
    public function updateFields() {
        $keys = func_get_args();
        $keysExtra = array();
        $numKeys = func_num_args();
        $updateVals = "";

        for ($i = 0; $i < $numKeys; $i++) {
            $keysExtra[$i] = $keys[$i]."=?";
        }

        $updateVals = implode(",", $keysExtra);

        $conn = $GLOBALS['conn'];
        $stmtText = "UPDATE {$this->table} SET {$updateVals} WHERE `id`=?";
        logger($stmtText);
        $stmt = $conn->prepare($stmtText);

        $fieldTypes = "";

        $params = array();
        $values = array();

        for ($i = 0; $i < $numKeys; $i++) {
            $values[$i] = get_object_vars($this)[$keys[$i]];
            switch (gettype($values[$i])) {
            case "integer":
                $fieldTypes = $fieldTypes."i";
                break;
            case "string":
                $fieldTypes = $fieldTypes."s";
                break;
            case "array":
                $fieldTypes = $fieldTypes."s";
                $values[$i] = implode(",", $values[$i]);
                $values[$i] = substr($values[$i], 0, strlen($values[$i]));
                break;
            }
            $params = array_merge($params, array(&$values[$i]));
        }

        $params = array_merge(array($fieldTypes.$this->idType), $params);

        $params = array_merge($params, array(&$this->id));

        call_user_func_array(array($stmt, "bind_param"), $params);
        $stmt->execute();
    }

    public function delete() {
        $conn = $GLOBALS['conn'];
        $stmt = $conn->prepare("DELETE FROM {$this->table} WHERE `id`=?");
        logger("DELETE FROM {$this->table} WHERE `id`=?");
        $stmt->bind_param($this->idType, $this->id);
        $stmt->execute();
    }

}
?>