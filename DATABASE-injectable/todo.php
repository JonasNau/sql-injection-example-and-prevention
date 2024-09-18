<?php
try {
    //Arten von SQL-Injection: https://www.geeksforgeeks.org/types-of-sql-injection-sqli/
    //'); DROP table tasks; --

    $db = new PDO('sqlite:todo.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Handle adding a new task
    if (isset($_POST['add_task'])) {
        $task = $_POST['task'];
        $db->exec("INSERT INTO tasks (task) VALUES ('$task')");
       
    }

    // Handle deleting a task
    if (isset($_GET['delete'])) {
        $id = (int)$_GET['delete'];
        $db->exec("DELETE FROM tasks WHERE id = $id");
    }

    // Fetch all tasks
    $stmt = $db->query('SELECT * FROM tasks');
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
        }
        form {
            display: flex;
            margin-bottom: 20px;
        }
        input[type="text"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            border: none;
            background-color: #28a745;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .task-list {
            list-style: none;
            padding: 0;
        }
        .task-list li {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .task-list li:last-child {
            border-bottom: none;
        }
        .delete-btn {
            color: #dc3545;
            border: none;
            background: none;
            cursor: pointer;
        }
        .delete-btn:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>To-Do List</h1>
        <form method="post">
            <input type="text" name="task" placeholder="New task" required>
            <input type="submit" name="add_task" value="Add Task">
        </form>
        <ul class="task-list">
            <?php foreach ($tasks as $task): ?>
                <li>
                    <?php echo htmlspecialchars($task['task']); ?>
                    <a href="?delete=<?php echo $task['id']; ?>" class="delete-btn">Delete</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
