<?php
session_start();
include('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['login'])==0) {
    header('location:index.php');
} else {
    $errors = [];
    $success = false;

    if(isset($_POST['add'])) {
        function sanitizeInput($data) {
            return htmlspecialchars(stripslashes(trim($data)));
        }

        $name = sanitizeInput($_POST['name']);
        $lastName = sanitizeInput($_POST['lastName']);
        $email = sanitizeInput($_POST['email']);
        $phone = sanitizeInput($_POST['phone']);
        $message = sanitizeInput($_POST['message']);

        // Validate required fields
        if (empty($name) || empty($lastName) || empty($email) || empty($phone) || empty($message)) {
            $errors[] = "All fields are required";
        }

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format";
        }

        // Check for errors
        if (empty($errors)) {
            $sid = $_SESSION['stdid'];
            $sql = "INSERT INTO contactus(Name, LastName, Email, Phone, Message, StudentId) VALUES(:name, :lastName, :email, :phone, :message, :sid)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':sid', $sid, PDO::PARAM_STR);
            $query->bindParam(':name', $name, PDO::PARAM_STR);
            $query->bindParam(':lastName', $lastName, PDO::PARAM_STR);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->bindParam(':phone', $phone, PDO::PARAM_STR);
            $query->bindParam(':message', $message, PDO::PARAM_STR);
            $query->execute();
            $lastInsertId = $dbh->lastInsertId();

            if ($lastInsertId) {
                $_SESSION['msg'] = "Your message has been sent successfully.";
                header('location:contact-us.php');
                exit();
            } else {
                $errors[] = "Something went wrong. Please try again.";
            }
        } else {
            $errors[] = "Failed to send message. Please try again later.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Qlik2Read | Contact Us</title>
    <meta name="description" content="Contact Us Form">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/bootstrap-4-forms/contact-form-1-modal.php" />
    <!-- Include Bootstrap CSS (version 3.3.7) -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"> 
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <style>
        label {
            font-weight: bold;
        }

        textarea.form-control {
            resize: none;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            width: 100%;
            padding: 12px;
            font-size: 16px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .alert {
            margin-bottom: 20px;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }

        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }
    </style>
</head>

<body>
    
<?php include('includes/header.php');?>
<div class="content-wrapper">
    <div class="container">
        <h1>Contact US</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="user-name"><i class="fas fa-user" aria-hidden="true"></i> First Name</label><span>*</span>
                <input type="text" class="form-control" id="user-name" name="name" placeholder="First Name" required>
            </div>
            <div class="form-group">
                <label for="user-first-name"><i class="fas fa-user" aria-hidden="true"></i> Last Name</label><span>*</span>
                <input type="text" class="form-control" id="user-first-name" name="lastName" placeholder="Last Name" required>
            </div>
            <div class="form-group">
                <label for="user-email"><i class="fas fa-envelope" aria-hidden="true"></i> Email</label><span>*</span>
                <input type="email" class="form-control" id="user-email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <label for="user-phone"><i class="fas fa-phone" aria-hidden="true"></i> Phone</label><span>*</span>
                <input type="tel" class="form-control" id="user-phone" name="phone" placeholder="Phone" required>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea class="form-control" id="message" name="message" rows="5" placeholder="Message" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary" name="add"><i class="fas fa-envelope" aria-hidden="true"></i> Send Message</button>
        </form>
    </div>
</div>
    
<?php include('includes/footer.php');?>

<!-- Include jQuery 1.12.4 -->
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<!-- Include Bootstrap JS (version 3.3.7) -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- Custom Scripts -->
<script src="assets/js/custom.js"></script>
</body>

</html>
<?php } ?>
