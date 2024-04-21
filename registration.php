<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php
        if (isset($_POST["submit"])){
         $fullname=$_POST["fullname"];
         $email=$_POST["email"];
         $nid=$_POST["nid"];
         $password=$_POST["password"];
         $repeat_password=$_POST["repeat_password"];
         $passwordHash = password_hash($password, PASSWORD_DEFAULT);
         $errors = array();
         if (empty($fullname) OR empty($email) OR empty($password) OR empty($repeat_password)){

        }
         if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email is not valid");
        }
        if (strlen($nid)<13) {
            array_push($errors,"NID must be at least 13 charactes long");
        }
           if (strlen($password)<8) {
            array_push($errors,"Password must be at least 8 charactes long");
        }
        
           if ($password!==$repeat_password) {
            array_push($errors,"Password does not match");
        }
        require_once "database.php";
        $sql = "SELECT * FROM users WHERE Email = '$email'";
        $result = mysqli_query($conn, $sql);
        $rowCount = mysqli_num_rows($result);
        if ($rowCount>0) {
         array_push($errors,"Email already exists!");
        }
        if (count($errors)>0) {
            foreach ($errors as  $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
        }
        else{
            require_once "database.php";
            $sql = "INSERT INTO users (Fullname,Email,Nid,Password) VALUES ( ?, ?, ?,? )";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
            if ($prepareStmt) {
                mysqli_stmt_bind_param($stmt,"ssis",$fullname,$email,$nid,$passwordHash);
                mysqli_stmt_execute($stmt);
                echo "<div class='alert alert-success'>You are registered successfully.</div>";
            }else{
                die("Something went wrong");
            }
           }

        }
        ?>
        <form action="registration.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="fullname" placeholder="Fullname">

            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="email" placeholder="E-mail">

            </div>
            <div class="form-group">
                  <input type="text" class="form-control" name="nid" placeholder="NID" >
            </div>

            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password">

            </div>
            <div class="form-group">
            <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password">
        </div>
        <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>
        </form>
        <div>
        <div><p>Already Registered <a href="login.php">Login Here</a></p></div>
      </div>

    </div>
</body>
</html>