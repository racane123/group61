<?php
session_start();

// Dummy user data (replace with your user data retrieval logic)
$users = [
    'user1' => 'password1',
    'user2' => 'password2',
    // Add more users as needed
];

// CAS server actions
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'login':
            if (isset($_POST['username']) && isset($_POST['password'])) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                // Check if user credentials are valid
                if (isset($users[$username]) && $users[$username] === $password) {
                    $_SESSION['username'] = $username;
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Invalid username or password']);
                }
            } else {
                echo json_encode(['success' => false, 'error' => 'Username and password are required']);
            }
            break;
        case 'logout':
            unset($_SESSION['username']);
            echo json_encode(['success' => true]);
            break;
        default:
            echo json_encode(['success' => false, 'error' => 'Invalid action']);
    }
}
