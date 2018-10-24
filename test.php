<?php
/**
 * Created by PhpStorm.
 * User: nxphi47
 * Date: 10/24/18
 * Time: 8:42 PM
 */

require_once "php/db_connect.php";
require_once "php/request.php";
echo "hello world <br><br>";

$sql = $GLOBALS['sql'];



$user_insert = "INSERT INTO `users`(`id`, `fname`, `lname`, `uname`, `password`, 
`email`, `pay_name`, `pay_card_num`, `pay_card_expire`, `cv2`, `dev_name`, 
`dev_phone`, `dev_address`, `postal`, `notes`, `admin`) VALUES (
[value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9],
[value-10],[value-11],[value-12],[value-13],[value-14],[value-15],[value-16])";

$user_del = "DELETE FROM `users` WHERE id=1";

$user_update = "UPDATE `users` SET `id`=[value-1],`fname`=[value-2],`lname`=[value-3] WHERE 1";


$order_insert = "INSERT INTO `orders`(`cart_id`, `user_id`, `order_items`, `note`, `total`, `delivery_subtotal`,
 `orders_subtotal`, `dev_name`, `dev_phone`, `dev_address`, `postal`, `pay_name`, `pay_card_num`, 
 `pay_card_expire`, `cv2`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],
 [value-6],[value-7],[value-8],[value-9],[value-10],[value-11],[value-12],[value-13],[value-14],[value-15])";

$user_del = "DELETE FROM `orders` WHERE cart_id=1";

$user_update = "UPDATE `orders` SET `cart_id`=[value-1] WHERE 1";


$menu_insert = "INSERT INTO `menu`(`id`, `title`, `type`, `unit`, `price`, `promoted_price`, 
`note`, `desc`, `ingredients`, `thumbnail`, `images`) VALUES (
[value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],
[value-8],[value-9],[value-10],[value-11])";



function linebreak() {
    echo "<br><br>";
}

// testing
//$fname = "Phi";
//$lname = "Nguyen";
//$uname = "nxphi47";
//$email = "nxphi47@gmail.com";
//$pass = md5("123456");
//$admin = 1;
//
//$query = "INSERT INTO users (fname, lname, uname, password, email, admin) VALUES ('{$fname}', '{$lname}', '{$uname}', '{$pass}', '{$email}', '{$admin}')";
//
//echo "password: {$pass} <br>";
//echo "sql: {$query}";
//
//
//if ($sql->query($query) === TRUE) {
//    echo "New record created successfully";
//} else {
//    echo "Error: " . $query . "<br>" . $sql->error;
//}
//
//echo "<br><br><br>";
//
//
//$fname = "Ha";
//$lname = "Uyen";
//$uname = "hauyen";
//$email = "hauyen@gmail.com";
//$pass = md5("123456");
//
//$query = "INSERT INTO users
//(fname, lname, uname, password, email) VALUES
//('{$fname}', '{$lname}', '{$uname}', '{$pass}', '{$email}')";
//
//echo "password: {$pass} <br>";
//echo "sql: {$query}";
//
//
//if ($sql->query($query) === TRUE) {
//    echo "New record created successfully";
//} else {
//    echo "Error: " . $query . "<br>" . $sql->error;
//}

echo "<br><br><br>";



//$query = "SELECT * FROM users WHERE 1";
//$result = $sql->query($query);
//
//if ($result->num_rows > 0) {
//    // output data of each row
//    while($row = $result->fetch_assoc()) {
////        echo "id: " . $row["id"]. " - Name: " . $row["lname"]. " " . $row["fname"]. "<br>";
//        echo "id: {$row['id']}, lname = {$row['lname']}, fname= {$row['fname']} <br>";
//    }
//} else {
//    echo "0 results";
//}


$accessUser = new AccessUsers();

$all = $accessUser->getAll();

$accessUser->attrs = array(
    "fname"=>"fifi",
    "lname"=>"xuanxuan",
    "uname"=>"xuanphi001",
    "email"=>"xuanphi001@gmail.com",
    "password"=>"123456",
);

echo "---All -- <br><br><br>";
var_dump($all);

linebreak();
echo "--- test insert -- <br><br><br>";

//echo "sql {$accessUser->insert()}";
linebreak();
echo "respose";
var_dump($GLOBALS['response']);

$all = $accessUser->getAll();

linebreak();
echo "---All -- <br><br><br>";
var_dump($all);

linebreak();
echo "---ID 1 -- <br><br><br>";
var_dump($accessUser->getAllById(1));



linebreak();
echo "--- test update --";
$updates = array(
    "id"=>7,
    "fname"=>"Hello world fi",
    "lname"=>"xuan phi",
);
echo $accessUser->updateById($updates['id'], $updates);

linebreak();
echo "---All -- <br><br><br>";
var_dump($all);
var_dump($GLOBALS['response']);


linebreak();
echo "--- GET constraint -- <br><br><br>";
var_dump($all);
var_dump($GLOBALS['response']);




//$sql->close();
?>



