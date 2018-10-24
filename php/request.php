<?php
/**
 * Created by PhpStorm.
 * User: nxphi47
 * Date: 10/24/18
 * Time: 10:48 PM
 */

$GLOBALS['response'] = new stdClass();
$GLOBALS['response']->isSuccess = true;
$GLOBALS['response']->message = "";
$GLOBALS['response']->data = new stdClass(); // this will contain all data response

function errorResponse($mess)
{
    $GLOBALS['response']->isSuccess = false;
    $GLOBALS['response']->message = $GLOBALS['response']->message . "||<error>" . $mess . "\n ";
}

function appendResponse($mess)
{
    if (is_array($mess)) {
        $mess = json_encode($mess);
    }
    $GLOBALS['response']->message = $GLOBALS['response']->message . "||<info>" . $mess . "\n ";
}

function addDataResponse($data)
{
    $GLOBALS['response']->data = $data;
}


function outputResponseJSON()
{
    //for testing
//	print_r($GLOBALS['response']);
    echo json_encode($GLOBALS['response']);
}

function finishRequest($resData)
{
    addDataResponse($resData);
    outputResponseJSON();
    exit(1);
}


class AccessDB
{
//  TODO: Must override in subclass
    public $idName = "id";
    public $attrs = array();
    public $tableName = "";
    public $insertedID = -1;
    public $response = null;
    public $fileUploader; // FIXME: need to be specify on sub-class

    public $requiredKeys = array();
    public $hiddenKeys = array();
    public $allKeys = array();

//    public $allKeys = ['sp_id', 'img_id', 'bc_id', 'ref_id', 'ref_type', 'pos_x', 'pos_y', 'pos_z', 'aly_type', 'aly_type_other', 'aly_instrument',
//        'aly_instrument_other', 'aly_analyst', 'aly_analyst_other', 'aly_feature', 'aly_cond', 'aly_comment', 'ele_list',
//        'ele_unit', 'ele_value', 'SiO2',
//        'TiO2', 'Al2O3', 'Fe2O3', 'FeO', 'MnO', 'MgO', 'CaO', 'Na2O', 'K2O', 'P2O5', 'lost_ignit', 'Cs', 'Rb', 'Ba', 'Th',
//        'U', 'Pb', 'Ta', 'Nb', 'Sr', 'Hf', 'Zr', 'Y', 'La', 'Ce', 'Pr', 'Nd', 'Sm', 'Eu', 'Gd', 'Tb', 'Dy', 'Ho',
//        'Er', 'Tm', 'Yb', 'Lu', 'Cu', 'Zn', 'Sc', 'V', 'Cr', 'Co', 'Ni', 'H2O', 'CO2', 'Cl', 'S', '18O', '87Sr_86Sr',
//        '87Rb_86Sr', '143Nd_144Nd', '147Sm_144Nd', '206Pb_204Pb', '207Pb_204Pb', '208Pb_204Pb', '176Hf_177Hf',
//        '238U_232Th', '238U_230Th', '230Th_238U', '230Th_232Th', '234U_238U', '231Pa_235U', '226Ra_230Th',
//        '226Ra', '226Ra_210Po', '210Po', '10Be_9Be'];

    function __construct()
    {
        // sub-class have to define there own attrs, required key
        $this->idName = "id";
//		$this->fileUploader = new FileUploader();
        $this->response = $GLOBALS['response'];
        $this->attrs = array();
    }

    public function setInsertedID($insertedID)
    {
        $this->insertedID = $insertedID;
    }


    // clear all data
    public function clear()
    {
        foreach ($this->attrs as $item) {
            $item = "";
        }
    }

    public function normalize_key($key) {
        return "`$key`";
    }

    public function normalize_value($key, $value) {
        if (is_numeric($value)) {
            $out = $value;
        }
        else if (is_array($value)) {
            $out = implode(",", $value);
        }
        else {
            $out = "'{$value}'";
        }
        return $out;
    }

    public function denormalize_value($key, $value) {
        if (is_numeric($value)) {
            $value = $value + 0;
        } else {
            // FIXME: temporary solution, convert all ", \" -> " and then to \"
            $value = str_replace('\"', '"', $value);
            $value = str_replace('"', '\"', $value);
        }
        return $value;
    }

    // ---- GET FUNCTION FAMILY --------
    public function getAll()
    {
        $sql = "SELECT * FROM $this->tableName";
        $result = mysqli_query($GLOBALS['conn'], $sql);
        // change to object
        $dataArray = array();
        foreach ($result as $item) {
            if (!$item) {
                return null;
            }
            $out = [];
            foreach ($item as $key=>$value) {
                $out[$key] = $this->denormalize_value($key, $value);
            }

            array_push($dataArray, $item);
        }
        return $dataArray;
    }

