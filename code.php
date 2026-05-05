<?php
session_start();
include('config/dbcon.php'); // Make sure your DB connection path is correct

if(isset($_POST['save_address_btn']))
{
    $user_id = $_SESSION['auth_user']['user_id'];
    
    // Sanitize inputs to prevent SQL errors
    $full_name = mysqli_real_escape_string($con, $_POST['full_name']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $pincode = mysqli_real_escape_string($con, $_POST['pincode']);
    $address_line = mysqli_real_escape_string($con, $_POST['address_line']);
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $state = mysqli_real_escape_string($con, $_POST['state']);

    // Since you want Address 1, Address 2, Address 3... 
    // We always use INSERT so it creates a NEW box every time.
    $insert_query = "INSERT INTO user_addresses (user_id, full_name, phone, pincode, address_line_1, city, state) 
                     VALUES ('$user_id', '$full_name', '$phone', '$pincode', '$address_line', '$city', '$state')";

    $insert_query_run = mysqli_query($con, $insert_query);

    if($insert_query_run)
    {
        // This stops the "stucking" - it sends you back to the list immediately
        $_SESSION['message'] = "Address Added Successfully";
        header("Location: my-addresses.php");
        exit(0);
    }
    else
    {
        // If it fails, it shows the error instead of a blank screen
        die("Query Failed: " . mysqli_error($con));
    }
}
?>