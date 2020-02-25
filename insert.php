<?php
include 'db.php';
include 'function.php';
if (isset($_POST["operation"])) {
    if ($_POST["operation"] == "Add") {
        $image = '';
        if ($_FILES["user_image"]["name"] != '') {
            $image = upload_image();
        }
        $statement = $connection->prepare("
				INSERT INTO users (first_name, email, image,password, roomno,ext)
				VALUES (:first_name, :email, :image,:password, :roomno,:ext)
			");
        $result = $statement->execute(
            array(
                ':first_name' => $_POST["first_name"],
                ':email' => $_POST["email"],
                ':image' => $image,
                ':password' => md5($_POST["password"]),
                ':roomno' => $_POST["roomno"],
                ':ext' => $_POST["ext"],

            )
        );
        if (!empty($result)) {
            echo 'Data Inserted';
        }
    }
    if ($_POST["operation"] == "Edit") {
        $image = '';
        if ($_FILES["user_image"]["name"] != '') {
            $image = upload_image();
        } else {
            $image = $_POST["hidden_user_image"];
        }
        $statement = $connection->prepare(
            "UPDATE users
				SET first_name = :first_name, email = :email, image = :image,password = :password , roomno = :roomno,ext = :ext
				WHERE id = :id
				"
        );
        $result = $statement->execute(
            array(
                ':first_name' => $_POST["first_name"],
                ':email' => $_POST["email"],
                ':image' => $image,
                ':password' => $_POST["password"],
                ':roomno' => $_POST["roomno"],
                ':ext' => $_POST["ext"],
                ':id' => $_POST["user_id"],
            )
        );
        if (!empty($result)) {
            echo 'Data Updated';
        }
    }
}