    public function getAllById($id)
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE {$this->idName}={$id}";
        $result = mysqli_query($GLOBALS['conn'], $sql);
        if ($result) {
            $item = mysqli_fetch_assoc($result);
            if (!$item) {
                return null;
            }
            $out = [];
            foreach ($item as $key=>$value) {
                $out[$key] = $this->denormalize_value($key, $value);
            }
            return $out;
        } else {
            errorResponse("SQL: getAllById " . $this->tableName . " id: " . $id . " failed:[ " . mysqli_error($GLOBALS['conn']) . ']');
            return null;
        }
    }

    public function getAllByConstraint($constraint)
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE {$constraint}";
        $result = mysqli_query($GLOBALS['conn'], $sql);
        if ($result) {
            $dataArray = array();
            foreach ($result as $item) {
                if (!$item) {
                    return null;
                }
                $out = [];
                foreach ($item as $key=>$value) {
                    $out[$key] = $this->denormalize_value($key, $value);
                }
                array_push($dataArray, $out);
            }
            return $dataArray;
        } else {
            errorResponse("SQL: getAllByConstraint " . $this->tableName . " constraint: " . $constraint . " failed:[ " . mysqli_error($GLOBALS['conn']) . ']');
            return null;
        }
    }


    //  --- INSERT FAMILY -----------
    public function insert()
    {
        $attributes = array();
        $values = array();
        foreach ($this->attrs as $key => $value) {
            if (in_array($key, $this->requiredKeys) && ($value == "" || $value === null)) {
                $error = "SQL_INSERT: require key: " . $key;
                errorResponse($error);
                throw new Exception($error);
            }
            if (!in_array($key, $this->allKeys)) {
                continue;
            }
            array_push($attributes, $this->normalize_key($key));
            array_push($values, $this->normalize_value($key, $value));
        }
        $att_sql = implode(', ', $attributes);
        $val_sql = implode(', ', $values);

        $sql = "INSERT INTO {$this->tableName} ({$att_sql}) VALUES ({$val_sql})";
        $result = mysqli_query($GLOBALS['conn'], $sql);
        if (!$result) {
            errorResponse("SQL: insert " . $this->tableName . " fail: [" . mysqli_error($GLOBALS['conn']) . ']');
            errorResponse("SQL: insert query: [" . $sql . ']');
            return false;
        } else {
            $this->setInsertedID(mysqli_insert_id($GLOBALS['conn']));
            return true;
        }
    }

    public function insertMany() {
        // attrs is arrays of array
        $sql_rows = array();
        foreach ($this->attrs as $row) {
            $atts = array();
            $vals = array();
            foreach ($row as $key => $value) {
                if (in_array($key, $this->requiredKeys) && ($value == "" || $value === null)) {
                    $error = "SQL_INSERT: require key: " . $key;
                    errorResponse($error);
                    throw new Exception($error);
                }
                array_push($atts, $this->normalize_key($key));
                array_push($vals, $this->normalize_value($key, $value));
            }
            $att_sql = implode(', ', $atts);
            $val_sql = implode(', ', $vals);
            $sql_row = "INSERT INTO {$this->tableName} ({$att_sql}) VALUES ({$val_sql})";
            array_push($sql_rows, $sql_row);
        }

        $sql = implode(";", $sql_rows);
        $result = mysqli_multi_query($GLOBALS['conn'], $sql);
        if (!$result) {
            errorResponse("SQL: insert " . $this->tableName . " fail: [" . mysqli_error($GLOBALS['conn']) . ']');
            errorResponse("SQL: insert query: [" . $sql . ']');
            return false;
        } else {
            $this->setInsertedID(mysqli_insert_id($GLOBALS['conn']));
            return true;
        }
    }

    // UPDATE FUNCTION -----------------------------------------------------
    public function updateById($id, $arr)
    {
        return $this->updateByConstraint("{$this->idName}={$id}", $arr);
    }

    public function updateByConstraint($constraint, $arr)
    {
        $atts = [];
        foreach ($arr as $key=>$value) {
            if (in_array($key, $this->allKeys) && $key != $this->idName) {
                array_push($atts, "{$this->normalize_key($key)}={$this->normalize_value($key, $value)}");
            }
            else {
                echo "discard key = {$key}, {$value}";
            }
        }
        $att_sql = implode(", ", $atts);
        $sql = "UPDATE {$this->tableName} SET {$att_sql} WHERE {$constraint}";
        return $this->updateToDB($sql);
    }

    private function updateToDB($sql)
    {
        $result = mysqli_query($GLOBALS['conn'], $sql);
        if ($result) {
            $this->setInsertedID(mysqli_insert_id($GLOBALS['conn']));
            return true;
        } else {
            errorResponse("SQL: update $this->tableName [" . mysqli_error($GLOBALS['conn']) . ']');
            errorResponse("SQL query: $sql");
            return false;
        }
    }

}


