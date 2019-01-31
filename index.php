<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>PHP CRUD mySQL Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- BootStrap 4 CDN CSS external link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <!-- Custom CSS Link -->
    <link rel="stylesheet" href="css/main.css" />
    <!-- Glyph Icons CSS -->
    <link rel="stylesheet" href="css/glyphicon.css" />
</head>
<body>
  <header class="container-fluid text-center text-light py-4">
      <div>
          <div class="d-block">
              <img id="headpic" class="rounded-circle" src="img/Andrew.JPG" />
          </div>
          <div>
              <h1 class="header-text d-inline">PHP BootStrap4 mySQL CRUD</h1>
              <span class="d-inline text-light2">By Andrew Harkins</span>
          </div>
      </div>
  </header>
<?php
    require_once "php/config.php";
?>

    <section class="text-center" id="section-content">
        <!-- <div id="alertMessages" class="container rounded"></div> -->
        <div id="contentdiv" class="container rounded contentdiv">
            <div class="row">
                <div class="col-md-12">
                  <!-- page-header of 3 content-header col-10 centerize it think for later -->
                    <div class="pb-2 mt-4 mb-2 border-bottom clearfix">
                        <h2 class="float-left">PHP CRUD User Details</h2>
                        <a class="btn btn-success float-right" href="register.php">Add New User</a>
                    </div>
                    <?php
                        // Setup SELECT query
                        $sql = "SELECT * FROM users";
                        if($result = $pdoConnect->query($sql)) {
                            if($result->rowCount() > 0) {
                                echo '<table class="table table-bordered table-striped">';
                                    echo '<thead class="thead-dark">';
                                        echo '<tr>';
                                            echo '<th scope="col">#</th>';
                                            echo '<th scope="col">Name</th>';
                                            echo '<th scope="col">Language</th>';
                                            echo '<th scope="col">Date</th>';
                                            echo '<th scope="col">Action</th>';
                                        echo '</tr>';
                                    echo '</thead>';
                                    echo '<tbody>';
                                    while ($row = $result->fetch()) {
                                        echo '<tr>';
                                            echo '<th scope="row">' . $row['id'] . '</th>';
                                            echo '<td>' . $row['name'] . '</td>';
                                            echo '<td>' . $row['language'] . '</td>';
                                            echo '<td>' . $row['date'] . '</td>';
                                            echo '<td>';
                                            echo '<a href="read.php?id='. $row['id'] .
                                                  '" title="View Record" data-toggle="tooltip">' .
                                                  '<span class="glyphicon glyphicon-eye-open mx-1"></span></a>';

                                            echo '<a href="update.php?id='. $row['id'] .
                                                  '" title="Update Record" data-toggle="tooltip">' .
                                                  '<span class="glyphicon glyphicon-pencil mx-1"></span></a>';

                                            echo '<a href="delete.php?id='. $row['id'] .
                                                  '" title="Delete Record" data-toggle="tooltip">' .
                                                  '<span class="glyphicon glyphicon-trash mx-1"></span></a>';
                                            echo '</td>';
                                        echo '</tr>';
                                      }
                                    echo '</tbody>';
                                echo '</table>';
                                // free the set '$result'
                                unset($result);
                            } else {
                              echo "<p>No records were found in crudDb</p>";
                            }
                        } else {
                          echo "ERROR: Could not execute the $sql. " . $mysqli->error;
                        }
                        // Close PDO connection
                        unset($pdoConnect);
                    ?>
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
