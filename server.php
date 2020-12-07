<?php
$firstname = "";
$email    = "";
$lastname= "";
$contact="";
$password_1= "";
$errors = array(); 
$nameErr= "";
$results="";

$db = mysqli_connect('localhost', 'root', '', 'damco');

// REGISTER USER
if (isset($_POST['reg_user'])) {
   

  // receive all input values from the form
  $firstname = mysqli_real_escape_string($db, $_POST['firstname']);
  $lastname = mysqli_real_escape_string($db, $_POST['lastname']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $contact = mysqli_real_escape_string($db, $_POST['contact']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // validation
  if (empty($firstname)) { array_push($errors, "firstname is required"); }
  if (!preg_match("/^[a-zA-Z-' ]*$/",$firstname)) { array_push($errors, "Numbers not allowed in first name"); }
  
  
  if (empty($lastname)) { array_push($errors, "lastname is required"); }
  if (!preg_match("/^[a-zA-Z-' ]*$/",$firstname)) { array_push($errors, "Numbers not allowed in Last name"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($contact)) { array_push($errors, "contact is required"); }
  if(!preg_match('/^[0-9]{10}+$/', $contact )) { array_push($errors, "please enter a valid mobile number"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
    array_push($errors, "The two passwords do not match");
   
    
  }

  // first check the database to make sure 
  // a user does not already exist with the same email
  $user_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
    if (count($errors) == 0) {
        $password = $password_1;
      
          $query = "INSERT INTO users (firstname, lastname, email, contact, password) 
                    VALUES('$firstname', '$lastname', '$email', '$contact', '$password')";
          mysqli_query($db, $query);
          $_SESSION['email'] = $email;
      $_SESSION['success'] = "You are now logged in";
      
        
        
        }
  }


  // register user if there are no errors in the form
  
    if (isset($_POST['reg_user']) and count($errors) == 0){

        echo "Thankyou \n".$firstname."\n Data has been submitted successfully";
    }
    if (isset($_POST['login_user'])) {
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $password = mysqli_real_escape_string($db, $_POST['password']);
      
        if (empty($email)) {
            array_push($errors, "email is required");
        }
        if (empty($password)) {
            array_push($errors, "Password is required");
        }
      
        if (count($errors) == 0) {
           
            $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
            $results = mysqli_query($db, $query);
            if (mysqli_num_rows($results) == 1) {
              $_SESSION['email'] = $email;
              $_SESSION['success'] = "You are now logged in";
              header('location: index.php');
            }else {
                array_push($errors, "Wrong username/password combination");
            }
        }
      }
      
      ?>
    
    


