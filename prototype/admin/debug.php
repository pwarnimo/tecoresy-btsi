<?php

echo <<< FRM
    <form action="debug.php" method="post">
        <input type="text" id="edtPassword" name="edtPassword">
    </form>
FRM;

$pwd = filter_input(INPUT_POST, "edtPassword");

if (isset($pwd)) {
    $salt = uniqid(mt_rand(), true);
    echo "<pre>USER SALT    -> " . $salt;
    echo "<br>PLAINTEXT PW -> " . $pwd;
    $hash = hash_hmac("sha512", $pwd, $salt);
    echo "<br>HASH IN DB   -> " . $hash . "<pre>";
}