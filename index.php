<?php
    session_start();
    $tasks = $_SESSION['tasks'] ?? [];

    if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
        if ( isset( $_POST['add'] ) ) {
            $name = $_POST['name'] ?? '';

            if ( !empty($name) ) {
                $task = [
                    'name' => $name
                ];
                array_push($tasks, $task);
                $_SESSION['tasks'] = $tasks;
            }
        }

        if ( isset( $_POST['delete'] ) ) {
            $name = $_POST['name'] ?? '';

            $tasks = array_filter( $tasks, function( $task ) use ( $name ) {
                return $task['name'] !== $name;
            } );

            $_SESSION['tasks'] = array_values($tasks);
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>TODO-APP</title>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-lg rounded-xl p-6 w-full max-w-md">
        <h1 class="text-2xl font-bold text-center mb-4 text-purple-600">To-Do List</h1>

        <form id="task-form" method="post" action="" class="flex mb-4">
            <input type="text" id="task-input" name="name" placeholder="Add task..." class="flex-1 border border-gray-300 rounded-l-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
            <button name="add" type="submit" class="bg-purple-500 text-white px-4 rounded-r-lg hover:bg-purple-600 transition">Add</button>
        </form>

        <ul id="task-list" class="space-y-2">
            <?php foreach ( $tasks as $task ): ?>
                <li class="bg-gray-200 p-2 rounded-lg flex justify-between items-center">
                    <span><?php echo $task['name']; ?></span>
                    <form method="post" action="">
                        <input type="hidden" name="name" value="<?php echo $task['name']; ?>">
                        <button name="delete" type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

</body>
</html>
