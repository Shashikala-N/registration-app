<?php
header('Content-Type: application/json');

// Function to sanitize input
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $fullName = sanitizeInput($_POST['fullName']);
    $email = sanitizeInput($_POST['email']);
    $phone = sanitizeInput($_POST['phone']);
    $age = sanitizeInput($_POST['age']);
    $gender = sanitizeInput($_POST['gender']);

    // Basic server-side validation
    $errors = [];

    if (empty($fullName)) {
        $errors[] = "Full Name is required";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid Email is required";
    }

    if (empty($phone) || !preg_match("/^[0-9]{10}$/", $phone)) {
        $errors[] = "Valid Phone Number is required";
    }

    if (empty($age) || $age < 18 || $age > 100) {
        $errors[] = "Age must be between 18 and 100";
    }

    if (empty($gender)) {
        $errors[] = "Gender is required";
    }

    // Response based on validation
    if (empty($errors)) {
        // Successful registration
        $response = [
            'status' => 'success',
            'data' => [
                'fullName' => $fullName,
                'email' => $email,
                'phone' => $phone,
                'age' => $age,
                'gender' => $gender
            ]
        ];
    } else {
        // Registration failed
        $response = [
            'status' => 'error',
            'message' => implode(', ', $errors)
        ];
    }

    // Send JSON response
    echo json_encode($response);
    exit;
}
?>