<?php
    error_reporting(E_ALL & ~E_NOTICE);
  // include config for Database
    require_once "php/config.php";

    // Declare the variables that will be used.
    $name = $language = $datenow = "";
    $nameerror = $langerror = $dateerror = "";

    // Process form data when its submitted
    if(isset($_POST["id"]) && !empty($_POST["id"])) {
      // Get hidden input value.
        $id = $_POST["id"];
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
          //if(empty($nameerror) && empty($langerror) && empty($dateerror)) {

            if($name != "" && $language != "") {
            // Prepare an UPDATE sql statement.
                $sql = "UPDATE users SET name=:name, language=:language, " .
                       "date=:date WHERE id=:id";
                    error_log($sql);
                if($stmt = $pdoConnect->prepare($sql)) {
                  // Bind variables to prepared statement as parameters.
                    $stmt->bindParam(":name", $param_name);
                    $stmt->bindParam(":language", $param_lang);
                    $stmt->bindParam(":date", $param_date);
                    $stmt->bindParam(":id", $param_id);
                    // Set parameters
                    $para_name = $name;
                    $param_lang = $lang;
                    $param_date = $date;
                    $param_id = $id;
                    // Attempt to execute prepared statement
                    if($stmt->execute()) {
                      // Determine if Success or Error
                      // Record updated Successfully
                      header("location: index.php");
                      exit();
                    } else {
                          echo "Something went wrong, try again later.";
                    }
                }
           } else {
                  $errormsg = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" ' .
                              'class="close" data-dismiss="alert" aria-label="Close" aria-hidden="true">&times;</button>' .
                              'All fields are required to continue</div>';
           }
            // Close $stmt statement
            unset($stmt);
        //}
        // Close PDO connection
        unset($pdoConnect);
    } else {
      // Check existence of 'id' paramater passed
          if(isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
            // GET URL parameter
              $id = trim($_GET["id"]);

            // Prepare SELECT statement
              $sql = "SELECT * FROM users WHERE id = :id";
              if($stmt = $pdoConnect->prepare($sql)) {
                // Bind variables to prepared statement as parameters.
                  $stmt->bindParam(":id", $param_id);
                  // Set parameter
                  $param_id = $id;
                  // Attempt to execute prepared statement
                  if($stmt->execute()) {
                      if($stmt->rowCount() == 1) {
                        // fetch result row as an array
                          $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        // Retrieve individual field values
                          //$id = $row["id"];
                          $name = $row["name"];
                          $language = $row["language"];
                          $userdate = $row["date"];

                      } else {
                        // URL doesn't contain valid 'id' parameter
                            header("location: error.php");
                            exit();
                      }
                  } else {
                        echo "Something went wrong with UPDATE, try again later.";
                  }
              }
              // Close $stmt statement
              unset($stmt);
              // Close connection
              unset($pdoConnect);
          } else {
              // URL doesn't contain valid 'id' parameter.
                header("location: error.php");
                exit();
          }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>PHP CRUD mySQL Update</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- BootStrap 4 CDN CSS external link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <!-- Custom CSS Link -->
    <link rel="stylesheet" href="css/main.css" />
</head>
<body>
  <header class="container-fluid text-center text-light py-4">
      <div>
          <div class="d-block">
              <img id="headpic" class="rounded-circle" src="img/Andrew.JPG" />
          </div>
          <div>
              <h1 class="header-text d-inline">PHP BootStrap4 mySQL CRUD Update</h1>
              <span class="d-inline text-light2">By Andrew Harkins</span>
          </div>
      </div>
  </header>
      <section class="text-center" id="section-content">
          <div id="contentdiv" class="container rounded contentdiv">
              <div class="row">
                  <div class="col-md-12">
                      <div class="pb-2 mt-4 mb-2 border-bottom clearfix">
                          <h2>Update Selected User</h2>
                      </div>
                      <h5>Please edit the input values and submit it to update user in database.</h5>
                      <form action="<?php echo htmlspecialchars(basename($_SERVER["REQUEST_URI"])); ?>"
                            method="post" class="rounded" id="formUpdate">
                          <div class="form-group row">
                              <label for="txtid" class="col-sm-3"><b>Id:</b></label>
                              <div class="col-sm-9">
                                  <input type="text" class="form-control" id="txtid" name="txtid"
                                   disabled value="<?php echo $row["id"]; ?>" />
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="txtname" class="col-sm-3"><b>Name:</b></label>
                              <div class="col-sm-9">
                                  <input type="text" class="form-control" id="txtname" name="txtname"
                                   value="<?php echo $row["name"]; ?>" />
                              </div>
                          </div>
                          <?php if(isset($nameerror)) { echo '<span id="error"><b>' . $nameerror . '</b></span>'; } ?>
                          <div class="form-group row">
                              <label for="txtlang" class="col-sm-3"><b>Language:</b></label>
                              <div class="col-sm-9">
                                  <input type="text" class="form-control" id="txtlang" name="txtlang"
                                   value="<?php echo $row["language"]; ?>" />
                              </div>
                          </div>
                          <?php if(isset($langerror)) { echo '<span id="error"><b>' . $langerror . '</b></span>'; } ?>
                          <div class="form-group row">
                              <label for="txtdate" class="col-sm-3"><b>Date:</b></label>
                              <div class="col-sm-9">
                                  <input type="text" class="form-control" id="txtdate" name="txtdate"
                                   disabled value="<?php echo $row["date"]; ?>" />
                              </div>
                          </div>
                          <?php if(isset($dateerror)) { echo '<span id="error"><b>' . $dateerror . '</b></span>'; } ?>

                          <input type="hidden" name="id" value="<?php echo $id; ?>" />

                          <input type="submit" class="btn btn-lg btn-primary btn-block" name="submit" value="Update"/>
                          <a href="index.php" class="btn btn-lg btn-danger btn-block" role="button">Cancel</a>
                      </form>
                  </div>
              </div>
          </div>
      </section>
    <!-- BootStrap 4 CDN JavaScript -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>
</html>
