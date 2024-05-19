<?php
session_start();
include('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['login'])==0)
    {   
header('location:index.php');
}
else{ 

// Function to sanitize input
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Check if bookid is set
if (isset($_GET['bookid'])) {
    $bookid = sanitizeInput($_GET['bookid']);

    // Query to get the book details
    $sql = "SELECT * FROM tblbooks WHERE BookId = :bookid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':bookid', $bookid, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);

    if ($query->rowCount() > 0) {
        $fileName = basename($result->BookName);
        $pdf = ".pdf";
        $filePath = 'assets/books/' . $fileName.$pdf;
        // Debugging output
        if (file_exists($filePath) && is_readable($filePath)) {
            // Set headers to initiate download
            header('Content-Description: File Transfer');
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));
            readfile($filePath);
            exit;
        } else {
            echo "File not found or not available.";
        }
    } else {
        echo "Invalid book ID.";
    }
} else {
    echo "No book ID specified.";
}
}
?>
