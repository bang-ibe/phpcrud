<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Home</a>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <?php
        if ($_POST) {

            // include database connection
            include "config/database.php";
            try {
                $query = "INSERT INTO task_lists SET task_name=:task_name, task_desc=:task_desc, created=:created";
                $stmt = $con->prepare($query);
                // sanitized posted values
                $task_name = htmlspecialchars(strip_tags($_POST['task_name']));
                $task_desc = htmlspecialchars(strip_tags($_POST['task_desc']));
                // bind the parameters
                $stmt->bindParam(':task_name', $task_name);
                $stmt->bindParam(':task_desc', $task_desc);
                // specify when this record was inserted to the database
                $created = date('Y-m-d H:i:s');
                $stmt->bindParam('created', $created);
                // Execute the query
                if ($stmt->execute()) {
                    echo "<div class='alert alert-success'> record was saved</div>";
                    var_dump($_POST);
                } else {
                    echo "<div class='alert alert-danger'>unable to save record</div>";
                }
            }
            // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }
        ?>

    <div class="container">
        <div class="page-header">
            <h2>Create Task</h2>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Task Name</td>
                    <td><input type="text" name="task_name" class='form-control'></td>
                </tr>
                <tr>
                    <td>Task Description</td>
                    <td><input type="text" name="task_desc" class='form-control'></td>
                </tr>
                <!-- <tr>
                        <td>Photo</td>
                        <td><input type="file" name="image" /></td>
                    </tr> -->
                <tr>
                    <td></td>
                    <td><input type="submit" value='Save' class='btn btn-primary'>
                        <a href="index.php" class='btn btn-danger'>Back to read tasks</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>