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
        <h1>Read Tasks</h1>
    </div>

    <div class="container">
        <?php
        include 'config/database.php';

        // $query = "SELECT id, modified, task_name, task_desc FROM task_lists ORDER BY id DESC";
        // $stmt = $con->prepare($query);
        // // var_dump($stmt->execute());
        // $stmt->execute();
        // // var_dump($stmt);

        // 2. Add LIMIT clause in SELECT query
        // select data for current page
        $query = "SELECT id, modified, task_name, task_desc FROM task_lists ORDER BY id DESC
        LIMIT :from_record_num, :records_per_page";
        $stmt = $con->prepare($query);
        $stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
        $stmt->execute();

        echo "<a href='create.php' class='btn btn-primary m-b-1em'>Create New Task</a>";
        $num = $stmt->rowCount();
        // var_dump($num);

        $action = isset($_GET['action']) ? $_GET['action'] : "";
        // if it was redirected from delete.php
        if ($action == 'deleted') {
            echo "<div class='alert alert-success'>Record was deleted.</div>";
        }

        if ($num > 0) {
            echo "<table class='table table-hover table-responsive table-bordered'>";
            echo "<tr>
            <th>ID</th>
            <th>Date</th>
            <th>Task Name</th>
            <th>Task Description</th>
            <th>Action</th>
            </tr>";

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                // var_dump($row);
                // echo "<br>";
                echo "<tr>
                    <td>{$id}</td>
                    <td>{$modified}</td>
                    <td>{$task_name}</td>
                    <td>{$task_desc}</td>
                    <td>";
                echo "<a href='read_one.php?id={$id}' class='btn btn-info m-r-1em'>Read</a>";
                echo "<a href='update.php?id={$id}' class='btn btn-primary m-r-1em'>Edit</a>";
                echo "<a href='#' onclick='delete_user({$id});'  class='btn btn-danger'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";

            // 3. Count total number of records
            $query = "SELECT COUNT(*) as total_rows FROM task_lists";
            $stmt = $con->prepare($query);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $total_rows = $row['total_rows'];

            // 4. Include paging file
            $page_url="index.php?";
            include_once "paging.php";
        } else {
            echo "<div class='alert alert-danger'>No records found.</div>";
        }


        ?>
    </div>
    <script type='text/javascript'>
        // confirm record deletion
        function delete_user(id) {
            var answer = confirm('Are you sure?');
            if (answer) {
                // if user clicked ok,
                // pass the id to delete.php and execute the delete query
                window.location = 'delete.php?id=' + id;
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>