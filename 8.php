<?php
// defining the function
function greetings()
{
echo "Merry Christmas and a Very Happy New Year"  . "<br/>";
}
echo "Hey Martha <br/>";
// calling the function
greetings();
// next line
echo "<br/>";
echo "Hey Jon <br/>";
// calling the function again
greetings();
?>


















<?php

function addNumbers($a, $b) {
    return $a + $b;
}


function subtractNumbers($a, $b) {
    return $a - $b;
}


function displayWelcomeMessage($name) {
    echo "Welcome, " . $name . "!";
}


function factorial($n) {
    if ($n == 0 || $n == 1) {
        return 1;
    } else {
        return $n * factorial($n - 1);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
   
    $name = $_POST['name'];
    $num1 = $_POST['num1'];
    $num2 = $_POST['num2'];

    
    echo "Addition of $num1 and $num2: " . addNumbers($num1, $num2) . "<br>";
    echo "Subtraction of $num1 and $num2: " . subtractNumbers($num1, $num2) . "<br>";
    displayWelcomeMessage($name);
    echo "<br>Factorial of $num1: " . factorial($num1);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>User Input Form</title>
</head>
<body>

<h2>Enter Your Information</h2>
<form method="post" action="">
    <label for="name">Enter your name:</label><br>
    <input type="text"  name="name" required><br><br>

    <label for="num1">Enter first number:</label><br>
    <input type="number"  name="num1" required><br><br>

    <label for="num2">Enter second number:</label><br>
    <input type="number"  name="num2" required><br><br>

    <input type="submit" value="Submit">
</form>

</body>
</html>
