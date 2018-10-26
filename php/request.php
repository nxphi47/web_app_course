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

    public function createNew($user_id) {
        // create empty
        return array();
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
            $out = $value + 0;
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
            if ($key == $this->idName) {
                $value = (int) $value;
            }
            else {
                $value = $value + 0;
            }
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

            array_push($dataArray, $out);
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
            if (in_array($key, $this->requiredKeys) && ($value === "" || $value === null)) {
                $error = "SQL_INSERT: require key: {$key} = {$value}, ".($value == "");
                errorResponse($error);
//                throw new Exception($error);
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
//            else {
//                echo "discard key = {$key}, {$value}";
//            }
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


class AccessCreditCard extends AccessDB {
    public function __construct()
    {
        $this->tableName = "credit_cards";
        $this->idName = "id";
        $this->allKeys = ['user_id', 'pay_name', 'pay_card_num', 'pay_card_expire', 'cv2'];
        $this->requiredKeys = ['user_id', 'pay_name', 'pay_card_num', 'pay_card_expire', 'cv2'];
        $this->hiddenKeys = ['cv2'];
    }

    public static function validateCard($card) {
        return true;
    }
}

class AccessAddress extends AccessDB {
    public function __construct()
    {
        $this->tableName = "addresses";
        $this->idName = "id";
        $this->allKeys = ['user_id', 'dev_name', 'dev_phone', 'dev_address', 'postal'];
        $this->requiredKeys = ['user_id', 'dev_name', 'dev_phone', 'dev_address', 'postal'];
        $this->hiddenKeys = [];
    }

    public static function validateAddress($address) {
        return true;
    }
}


class AccessUsers extends AccessDB
{
    public $currentUser = null;
    public $addressKeys = null;
    public $cardKeys = null;
    public $accessCard = null;
    public $accessAddress = null;

    public function __construct()
    {
        $this->idName = "id";
        $this->tableName = 'users';
        $this->requiredKeys = ['fname', 'lname', 'uname', 'email', 'password'];
        $this->hiddenKeys = ['password'];
        $this->allKeys = [
            'fname', 'lname', 'uname', 'email', 'password',
            'notes', 'admin'
        ];
        $this->addressKeys = ['dev_name', 'dev_phone', 'dev_address', 'postal'];
        $this->cardKeys = ['pay_name', 'pay_card_num', 'pay_card_expire', 'cv2'];
        $this->currentUser = null;

        $this->accessCard = new AccessCreditCard();
        $this->accessAddress = new AccessAddress();
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

    public function loginWithData($data) {
        $_SESSION['user'] = $data;
        $this->currentUser = $data;
    }

    public function loginWithUnamePass($uname, $password) {
        $pass = md5($password);
        $users = $this->getAllByConstraint("uname='{$uname}' AND password='{$pass}'");


        if ($users != null && count($users) > 0) {
            $user = $users[0];
            $_SESSION['user'] = $user;
            $this->currentUser = $user;
            return true;
        } else {
            return false;
        }
    }

    public function autoLogin() {
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
        }
        else {
            $user = null;
        }
        return $user;
    }

    public function extractByKeys($data, $keys) {
        $out = array();
        foreach ($data as $key => $value) {
            if (in_array($key, $keys)) {
                $out[$key] = $value;
            }
        }
        return $out;
    }

    public function insert()
    {
        $ok = parent::insert(); // TODO: Change the autogenerated stub
        echo "ok = $ok";
//        if ($ok) {
        $card = $this->extractByKeys($this->attrs, $this->cardKeys);
        $address = $this->extractByKeys($this->attrs, $this->addressKeys);
        $card['user_id'] = $this->insertedID;
        $address['user_id'] = $this->insertedID;
        var_dump($this->attrs);
        var_dump($card);
        var_dump($address);
        if (AccessCreditCard::validateCard($card)) {
            $this->accessCard->attrs = $card;
            $this->accessCard->insert();
        }
        if (AccessAddress::validateAddress($address)) {
            $this->accessAddress->attrs = $address;
            $this->accessAddress->insert();
        }
//        }
        return $ok;
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

    public function normalize_value($key, $value)
    {
        if (in_array($key, ['price', 'promoted_price'])) {
            $value = (float) $value;
        }
        return parent::normalize_value($key, $value); // TODO: Change the autogenerated stub
    }

    public function denormalize_value($key, $value)
    {
        $value = parent::denormalize_value($key, $value); // TODO: Change the autogenerated stub
        if (in_array($key, ['price', 'promoted_price'])) {
            $value = (float) $value;
        }
//        var_dump(array($key=>$value));
        return $value;
    }

}

class AccessOrderItems extends AccessDB {
    public function __construct()
    {
        $this->tableName = "order_items";
        $this->idName = 'id';
        $this->allKeys = ['user_id', 'cart_id', 'item_id', 'quantity', 'comment'];
        $this->requiredKeys = ['user_id', 'cart_id', 'item_id', 'quantity'];
    }

    public function normalize_value($key, $value)
    {
        return parent::normalize_value($key, $value); // TODO: Change the autogenerated stub
    }

    public function denormalize_value($key, $value)
    {
        $value = parent::denormalize_value($key, $value); // TODO: Change the autogenerated stub
        if (in_array($value, ['user_id', 'cart_id', 'item_id', 'quantity'])) {
            $value = (int) $value;
        }
        return $value;
    }
}

class AccessOrders extends AccessDB {
    public $accessMenu = null;
    public $accessUser = null;
    public $accessOrderItems = null;
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
            'pay_name', 'pay_card_num', 'pay_card_expire', 'cv2', "is_paid"
        ];
        $this->accessMenu = new AccessMenu();
        $this->accessUser = new AccessUsers();
        $this->accessOrderItems = new AccessOrderItems();
    }

    public function item_to_key($item) {
        return $item['id'];
    }

    public function normalize_value($key, $value)
    {
        if ($key == "order_items") {
            // expect value = array(item=>array(item...), quantity=...)
            // output = "item=item_id,quantity=xxx;item=item_2_id,quantity=xxx"
            // FIXME: old string codes
            $out = array();
            foreach ($value as $itemset) {
                $item = $this->item_to_key($itemset['item']);
                $quantity = $itemset['quantity'];
                $comment = $itemset['comment'];
                array_push($out, "item={$item}#quantity={$quantity}#comment={$comment}");
            }
            $value = implode("@", $out);
        }
        return parent::normalize_value($key, $value); // TODO: Change the autogenerated stub
    }

    public function denormalize_value($key, $value)
    {
        $out = parent::denormalize_value($key, $value); // TODO: Change the autogenerated stub
        if ($key == 'cv2') {
            $out = "";
        }
        else if ($key == 'order_items') {
            if ($out == "") {
                return array();
            }
            $parts = explode("@", $out);
            $orders = array();
            foreach ($parts as $val) {
                $atts = explode("#", $val);
                $order = array();
                foreach ($atts as $kvpair) {
                    $pair = explode("=", $kvpair);
                    if (is_numeric($pair[1]) or $pair[0] == "item") {
                        $order[$pair[0]] = (int) $pair[1];
                    }
                    else {
                        $order[$pair[0]] = $pair[1];
                    }
                }

                $item = $this->accessMenu->getAllById($order['item']);
                $order['item'] = $item;
                array_push($orders, $order);
            }
            $out = $orders;
        }

        return $out;
    }

    public function createNew($user_id)
    {

        $data = array();
        foreach ($this->allKeys as $key) {
            $data[$key] = $this->denormalize_value($key, "");
        }
        $data['user_id'] = $user_id;
        $data['cart_id'] = 0;
        $data['total'] = 0;
        $data['order_items'] = [];
        $data['delivery_subtotal'] = 0;
        $data['orders_subtotal'] = 0;
        $data['is_paid'] = 0;

        return $data;
    }

    public function getUnpaidCartByUser($user_id) {
        $query = "user_id={$user_id}";
        $carts = $this->getAllByConstraint($query);
        if (count($carts) > 0) {
            $cart = $carts[0];
            return $cart;
        }
        else {
            $cart = $this->createNew($user_id);
            return $cart;
        }
    }

    public function updateCurrentCart($cart, $user) {
        $_SESSION['card'] = $cart;
        return $cart;
    }

    public function insert()
    {
        $ok = parent::insert(); // TODO: Change the autogenerated stub
        if ($ok) {
            $order_items = $this->attrs['order_items'];
            $orders = array();
            foreach ($order_items as $item) {
                $item['cart_id'] = $this->insertedID;
                $item['user_id'] = $this->attrs['user_id'];
                $item['item_id'] = $item['item']['id'];
                unset($item['item']);
                array_push($orders, $item);
            }
            $this->accessOrderItems->attrs = $orders;
            $this->accessOrderItems->insertMany();
        }
        return $ok;
    }


    public function updateCurrentCartWithAccount($cart, $user) {
        $user_id = $user['id'];
        $cart_id = $cart['cart_id'];
        unset($cart['cart_id']);
        $cart['user_id'] = $user_id;
        if ($cart_id == 0) {
            $this->attrs = $cart;
            if ($this->insert()) {
                $inserted_cart = $this->getAllById($this->insertedID);
                $out_cart = $inserted_cart;
            }
            else {
                errorResponse("DB add new cart error.!");
                $out_cart = null;
            }
        } else {
            $this->attrs = $cart;
            $this->updateById($cart_id, $cart);
            $inserted_cart = $this->getAllById($cart_id);
            $out_cart = $inserted_cart;
        }
        return $out_cart;
    }

    public function updateCurrentCartNoAccount($cart) {
        if (isset($_SESSION['cart'])) {
            $_SESSION['cart'] = $cart;
        }
        else {
            $_SESSION['cart'] = $this->createNew(0);
        }
        return $_SESSION['cart'];
    }

    public function verifyCartPay($cart) {
        $valid = true;
//        'pay_name', 'pay_card_num', 'pay_card_expire', 'cv2', "is_paid"
        $valid &= (strlen($cart['cv2']) > 0 && is_numeric($cart['cv2']));
        $valid &= (strlen($cart['pay_name']) > 0);
        $valid &= (strlen($cart['pay_card_num']) > 0 && is_numeric($cart['cv2']));
        $valid &= (strtotime($cart['pay_card_expire']) - time() > 3 * 24 * 3600);
        return $valid;
    }

    public function verifyDeliver($cart) {
//        'dev_name', 'dev_phone', 'dev_address', 'postal',
        $valid = true;
        $valid &= (strlen($cart['dev_name']) > 0);
        $valid &= (strlen($cart['dev_address']) > 0);
        $valid &= (strlen($cart['dev_phone']) > 0 && is_numeric($cart['dev_phone']));
        $valid &= (strlen($cart['postal']) > 0 && is_numeric($cart['postal']));
        return $valid;
    }

    public function checkout($cart) {
        // here verify the card number and stuff
        if (!$this->verifyDeliver($cart)) {
            errorResponse("Delivery Info invalid!");
        }
        if (!$this->verifyCartPay($cart)) {
            errorResponse("Credit card Info invalid!");
        }

        $cart['is_paid'] = 1;
//        $cart_id = $cart['cart_id'];
//        unset($cart['cart_id']);
//        $this->attrs = $cart;
//        $this->updateById($cart_id, $cart);
//        $inserted_cart = $this->getAllById($cart_id);
//        $out_cart = $inserted_cart;
        // do insert
//        var_dump($cart);
        $this->attrs = $cart;
        $ok = $this->insert();
        $cart['card_id'] = $this->insertedID;

        return $cart;
    }

    public function retrieveOrderItems($cart) {
        $order_items = $this->accessOrderItems->getAllByConstraint("cart_id={$cart['cart_id']}");
        return $order_items;
    }

    public function getAll()
    {
        $carts = parent::getAll(); // TODO: Change the autogenerated stub
        $new_carts = array();
        foreach ($carts as $cart) {
            $cart['order_items'] = $this->retrieveOrderItems($cart);
            array_push($new_carts, $cart);
        }
        return $new_carts;
    }

    public function getAllById($id)
    {
        $cart = parent::getAllById($id); // TODO: Change the autogenerated stub
        $cart['order_items'] = $this->retrieveOrderItems($cart);
        return $cart;
    }

    public function getAllByConstraint($constraint)
    {
        $carts = parent::getAllByConstraint($constraint); // TODO: Change the autogenerated stub
        $new_carts = array();
        foreach ($carts as $cart) {
            $cart['order_items'] = $this->retrieveOrderItems($cart);
            array_push($new_carts, $cart);
        }
        return $new_carts;
    }

    public function updateById($id, $arr)
    {
        $ok = parent::updateById($id, $arr); // TODO: Change the autogenerated stub
        if ($ok) {
            if (array_key_exists("order_items", $arr)) {
                $order_items = $arr['order_items'];
                foreach ($order_items as $order_item) {
                    $id = $order_item['id'];
                    unset($order_item['id']);
                    $this->accessOrderItems->updateById($id, $order_item);
                }
            }
        }
        return $ok;
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
        $this->accessUsers = new AccessUsers();
    }

    public function normalize_value($key, $value)
    {
        if ($key == "user_id") {
            $value = $value['user_id'];
        }
        return parent::normalize_value($key, $value); // TODO: Change the autogenerated stub
    }

    public function denormalize_value($key, $value)
    {
        $value = parent::denormalize_value($key, $value); // TODO: Change the autogenerated stub
        if ($key == "user_id") {
            $value = $this->accessUsers->getAllById($value);
        }
        return $value;
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