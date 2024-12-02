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
// Database connectivity
$con = mysql_connect("localhost", "root", "") or die("Connection failed");
mysql_select_db("student", $con);

// Extract form data
extract($_POST);

if (isset($save)) {
    // Concatenate date of birth (dob) from individual parts
    $dob = $yy . "-" . $mm . "-" . $dd;

    // Convert hobbies array to a comma-separated string
    $h = implode(",", $hobb);

    // Get the uploaded profile image name
    $img = $_FILES['pic']['name'];

    // To check if the email already exists
    $sql = mysql_query("SELECT email FROM studentdetails WHERE email='$e'");
    $return = mysql_num_rows($sql);

    if ($return) {
        $msg = "<font color='red'>" . ucfirst($e) . " already exists. Choose another email.</font>";
    } else {
        // Insert data into the database
        $query = "INSERT INTO studentdetails VALUES('', '$n', '$e', '$p', '$m', '$g', '$h', '$dob', '$add', '$img', NOW())";
        mysql_query($query);
        $msg = "<font color='blue'>Your data has been saved.</font>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Registration Form</title>
    <style>
        input, textarea { width: 200px; }
        input[type=radio], input[type=checkbox] { width: 10px; }
        input[type=submit], input[type=reset] { width: 100px; }
    </style>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <table width="393" border="1">
            <tr>
                <td colspan="2"><?php echo @$msg; ?></td>
            </tr>
            <tr>
                <td width="159">Enter your Name</td>
                <td width="218">
                    <input type="text" placeholder="Your first name" name="n" pattern="[a-zA-Z ]*" required />
                </td>
            </tr>
            <tr>
                <td>Enter your Email</td>
                <td><input type="email" name="e" required /></td>
            </tr>
            <tr>
                <td>Enter your Password</td>
                <td><input type="password" name="p" required /></td>
            </tr>
            <tr>
                <td>Enter your Address</td>
                <td><textarea name="add" required></textarea></td>
            </tr>
            <tr>
                <td>Enter your Mobile</td>
                <td><input type="text" pattern="[0-9]*" name="m" required /></td>
            </tr>
            <tr>
                <td height="23">Select your Gender</td>
                <td>
                    Male <input type="radio" name="g" value="m" required />
                    Female <input type="radio" name="g" value="f" required />
                </td>
            </tr>
            <tr>
                <td>Choose your Hobbies</td>
                <td>
                    Cricket <input type="checkbox" value="cricket" name="hobb[]" />
                    Singing <input type="checkbox" value="singing" name="hobb[]" />
                    Dancing <input type="checkbox" value="dancing" name="hobb[]" />
                </td>
            </tr>
            <tr>
                <td>Choose your Profile Pic</td>
                <td><input type="file" name="pic" required /></td>
            </tr>
            <tr>
                <td>Select your DOB</td>
                <td>
                    <select name="mm" required>
                        <option value="">Month</option>
                        <?php for ($i = 1; $i <= 12; $i++) { echo "<option value='$i'>$i</option>"; } ?>
                    </select>
                    <select name="dd" required>
                        <option value="">Date</option>
                        <?php for ($i = 1; $i <= 31; $i++) { echo "<option value='$i'>$i</option>"; } ?>
                    </select>
                    <select name="yy" required>
                        <option value="">Year</option>
                        <?php for ($i = 1900; $i <= 2015; $i++) { echo "<option value='$i'>$i</option>"; } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" name="save" value="Register Me" />
                    <input type="reset" value="Reset" />
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
 