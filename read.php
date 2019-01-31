<?php
  // Check for an 'id' if true retrieve record.
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
  // Include config - database
    require_once "php/config.php";
  // Prepare SQL select statement.
    $sql = "SELECT * FROM users WHERE id = :id";
  // config for SQL Prepare
    if($stmt = $pdoConnect->prepare($sql)) {
      // Bind variables to prepared statement as parameters.
        $stmt->bindParam(":id", $param_id);
        // Set parameters
        $param_id = trim($_GET["id"]);
        // Attempt to execute prepared statement
        if($stmt->execute()) {
            if($stmt->rowCount() == 1) {
              // fetch result row as an array
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
              // Retrieve individual field values
                $id = $row["id"];
                $name = $row["name"];
                $language = $row["language"];
                $userdate = $row["date"];
            } else {
              // URL doesn't contain valid 'id' parameter
                  header("location: error.php");
                  exit();
            }
        } else {
              echo "Something went wrong, try again later.";
        }
    }
  // Close $stmt statement
    unset($stmt);
  // Close connection.
  unset($pdoConnect);
} else {
  // URL doesn't contain valid 'id' parameter.
  header("location: error.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>PHP CRUD mySQL Read</title>
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
              <h1 class="header-text d-inline">PHP BootStrap4 mySQL CRUD Read</h1>
              <span class="d-inline text-light2">By Andrew Harkins</span>
          </div>
      </div>
  </header>
      <section class="text-center" id="section-content">
          <div id="contentdiv" class="container rounded contentdiv">
              <div class="row">
                  <div class="col-md-12">
                      <div class="pb-2 mt-4 mb-2 border-bottom clearfix">
                          <h2>View Selected User</h2>
                      </div>
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
                               disabled value="<?php echo $row["name"]; ?>" />
                          </div>
                      </div>
                      <div class="form-group row">
                          <label for="txtlang" class="col-sm-3"><b>Language:</b></label>
                          <div class="col-sm-9">
                              <input type="text" class="form-control" id="txtlang" name="txtlang"
                               disabled value="<?php echo $row["language"]; ?>" />
                          </div>
                      </div>
                      <div class="form-group row">
                          <label for="txtdate" class="col-sm-3"><b>Date:</b></label>
                          <div class="col-sm-9">
                              <input type="text" class="form-control" id="txtdate" name="txtdate"
                               disabled value="<?php echo $row["date"]; ?>" />
                          </div>
                      </div>
                      <p>
                          <a href="index.php" class="btn btn-lg btn-primary">Go Back</a>
                      </p>
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
