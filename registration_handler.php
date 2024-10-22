<?php

if (session_status() === PHP_SESSION_ACTIVE) {
    session_destroy();
}

$errors = array(); // Array to store error messages


if (isset($_POST['register'])) {

    $username = $_POST['username'] ?? '';
    $username = filter_var($username, FILTER_SANITIZE_STRING);

    $munic_name = $_POST['municipality_name'] ?? '';
    $munic_name = filter_var($munic_name, FILTER_SANITIZE_STRING);

    $email = $_POST['email'] ?? '';
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    $cont_num = $_POST['contact_number'] ?? '';
    $cont_num = filter_var($cont_num, FILTER_SANITIZE_STRING);

    $pass = $_POST['password'] ?? '';
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    // Hash the password using bcrypt
    $hashed_pass = password_hash($pass, PASSWORD_BCRYPT);

    $cpass = $_POST['cpass'] ?? '';
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    $utype = $_POST['utype'] ?? '';
    $utype = filter_var($utype, FILTER_SANITIZE_STRING);

    $brgy_name = $_POST['barangay_name'] ?? '';
    $brgy_name = filter_var($brgy_name, FILTER_SANITIZE_STRING);


    $fname = $_POST['first_name'] ?? '';
    $fname = filter_var($fname, FILTER_SANITIZE_STRING);
    $lname = $_POST['last_name'] ?? '';
    $lname = filter_var($lname, FILTER_SANITIZE_STRING);


    if ($utype === 'admin') {
        $stmt = $conn->prepare("SELECT id FROM municipalities WHERE municipality_name = :municipality_name");
        $stmt->bindParam(':municipality_name', $munic_name, PDO::PARAM_STR);
        $stmt->execute();
        $existing_municipality = $stmt->fetch();

        if ($pass !== $cpass) {
            $errors['password'] = "Password does not match the confirmed password. Please try again.";
            $pass = '';
            $cpass = '';
        }
        if (!$existing_municipality) {
            $stmt = $conn->prepare("INSERT INTO municipalities (municipality_name) VALUES (:municipality_name)");
            $stmt->bindParam(':municipality_name', $munic_name, PDO::PARAM_STR);
            $stmt->execute();
        } else {
            $errors['municipality'] = "The selected Municipality has already been registered.<br> Please contact Admin.";
        }

        //Email Checker
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $existing_email = $stmt->fetch();

        if ($existing_email) {
            $errors['email'] = "Email already exists. Please choose a different email address.";
            // You should consider handling this error appropriately, not just exit.
        }
    }


    if ($utype === 'user') {
        $stmt = $conn->prepare("SELECT id FROM barangays WHERE barangay_name = :barangay_name AND municipality_id IN (SELECT id FROM municipalities WHERE municipality_name = :municipality_name)");
        $stmt->bindParam(':barangay_name', $brgy_name, PDO::PARAM_STR);
        $stmt->bindParam(':municipality_name', $munic_name, PDO::PARAM_STR);
        $stmt->execute();
        $existing_barangay = $stmt->fetch();

        if ($pass !== $cpass) {
            $errors['password'] = "Password does not match the confirmed password. Please try again.";
            $pass = '';
            $cpass = '';
        }

        if ($existing_barangay) {
            $errors['barangay'] = "The selected Barangay is already existing for that Municipality.";
        }

        $stmt = $conn->prepare("SELECT id FROM municipalities WHERE municipality_name = :municipality_name");
        $stmt->bindParam(':municipality_name', $munic_name, PDO::PARAM_STR);
        $stmt->execute();
        $existing_municipality = $stmt->fetch();

        if (!$existing_municipality) {
            $errors['municipality'] = "Municipality could not be found or has not registered yet. Please check your selected Municipality.";
        }

        //Email Checker
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $existing_email = $stmt->fetch();

        if ($existing_email) {
            $errors['email'] = "Email already exists. Please choose a different email address.";
        }


        $stmt = $conn->prepare("INSERT INTO barangays (municipality_id, barangay_name) 
                            SELECT :municipality_id, :barangay_name
                            FROM dual
                            WHERE NOT EXISTS (SELECT id FROM barangays WHERE barangay_name = :barangay_name)");
        $stmt->bindParam(':municipality_id', $existing_municipality['id'], PDO::PARAM_INT);
        $stmt->bindParam(':barangay_name', $brgy_name, PDO::PARAM_STR);
        $stmt->execute();

        $barangay_id = $conn->lastInsertId();
    }


    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO users (username, password, email, contact_number, user_type, municipality_id, barangay_id, first_name, last_name) 
                        VALUES (:username, :password, :email, :contact_number, :user_type, 
                        (SELECT id FROM municipalities WHERE municipality_name = :municipality_name),
                        :barangay_id, :first_name, :last_name)");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashed_pass, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':contact_number', $cont_num, PDO::PARAM_STR);
        $stmt->bindParam(':user_type', $utype, PDO::PARAM_STR);
        $stmt->bindParam(':municipality_name', $munic_name, PDO::PARAM_STR);
        $stmt->bindParam(':barangay_id', $barangay_id, PDO::PARAM_INT);
        $stmt->bindParam(':first_name', $fname, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $lname, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $errors['registration'] = "User registration successful. Proceed to Login";
            $username = $munic_name = $email = $cont_num = $pass = $cpass = $utype = $brgy_name = $fname = $lname = '';
        } else {
            $errors['registration'] = "User registration failed. Please try again later.";
        }
    }
}
