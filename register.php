<?php
//           $sqlCheck = "SELECT name FROM tester WHERE name ='". $namesafe ."'";
//         $check = mysqli_query($connection, $sqlCheck);
//         $numRows = mysqli_num_rows($check);
//         if($numRows == 0) {//
//             $sqlInsert = "INSERT INTO tester(name, two) " .
//                 "VALUES('". $namesafe ."','". $twosafe ."')";
//           }
//           else {
//               $errormsg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
//               <button type="button" class="close" data-dismiss="alert" aria-label="Close" aria-hidden="true">
//               &times;</button>Name has <b>ALREADY</b> been <u>used</u>!<br>'. $namesafe .'</div>';
// TO-DO: #1 clock, #2 $errormsg-alert

// Database configuration
require_once "php/config.php";

// Declare the variables that will be used.
$name = $language = $datenow = "";
$nameerror = $langerror = $dateerror = "";

// Processing the form when it is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
  // Validate name entered
    $input_name = trim($_POST["name"]);
    if(empty($input_name)) {
        $nameerror = "Name is required. ";
    } elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP,
        array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))) {
        $nameerror = "Please enter a valid name. ";
    } else {
        //$namesafe = mysqli_real_escape_string($connection, $input_name);
        $name = $input_name;
    }
  // Validate language entered
    $input_lang = trim($_POST["language"]);
    if(empty($input_lang)) {
        $langerror = "Please enter a language. ";
    } else {
        $language = $input_lang;
    }
  // Get current Date and Time
  $currentDate = date("Y-m-d H:i:s");
  // OR
  $datetimeobj = new DateTime();
  $datetimeobj->format("Y-m-d H:i:s");

  // Check and make sure no errors before inserted into database.
    //if(empty($nameerror) && empty($langerror) && empty($dateerror))
    //{
        if($name != "" && $language != "")
        { // Prepare an INSERT sql statement.
            $sql = "INSERT INTO users(name, language, date) VALUES " .
                   "(:name, :language, :date)";

            if($stmt = $pdoConnect->prepare($sql))
            { // Bind variables to prepared statement as parameters.
                $stmt->bindParam(":name", $para_name);
                $stmt->bindParam(":language", $para_lang);
                $stmt->bindParam(":date", $para_date);
              // Set parameters
                $para_name = $name;
                $para_lang = $language;
                $para_date = $currentDate;
              // Attempt to execute prepared statement
                if($stmt->execute())
                { // Determine if Success or Error
                    header("Location: index.php");
                    exit();
                } else {
                    echo "Something went wrong with INSERT, please try again later.";
                }
            }
            // Close stmt statement
            unset($stmt);
        } else {
              $errormsg = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" ' .
                          'class="close" data-dismiss="alert" aria-label="Close" aria-hidden="true">&times;</button>' .
                          'All fields are required to continue</div>';
        }
    //}
    // Close connection mysqli_close
    unset($pdoConnect);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>PHP CRUD mySQL Create</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- BootStrap 4 CDN CSS external link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <!-- Custom CSS Link  onload=displayClock();-->
    <link rel="stylesheet" href="css/main.css" />
</head>
<body>
  <header class="container-fluid text-center text-light py-4">
      <div>
          <div class="d-block">
              <img id="headpic" class="rounded-circle" src="img/Andrew.JPG" />
          </div>
          <div>
              <h1 class="header-text d-inline">PHP BootStrap4 mySQL CRUD Create</h1>
              <span class="d-inline text-light2">By Andrew Harkins</span>
          </div>
      </div>
  </header>
    <section class="text-center" id="section-content">
        <div id="alertMessages" class="container rounded"></div>
        <div id="contentdiv" class="container rounded contentdiv">
          <h5>Please fill out this form and submit it to add user to database.</h5>
            <form id="formCreate" class="rounded" method="post" action="">
                <h2 class="pb-2 border-bottom">PHP BootStrap4 mySQL CRUD Create</h2>
                <?php
                    if(isset($errormsg)) {
                      echo $errormsg;
                    }
                 ?>
                <div>
                    <div class="form-group row">
                      <label for="txtName" class="col-sm-3"><b>Name </b></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" id="txtName" name="name"/>
                      </div>
                    </div>
                    <?php if(isset($nameerror)) { echo '<span id="error"><b>' . $nameerror . '</b></span>'; } ?>
                    <div class="form-group row">
                      <label for="txtLang" class="col-sm-3 col-form-label"><b>Favorite Language </b></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" id="txtLang" name="language"/>
                      </div>
                    </div>
                    <?php if(isset($langerror)) { echo '<span id="error"><b>' . $langerror . '</b></span>'; } ?>
                    <div class="form-group row">
                      <label for="txtClock" class="col-sm-3"><b>Date and Time </b></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" id="txtClock" name="txtclock"
                                value="<?php echo date("Y-m-d H:i"); ?> " />
                      </div>
                    </div>
                    <?php if(isset($dateerror)) { echo '<span id="error"><b>' . $dateerror . '</b></span>'; } ?>

                </div>
                <button type="submit" class="btn btn-lg btn-primary btn-block" name="submit">Create</button>
                <a href="index.php" class="btn btn-lg btn-danger btn-block" role="button" >Cancel</a>
            </form>
        </div>
    </section>

    <!-- BootStrap 4 CDN JavaScript -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>
</html>
