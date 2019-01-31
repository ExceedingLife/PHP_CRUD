<?php
  // Process DELETE after confirmation.
    if(isset($_POST["id"]) && !empty($_POST["id"])) {
      // Include sql config
        require_once "php/config.php";

      // Prepare a DELETE statement
      $sql = "DELETE FROM users WHERE id=:id";

      if($stmt = $pdoConnect->prepare($sql)) {
        // Bind variables to prepared statement as parameters.
        $stmt->bindParam(":id", $param_id);
        // Set parameters
        $param_id = trim($_POST["id"]);
        // Attempt to execute prepared statement
        if($stmt->execute()) {
          // Determine if successful or error
          header("location: index.php");
          exit();
        } else {
              echo "Something went wrong with DELETE, please try again later.";
        }
      }
      // Close $stmt statement
      unset($stmt);
      // Close connections
      unset($pdoConnect);
    } else {
        // Check existence of 'id' parameter
        if(empty(trim($_GET["id"]))) {
          //URL doesn't contain parameter send ERROR
          header("location: error.php");
          exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>PHP CRUD mySQL Delete</title>
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
              <h1 class="header-text d-inline">PHP BootStrap4 mySQL CRUD Delete</h1>
              <span class="d-inline text-light2">By Andrew Harkins</span>
          </div>
      </div>
  </header>
      <section class="text-center" id="section-content">
          <div id="contentdiv" class="container rounded contentdiv">
              <div class="row">
                  <div class="col-md-12">
                      <div class="pb-2 mt-4 mb-2 border-bottom clearfix">
                          <h2>Delete Selected User</h2>
                      </div>
                      <form action="" method="post" class="rounded" id="formDelete">
                          <div class="alert alert-danger fade show">
                              <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>" />
                              <p>
                                Are you sure you want to delete this user?<br />
                              </p>
                              <p>
                                  <input type="submit" value="Yes" class="btn btn-danger" />
                                  <a href="index.php" class="btn btn-default">No</a>
                              </p>
                          </div>
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
