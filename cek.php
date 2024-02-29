<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the password is set and not empty
    if (isset($_POST["password"]) && !empty($_POST["password"])) {
        $enteredPassword = $_POST["password"];

        // You can replace this with your actual password check logic
        $correctPassword = "hasta"; // Replace with your actual password

        $user = array(
            [
                'password' => 'hasta',
                'name' => 'Guest',
                'role' => 'global'
            ],
            [
                'password' => 'hastaGizi',
                'name' => 'Admin Gizi',
                'role' => 'gizi'
            ],
        );



        foreach ($user as $check) {
            var_dump($check);
            if ($enteredPassword == $check['password']) {
                // Password is correct, set up the session
                $_SESSION["loggedin"] = true;
                // Set the timestamp of the last activity
                $_SESSION["last_activity"] = time();
                //Setting Role
                $_SESSION["user_data"] = $check;
                // Redirect to the desired page after successful login
                header("Location: dashboard.php");
                
                
                exit();
            } else {
                
                
            }
        }
        // Password is incorrect, you can handle this as needed (e.g., show an error message)
        echo "Incorrect password. Please try again.";

        
    } else {
        // Password is not set or empty, you can handle this as needed
        echo "Please enter a password.";
    }
    
}

?>
