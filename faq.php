<?php
session_start();
include('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['login'])==0) {
    header('location:index.php');
} else {
$faqs = [
    [
        "question" => "What should I do if I lose a book?",
        "answer" => "If you lose a book, please report it immediately to the library staff. You may be required to pay a replacement fee or provide a new copy of the lost book."
    ],
    [
        "question" => "How can I search for books in the library catalog?",
        "answer" => "Use the search bar on the library's website to search for books by title, author, subject, or ISBN. You can also browse categories and new arrivals."
    ],
    [
        "question" => "Are there any late fees for overdue books?",
        "answer" => "Yes, overdue books are subject to late fees. The fee amount depends on the type of book and how long it is overdue. Please refer to the library's fee schedule for details."
    ],
    [
        "question" => "How can I reserve a book that is currently checked out?",
        "answer" => "To reserve a book that is currently checked out, log in to your account, search for the book, and click on the 'Reserve' button. You will be notified when the book becomes available."
    ],
    [
        "question" => "Can I access digital resources from the library?",
        "answer" => "Yes, the library offers access to various digital resources, including e-books, audiobooks, and online journals. You can access these resources through the library's website using your library account."
    ],
    [
        "question" => "How can I suggest a new book for the library to acquire?",
        "answer" => "To suggest a new book for the library to acquire, fill out the 'Book Suggestion' form available on the library's website. Provide as much information as possible about the book, including the title, author, and ISBN."
    ],
    [
        "question" => "What are the library's opening hours?",
        "answer" => "The library's opening hours are Monday to Friday from 9 AM to 6 PM, and Saturday from 10 AM to 4 PM. The library is closed on Sundays and public holidays."
    ],
    [
        "question" => "How can I volunteer at the library?",
        "answer" => "If you are interested in volunteering at the library, please visit the 'Volunteer' section on our website to learn more about available opportunities and to fill out an application form."
    ],
    [
        "question" => "What facilities are available at the library?",
        "answer" => "The library offers various facilities including free Wi-Fi, computer access, study rooms, printing and photocopying services, and a quiet reading area."
    ]
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qlik2Read - FAQ</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .faq-header {
            margin-top: 50px;
            margin-bottom: 20px;
            color: #007bff;
        }

        .faq-section {
            margin-top: 30px;
        }

        .panel {
            margin-bottom: 20px;
            border-radius: 5px;
            border-color: #ddd;
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
        }

        .panel-heading {
            background-color: #f8f8f8;
            border-color: #ddd;
            border-bottom: 0;
            cursor: pointer;
            padding: 15px;
        }

        .panel-heading:hover {
            background-color: #e9ecef;
        }

        .panel-body {
            padding: 15px;
            background-color: #fff;
        }

        .panel-title {
            font-size: 16px;
            font-weight: bold;
        }

        .panel-group .panel + .panel {
            margin-top: 10px;
        }
    </style>
    <link href="assets/css/style.css" rel="stylesheet" />
</head>

<body>
    <?php include('includes/header.php'); ?>
    <div class="content-wrapper">
        <div class="container">
            <h1 class="text-center faq-header">Frequently Asked Questions</h1>
            <div id="faqAccordion" class="panel-group">
                <?php foreach ($faqs as $index => $faq): ?>
                    <div class="panel panel-default">
                        <div class="panel-heading" id="heading<?php echo $index; ?>" data-toggle="collapse" data-parent="#faqAccordion" href="#collapse<?php echo $index; ?>" aria-expanded="true" aria-controls="collapse<?php echo $index; ?>">
                            <h4 class="panel-title">
                                <?php echo htmlspecialchars($faq['question']); ?>
                            </h4>
                        </div>
                        <div id="collapse<?php echo $index; ?>" class="panel-collapse collapse" aria-labelledby="heading<?php echo $index; ?>">
                            <div class="panel-body">
                                <?php echo htmlspecialchars($faq['answer']); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>

    <!-- Include jQuery 1.12.4 -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <!-- Include Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Custom Scripts -->
    <script>
        $(document).ready(function () {
            $('.panel-heading').on('click', function () {
                var target = $(this).attr('href');
                $(target).collapse('toggle');
            });
        });
    </script>
</body>

</html>


<?php } ?>
