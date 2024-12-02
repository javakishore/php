<!-- CREATE DATABASE student;

USE student;

CREATE TABLE IF NOT EXISTS studentdetails (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name CHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL,
    mobile BIGINT(20) NOT NULL,
    gender ENUM('m','f') NOT NULL,
    hobbies VARCHAR(100) NOT NULL,
    dob DATE NOT NULL,
    address TEXT NOT NULL,
    profilePic VARCHAR(255) NOT NULL,
    registrationDate DATETIME NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY email (email)
); -->












<?php
// Database connection
$con = new mysqli("localhost", "root", "", "student");

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Message variable
$msg = "";

// Form submission handling
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $name = $_POST['n'];
    $email = $_POST['e'];
    $password = password_hash($_POST['p'], PASSWORD_BCRYPT); // Secure password storage
    $mobile = $_POST['m'];
    $gender = $_POST['g'];
    $hobbies = isset($_POST['hobb']) ? implode(",", $_POST['hobb']) : '';
    $dob = $_POST['yy'] . "-" . $_POST['mm'] . "-" . $_POST['dd'];
    $address = $_POST['add'];
    $profilePic = $_FILES['pic']['name'];

    // Check if email already exists
    $stmt = $con->prepare("SELECT email FROM studentdetails WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) 
    {
        $msg = "<font color='red'>Email $email already exists. Choose another email.</font>";
    }
    else 
    {
        // Move uploaded file
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $targetFilePath = $targetDir . basename($profilePic);
        if (move_uploaded_file($_FILES['pic']['tmp_name'], $targetFilePath)) 
        {
            // Insert data into the database
            $stmt = $con->prepare("INSERT INTO studentdetails (name, email, password, mobile, gender, hobbies, dob, address, profilePic, registrationDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
            $stmt->bind_param("sssssssss", $name, $email, $password, $mobile, $gender, $hobbies, $dob, $address, $profilePic);

            if ($stmt->execute()) 
            {
                $msg = "<font color='blue'>Your data has been saved successfully.</font>";
            } else 
            {
                $msg = "<font color='red'>Error saving data: " . $stmt->error . "</font>";
            }
        } 
        else
        {
            $msg = "<font color='red'>Error uploading profile picture.</font>";
        }
    }

    $stmt->close();
}

$con->close();
?>



















<!-- <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registration Form</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f9f9f9; }
        form { margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; background: #fff; max-width: 600px; }
        input, textarea, select { width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 5px; }
        input[type="radio"], input[type="checkbox"] { width: auto; margin-right: 5px; }
        button { padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background-color: #45a049; }
        .message { margin-bottom: 20px; text-align: center; }
    </style>
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
        <div class="message"><?php echo $msg; ?></div>
        <label for="name">Name:</label>
        <input type="text" id="name" name="n" required pattern="[a-zA-Z ]*">

        <label for="email">Email:</label>
        <input type="email" id="email" name="e" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="p" required>

        <label for="mobile">Mobile:</label>
        <input type="text" id="mobile" name="m" required pattern="[0-9]{10}">

        <label for="address">Address:</label>
        <textarea id="address" name="add" required></textarea>

        <label>Gender:</label>
        <input type="radio" name="g" value="m" required> Male
        <input type="radio" name="g" value="f" required> Female

        <label>Hobbies:</label>
        <input type="checkbox" name="hobb[]" value="Cricket"> Cricket
        <input type="checkbox" name="hobb[]" value="Singing"> Singing
        <input type="checkbox" name="hobb[]" value="Dancing"> Dancing

        <label for="dob">Date of Birth:</label>
        <select name="mm" required>
            <option value="">Month</option>
            <?php for ($i = 1; $i <= 12; $i++) { echo "<option value='$i'>$i</option>"; } ?>
        </select>
        <select name="dd" required>
            <option value="">Day</option>
            <?php for ($i = 1; $i <= 31; $i++) { echo "<option value='$i'>$i</option>"; } ?>
        </select>
        <select name="yy" required>
            <option value="">Year</option>
            <?php for ($i = 1900; $i <= 2015; $i++) { echo "<option value='$i'>$i</option>"; } ?>
        </select>

        <label for="pic">Profile Picture:</label>
        <input type="file" id="pic" name="pic" required>

        <button type="submit">Register</button>
        <button type="reset">Reset</button>
    </form>
</body>
</html> -->



















<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }

        form {
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background: #fff;
            max-width: 600px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .dob-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dob-container select {
            width: auto;
            flex: 1;
        }

        input[type="radio"], input[type="checkbox"] {
            width: auto;
            margin-right: 5px;
        }

        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: red;
        }

        .message {
            margin-bottom: 20px;
            text-align: center;
            color: #ff0000;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
        <div class="message"><?php echo isset($msg) ? $msg : ''; ?></div>

        <label for="name">Name:</label>
        <input type="text" id="name" name="n" required pattern="[a-zA-Z ]*">

        <label for="email">Email:</label>
        <input type="email" id="email" name="e" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="p" required>

        <label for="mobile">Mobile:</label>
        <input type="text" id="mobile" name="m" required pattern="[0-9]{10}">

        

        <label>Gender:</label>
        <div>
            <input type="radio" name="g" value="m" required> Male
            <input type="radio" name="g" value="f" required> Female
        </div>

        <label>Hobbies:</label>
        <div>
            <input type="checkbox" name="hobb[]" value="Cricket"> Cricket
            <input type="checkbox" name="hobb[]" value="Singing"> Singing
            <input type="checkbox" name="hobb[]" value="Dancing"> Dancing
        </div>

        <label for="dob">Date of Birth:</label>
        <div class="dob-container">
            <select name="mm" required>
                <option value="">Month</option>
                <?php 
                for ($i = 1; $i <= 12; $i++) 
                { echo "<option value='$i'>$i</option>"; }
                 ?>
            </select>
            <select name="dd" required>
                <option value="">Day</option>
                <?php for ($i = 1; $i <= 31; $i++) { echo "<option value='$i'>$i</option>"; } ?>
            </select>
            <select name="yy" required>
                <option value="">Year</option>
                <?php for ($i = 1900; $i <= 2015; $i++) { echo "<option value='$i'>$i</option>"; } ?>
            </select>
        </div>

        <label for="address">Address:</label>
        <textarea id="address" name="add" required></textarea>

        <label for="pic">Profile Picture:</label>
        <input type="file" id="pic" name="pic" required>

        <div style="display: flex; justify-content: space-between ;padding: 0px 180px 0px 180px ">  
            <button type="submit">Register</button>
            <button type="reset">Reset</button>
        </div>
    </form>
</body>
</html>
