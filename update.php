<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        .m-r-1em {
            margin-right: 1em;
        }

        .m-b-1em {
            margin-bottom: 1em;
        }

        .m-l-1em {
            margin-left: 1em;
        }

        .mt0 {
            margin-top: 0;
        }
    </style>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <!-- <a class="navbar-brand" href="#">Home</a> -->
            <!-- <a href="create.php" class="btn btn-outline-light">Add Task</a> -->
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-light" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <div class="page-header ms-3">
        <h1>Read One Task</h1>
    </div>

    <div class="container">
        <?php
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROD: ID not found');
        include 'config/database.php';
        try {
            //code...
            $query = "SELECT id, modified, task_name, task_desc FROM task_lists WHERE id=? LIMIT 0,1";
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $modified = $row['modified'];
            $task_name = $row['task_name'];
            $task_desc = $row['task_desc'];
        } catch (PDOException $exception) {
            //throw $th;
            die('Error : ' . $exception->getMessage());
        }
        ?>

        <?php
        // check if form was submitted
        if ($_POST) {
            try {
                $query = "UPDATE task_lists
                    SET task_name=:task_name, task_desc=:task_desc
                    WHERE id = :id";
                $stmt = $con->prepare($query);
                $task_name = htmlspecialchars(strip_tags($_POST['task_name']));
                $task_desc = htmlspecialchars(strip_tags($_POST['task_desc']));
                $stmt->bindParam(':task_name', $task_name);
                $stmt->bindParam(':task_desc', $task_desc);
                $stmt->bindParam(':id', $id);
                // Execute the query
                if ($stmt->execute()) {
                    echo "<div class='alert alert-success'>Record was updated.</div>";
                } else {
                    echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                }
            }
            // show errors
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }
        ?>


        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="POST">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Modified</td>
                    <td><?php echo htmlspecialchars($modified, ENT_QUOTES); ?></td>
                </tr>
                <tr>
                    <td>Task Name</td>
                    <td><input type="text" name="task_name" value="<?php echo htmlspecialchars($task_name, ENT_QUOTES); ?>" class="form-control"> </td>
                </tr>
                <tr>
                    <td>Task Description</td>
                    <td><textarea name='task_desc' class='form-control'><?php echo htmlspecialchars($task_desc, ENT_QUOTES);  ?></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save Changes' class='btn btn-primary' />
                        <a href='index.php' class='btn btn-danger'>Back to read tasks</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>