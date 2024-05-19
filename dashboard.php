<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else { ?>
    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Qlik2Read | User Dashboard</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
        <link href="assets/css/bootstrap.css" rel="stylesheet" />
        <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <link href="assets/css/style.css" rel="stylesheet" />
        <style>
            body {
                font-family: 'Open Sans', sans-serif;
                background-color: #f5f5f5;
            }

            /* .header-line {
                color: #007bff;
                margin-bottom: 20px;
            } */

            .back-widget-set {
                padding: 20px;
                border-radius: 5px;
                transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            }

            .back-widget-set:hover {
                transform: translateY(-5px);
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            }
        </style>
    </head>

    <body>
        <!------MENU SECTION START-->
        <?php include('includes/header.php'); ?>
        <!-- MENU SECTION END-->
        <div class="content-wrapper">
            <div class="container">
                <div class="row pad-botm">
                    <div class="col-md-12">
                        <h4 class="header-line">USER DASHBOARD</h4>
                    </div>
                </div>

                <div class="row">
                    <a href="available-books.php">
                        <div class="col-md-3 col-sm-3 col-xs-6">
                            <div class="alert alert-success back-widget-set text-center">
                                <i class="fa fa-book fa-5x"></i>
                                <?php
                                $sql = "SELECT BookId from tblbooks";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                $listdbooks = $query->rowCount();
                                ?>
                                <h5>Available Books: <?php echo htmlentities($listdbooks); ?></h5>
                            </div>
                        </div>
                    </a>

                    <a href="issued-books.php">
                        <div class="col-md-3 col-sm-3 col-xs-6">
                            <div class="alert alert-info back-widget-set text-center">
                                <i class="fa fa-bars fa-5x"></i>
                                <?php
                                $sid = $_SESSION['stdid'];
                                $sql1 = "SELECT IssueId from tblissuedbookdetails where StudentID=:sid";
                                $query1 = $dbh->prepare($sql1);
                                $query1->bindParam(':sid', $sid, PDO::PARAM_STR);
                                $query1->execute();
                                $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                                $issuedbooks = $query1->rowCount();
                                ?>
                                <h5>Book Issued: <?php echo htmlentities($issuedbooks); ?></h5>
                            </div>
                        </div>
                    </a>

                    <a href="issued-books.php">
                        <div class="col-md-3 col-sm-3 col-xs-6">
                            <div class="alert alert-warning back-widget-set text-center">
                                <i class="fa fa-recycle fa-5x"></i>
                                <?php
                                $rsts = 0;
                                $sql2 = "SELECT IssueId from tblissuedbookdetails where StudentID=:sid and ReturnStatus=:rsts";
                                $query2 = $dbh->prepare($sql2);
                                $query2->bindParam(':sid', $sid, PDO::PARAM_STR);
                                $query2->bindParam(':rsts', $rsts, PDO::PARAM_STR);
                                $query2->execute();
                                $results2 = $query2->fetchAll(PDO::FETCH_OBJ);
                                $returnedbooks = $query2->rowCount();
                                ?>
                                <h5>Books Not Returned Yet: <?php echo htmlentities($returnedbooks); ?></h5>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <!-- CONTENT-WRAPPER SECTION END-->
        <?php include('includes/footer.php'); ?>
        <?php
        $sid = $_SESSION['stdid'];
        $sql1 = "SELECT FullName from tblstudents where StudentId=:sid";
        $query1 = $dbh->prepare($sql1);
        $query1->bindParam(':sid', $sid, PDO::PARAM_STR);
        $query1->execute();
        $results1 = $query1->fetch(PDO::FETCH_ASSOC); // Using fetch instead of fetchAll
        $fullName = $results1['FullName']; // Extracting the full name
        ?>
        <!-- FOOTER SECTION END-->
        <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME -->
        <!-- CORE JQUERY -->
        <script src="assets/js/jquery-1.10.2.js"></script>
        <!-- BOOTSTRAP SCRIPTS -->
        <script src="assets/js/bootstrap.js"></script>
        <!-- CUSTOM SCRIPTS -->
        <script src="assets/js/custom.js"></script>
        <script>
            $(document).ready(function() {
                function func() {
                    var u = new SpeechSynthesisUtterance();
                    u.text = 'Hello <?php echo $fullName; ?> Welcome to Qlik2Read'; // Passing PHP variable to JavaScript
                    u.lang = 'en-US';
                    u.rate = 1.2;
                    speechSynthesis.speak(u);
                }
                func();
            });
        </script>
    </body>

    </html>
<?php } ?>