class AccessUsers extends AccessDB
{
    public function __construct()
    {
        $this->idName = "id";
        $this->tableName = 'users';
        $this->requiredKeys = ['fname', 'lname', 'uname', 'email', 'password'];
        $this->hiddenKeys = ['password'];
        $this->allKeys = [
            'fname', 'lname', 'uname', 'email', 'password',
            'pay_name', 'pay_card_num', 'pay_card_expire', 'cv2', 'dev_name',
            'dev_phone', 'dev_address', 'postal', 'notes', 'admin'
        ];
    }

    public function normalize_value($key, $value)
    {
        if ($key == 'password') {
            $value = md5($value);
        }
        $out = parent::normalize_value($key, $value); // TODO: Change the autogenerated stub
        return $out;
    }

    public function denormalize_value($key, $value)
    {
        $out = parent::denormalize_value($key, $value); // TODO: Change the autogenerated stub
        if ($key == 'password') {
            $out = "";
        }
        return $out;
    }
}


class AccessOrders extends AccessDB {
    public function __construct()
    {
        $this->idName = "cart_id";
        $this->tableName = 'orders';
        $this->requiredKeys = ['user_id', 'order_items', 'total', 
            'delivery_subtotal', 'orders_subtotal'];
        $this->hiddenKeys = ['cv2'];
        $this->allKeys = [
            'user_id', 'order_items', 'note', 'total', 'delivery_subtotal', 'orders_subtotal', 
            'dev_name', 'dev_phone', 'dev_address', 'postal', 
            'pay_name', 'pay_card_num', 'pay_card_expire', 'cv2'
        ];
    }
    public function denormalize_value($key, $value)
    {
        $out = parent::denormalize_value($key, $value); // TODO: Change the autogenerated stub
        if ($key == 'cv2') {
            $out = "";
        }
        return $out;
    }
}


class AccessMenu extends AccessDB {
    public function __construct()
    {
        $this->idName = "id";
        $this->tableName = 'menu';
        $this->requiredKeys = ['title', 'type', 'unit', 
            'price', 'promoted_price', 'desc', 'thumbnail', 'images'];
        $this->hiddenKeys = [];
        $this->allKeys = [
            'id', 'title', 'type', 'unit', 'price', 'promoted_price',
            'note', 'desc', 'ingredients', 'thumbnail', 'images'
        ];
    }

}

class AccessHighLights extends AccessDB {
    /*
     * INSERT INTO 'highlights'('id', 'item_id', 'notes') VALUES ([value-1],[value-2],[value-3])
     * */
    public function __construct()
    {
        $this->idName = "id";
        $this->tableName = 'highlights';
        $this->allKeys = ['item_id', 'notes'];
    }

}

class AccessFeedbacks extends AccessDB {
    public function __construct()
    {
//        INSERT INTO 'feedbacks'('id', 'user_id', 'stars', 'note') VALUES ([value-1],[value-2],[value-3],[value-4])
        $this->idName = "id";
        $this->tableName = 'feedbacks';
        $this->allKeys = ['user_id', 'stars', 'note'];
        $this->requiredKeys = ['user_id', 'stars', 'note'];
    }
}

class AccessJobApp extends AccessDB {
//INSERT INTO 'job_app'('id', 'fname', 'lname', 'ic', 'note', 'experience', 'phone', 'email') VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8])
    public function __construct()
    {
        $this->idName = "id";
        $this->tableName = 'job_app';
        $this->allKeys = ['fname', 'lname', 'ic'];
        $this->requiredKeys = [
            'fname', 'lname', 'ic', 'note', 'experience', 'phone', 'email'];
    }
}

class AccessPromotions extends AccessDB {
    public function __construct()
    {
        // INSERT INTO 'promotions'('id', 'title', 'note', 'item_id', 'itemset', 'price') VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6])
        $this->idName = "id";
        $this->tableName = 'promotions';
        $this->allKeys = ['title', 'note', 'price'];
        $this->requiredKeys = [
            'title', 'note', 'item_id', 'itemset', 'price'];
    }
}

class AccessQuestions extends AccessDB {
    public function __construct()
    {
        // INSERT INTO 'questions'('id', 'user_id', 'name', 'question') VALUES ([value-1],[value-2],[value-3],[value-4])
        $this->idName = "id";
        $this->tableName = 'questions';
        $this->allKeys = ['question'];
        $this->requiredKeys = [
            'user_id', 'name', 'question'];
    }

}



?>