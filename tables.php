<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$host = "localhost";
$dbname = "projetg";
$username = "root";
$password = "";

// Connect to the database with error handling
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $age = $_POST['age'];
    $position = $_POST['position'];
    $status = $_POST['status'];
    $physical_condition = $_POST['physical_condition'];
    $performance = $_POST['performance'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $hometown = $_POST['hometown'];
    $dream = $_POST['dream'];
    $achievements = $_POST['achievements'];
    $medical_status = $_POST['medical_status'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];
    $image_path = 'uploads/' . basename($_FILES['image']['name']);
   // Move the uploaded file to the uploads directory
    move_uploaded_file($_FILES['image']['tmp_name'], $image_path);

    // Prepare and execute the insert query
    $sql = "INSERT INTO joueurs (nom, age, position, status, physical_condition, performance, height, weight, hometown, dream, achievements, medical_status, email, role, password, image_path) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisssiiidsssssss", $nom, $age, $position, $status, $physical_condition, $performance, $height, $weight, $hometown, $dream, $achievements, $medical_status, $email, $role, $password, $image_path);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New player added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Player Form</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        /* Validation Messages */
.validation-message {
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 8px;
    font-size: 14px;
    text-align: center;
    display: none; /* Hidden by default */
}

.validation-message.success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.validation-message.error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.validation-message.warning {
    background-color: #fff3cd;
    color: #856404;
    border: 1px solid #ffeeba;
}

        /* Body Styling */
        body {
            background-color: #f5f7fa; /* Light professional background */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
        }

        /* Form Container */
        .form-container {
            max-width: 900px;
            margin: auto;
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1); /* Professional shadow */
            border: 1px solid #e3e6eb;
            animation: fadeIn 0.4s ease-in-out;
        }

        /* Header Styling */
        .form-container h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
            font-weight: bold;
            color: #333333; /* Darker color for text */
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Form Group Styling */
        .form-label {
            font-weight: 600;
            color: #555555;
            margin-bottom: 6px;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1px solid #dcdfe3;
            transition: all 0.3s ease;
            box-shadow: none;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 6px rgba(0, 123, 255, 0.2);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }

        /* Input Group Styling */
        .input-group-text {
            background-color: #f9f9f9;
            border-radius: 8px 0 0 8px;
            border: 1px solid #dcdfe3;
            font-size: 14px;
            font-weight: 500;
            color: #555555;
        }

        /* Button Styling */
        .btn-primary {
            padding: 12px 25px;
            border-radius: 8px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transform: translateY(-2px);
        }

        /* Invalid Feedback Styling */
        .invalid-feedback {
            color: #d9534f;
        }

        /* Footer Text */
        .form-footer {
            text-align: center;
            font-size: 14px;
            color: #888888;
            margin-top: 20px;
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .btn-primary {
                width: 100%;
            }
        }

        /* Fade In Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Add New Player</h2>
        <form action="tables.php" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="row g-4">
                
                <!-- Full Name -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nom" class="form-label">Full Name</label>
                        <input type="text" id="nom" name="nom" class="form-control" placeholder="Enter player's full name" required>
                        <div class="invalid-feedback">Please provide a name.</div>
                    </div>
                </div>

                <!-- Age -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="age" class="form-label">Age</label>
                        <input type="number" id="age" name="age" class="form-control" placeholder="Enter player's age" min="1" max="100" required>
                        <div class="invalid-feedback">Please provide a valid age.</div>
                    </div>
                </div>

                <!-- Position -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="position" class="form-label">Position</label>
                        <input type="text" id="position" name="position" class="form-control" placeholder="e.g., Defender, Midfielder" required>
                        <div class="invalid-feedback">Please specify a position.</div>
                    </div>
                </div>

                <!-- Status -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-select" required>
                            <option value="active">Active</option>
                            <option value="blessee">Blessee</option>
                            <option value="repos">Repos</option>
                        </select>
                        <div class="invalid-feedback">Please select a status.</div>
                    </div>
                </div>

                <!-- Physical Condition -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="physical_condition" class="form-label">Physical Condition (0-100)</label>
                        <input type="number" id="physical_condition" name="physical_condition" class="form-control" min="0" max="100" value="100">
                    </div>
                </div>

                <!-- Performance -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="performance" class="form-label">Performance (0-100)</label>
                        <input type="number" id="performance" name="performance" class="form-control" min="0" max="100" value="100">
                    </div>
                </div>

                <!-- Height -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="height" class="form-label">Height (cm)</label>
                        <input type="number" id="height" name="height" class="form-control" step="0.01" placeholder="Enter height in cm" required>
                        <div class="invalid-feedback">Please provide a valid height.</div>
                    </div>
                </div>

                <!-- Weight -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="weight" class="form-label">Weight (kg)</label>
                        <input type="number" id="weight" name="weight" class="form-control" step="0.01" placeholder="Enter weight in kg" required>
                        <div class="invalid-feedback">Please provide a valid weight.</div>
                    </div>
                </div>

                <!-- Hometown -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="hometown" class="form-label">Hometown</label>
                        <input type="text" id="hometown" name="hometown" class="form-control" placeholder="Enter player's hometown" required>
                        <div class="invalid-feedback">Please provide a hometown.</div>
                    </div>
                </div>

                <!-- Dream -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="dream" class="form-label">Dream</label>
                        <input type="text" id="dream" name="dream" class="form-control" placeholder="Player's dream" required>
                        <div class="invalid-feedback">Please share the player's dream.</div>
                    </div>
                </div>

                <!-- Achievements -->
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="achievements" class="form-label">Achievements</label>
                        <textarea id="achievements" name="achievements" class="form-control" placeholder="List achievements"></textarea>
                    </div>
                </div>

                <!-- Medical Status -->
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="medical_status" class="form-label">Medical Status</label>
                        <textarea id="medical_status" name="medical_status" class="form-control" placeholder="Describe medical status"></textarea>
                    </div>
                </div>
                <input type="text" name="role" value="joueur">
                <!-- Email -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter player's email" required>
                        <div class="invalid-feedback">Please provide a valid email.</div>
                    </div>
                </div>

                <!-- Password -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter password" required>
                        <div class="invalid-feedback">Please provide a password.</div>
                    </div>
                </div>

                <!-- Profile Image -->
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="image_path" class="form-label">Profile Image</label>
                        <input type="file" id="image_path" name="image_path" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="form-actions text-center mt-4">
                <button type="submit" class="btn btn-primary">Add Player</button>
            </div>
        </form>
        <div class="form-footer">
            <p>&copy; 2024 Player Management System. All rights reserved.</p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Form Validation Script -->
    <script>
        // Bootstrap validation example
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })();
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const validationMessages = document.querySelectorAll('.validation-message');
        validationMessages.forEach(msg => {
            msg.style.display = 'block'; // Show the message
            setTimeout(() => {
                msg.style.display = 'none'; // Hide after 5 seconds
            }, 5000);
        });
    });
</script>

</body>
</html>
