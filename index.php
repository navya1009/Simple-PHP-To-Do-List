<?php
// Start the session to store the to-do list
session_start();

// Initialize the to-do list if it doesn't exist
if (!isset($_SESSION['todo_list'])) {
    $_SESSION['todo_list'] = [];
}

// Handle form submission for adding a new task
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $task = trim($_POST['task']);
    if (!empty($task)) {
        $_SESSION['todo_list'][] = $task;
    }
}

// Handle deletion of a task
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $index = intval($_POST['index']);
    if (isset($_SESSION['todo_list'][$index])) {
        unset($_SESSION['todo_list'][$index]);
        // Reindex the array to avoid gaps
        $_SESSION['todo_list'] = array_values($_SESSION['todo_list']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern To-Do List</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --danger: #ef4444;
            --danger-hover: #dc2626;
            --light: #f8fafc;
            --gray: #e2e8f0;
            --dark: #1e293b;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.1);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1);
            --radius: 12px;
            --transition: all 0.2s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            min-height: 100vh;
            padding: 20px;
            color: var(--dark);
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
        }

        header {
            background: linear-gradient(135deg, var(--primary), #818cf8);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        h1 {
            font-size: 2.2rem;
            font-weight: 600;
            margin-bottom: 8px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .subtitle {
            font-size: 0.95rem;
            opacity: 0.9;
            font-weight: 400;
        }

        .add-task-container {
            padding: 30px 25px 20px;
            background: white;
        }

        .add-task-form {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
        }

        .task-input {
            flex: 1;
            padding: 14px 18px;
            font-size: 1rem;
            border: 2px solid var(--gray);
            border-radius: var(--radius);
            transition: var(--transition);
            outline: none;
            font-family: inherit;
        }

        .task-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }

        .add-btn {
            padding: 0 24px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: var(--radius);
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }

        .add-btn:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .add-btn i {
            font-size: 1.1rem;
        }

        .task-list-container {
            padding: 0 25px 30px;
        }

        .task-count {
            font-size: 0.9rem;
            color: #64748b;
            margin-bottom: 15px;
            font-weight: 500;
        }

        ul {
            list-style: none;
        }

        .task-item {
            background: var(--light);
            border: 1px solid var(--gray);
            border-radius: var(--radius);
            padding: 16px 18px;
            margin-bottom: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .task-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: var(--primary);
            opacity: 0;
            transition: var(--transition);
        }

        .task-item:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            border-color: #c7d2fe;
        }

        .task-item:hover::before {
            opacity: 1;
        }

        .task-text {
            font-size: 1.05rem;
            color: var(--dark);
            flex: 1;
            word-break: break-word;
        }

        .delete-form {
            display: inline;
        }

        .delete-btn {
            background: var(--danger);
            color: white;
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
        }

        .delete-btn:hover {
            background: var(--danger-hover);
            transform: scale(1.1);
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #94a3b8;
        }

        .empty-state i {
            font-size: 3.5rem;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        .empty-state p {
            font-size: 1.1rem;
            margin-bottom: 8px;
        }

        .empty-state small {
            font-size: 0.9rem;
        }

        @media (max-width: 480px) {
            .container {
                margin: 15px auto;
            }
            
            h1 {
                font-size: 1.8rem;
            }
            
            .add-task-form {
                flex-direction: column;
            }
            
            .add-btn {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-tasks"></i> To-Do List</h1>
            <p class="subtitle">Organize your day, one task at a time</p>
        </header>

        <div class="add-task-container">
            <form method="POST" class="add-task-form">
                <input type="hidden" name="action" value="add">
                <input 
                    type="text" 
                    name="task" 
                    class="task-input" 
                    placeholder="What needs to be done?" 
                    required
                    autocomplete="off"
                >
                <button type="submit" class="add-btn">
                    <i class="fas fa-plus"></i> Add Task
                </button>
            </form>
        </div>

        <div class="task-list-container">
            <div class="task-count">
                <?php 
                $count = count($_SESSION['todo_list']);
                echo $count === 0 ? 'No tasks yet' : 
                     ($count === 1 ? '1 task' : "$count tasks");
                ?>
            </div>

            <?php if (empty($_SESSION['todo_list'])): ?>
                <div class="empty-state">
                    <i class="fas fa-clipboard-list"></i>
                    <p>Your to-do list is empty</p>
                    <small>Add a task above to get started!</small>
                </div>
            <?php else: ?>
                <ul>
                    <?php foreach ($_SESSION['todo_list'] as $index => $task): ?>
                        <li class="task-item">
                            <span class="task-text"><?php echo htmlspecialchars($task); ?></span>
                            <form method="POST" class="delete-form">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="index" value="<?php echo $index; ?>">
                                <button type="submit" class="delete-btn" title="Delete task">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>