<?php
session_start();

// CAS server URL (replace with your CAS server URL)
$cas_server_url = 'http://localhost/group68/cas_server.php';

// Check if user is already authenticated
if (isset($_SESSION['username'])) {
    echo 'Welcome, ' . $_SESSION['username'] . '! [<a href="?action=logout">Logout</a>]';
    // Display user-specific content here
    echo '<div class="card">
              <h3>User Page</h3>
              <p>This is the user page content that is displayed when the user is logged in.</p>
          </div>';
} else {
    // If not authenticated, redirect to CAS server login page
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $url = $cas_server_url . '?action=login';
        $data = http_build_query(['username' => $username, 'password' => $password]);
        $options = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => $data
            ]
        ];
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $response = json_decode($result, true);
        if ($response && $response['success']) {
            $_SESSION['username'] = $username;
            header('Location: user.php');
            exit();
        } else {
            echo 'Authentication failed. Please try again.';
            // Display the login form again
            echo '
            <form method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username"><br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password"><br>
                <input type="submit" value="Login">
            </form>
            ';
        }
    } else {
        // Display the login form
        echo '
        <form method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username"><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password"><br>
            <input type="submit" value="Login">
        </form>
        ';
    }
}

// Logout action
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    $url = $cas_server_url . '?action=logout';
    $result = file_get_contents($url);
    $response = json_decode($result, true);
    if ($response && $response['success']) {
        session_unset();
        session_destroy();
        header('Location: user.php');
        exit();
    } else {
        echo 'Logout failed.';
    }
}
?>