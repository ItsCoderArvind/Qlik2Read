<?php 
session_start();
include('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['login'])==0)
    {   
header('location:index.php');
}
else{ 
if(isset($_POST['update']))
{    
$sid=$_SESSION['stdid'];  
$fname=$_POST['fullanme'];
$mobileno=$_POST['mobileno'];
$updateDate=$_POST['updateDate'];

$sql="update tblstudents set FullName=:fname,MobileNumber=:mobileno,UpdateDate=:updateDate where StudentId=:sid";
$query = $dbh->prepare($sql);
$query->bindParam(':sid',$sid,PDO::PARAM_STR);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':mobileno',$mobileno,PDO::PARAM_STR);
$query->bindParam(':updateDate',$updateDate,PDO::PARAM_STR);
$query->execute();

echo '<script>alert("Your profile has been updated")</script>';
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title>Qlik2Read | Student Profile</title>
    <!-- BOOTSTRAP CORE STYLE -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

    <style>
        /* body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f5f5f5;
        } */

        .header-line {
            color: #007bff;
            margin-bottom: 20px;
        }

        /* .content-wrapper {
            padding-top: 30px;
        } */

        .panel-danger > .panel-heading {
  background-color: #007bff; /* Blue color for panel heading */
  border-color: #007bff;
  color: #fff;
  font-size: 18px;
  font-weight: bold;
}

        .panel-body {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-control {
            border-radius: 4px;
            box-shadow: none;
            border-color: #ddd;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
        }

        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .form-group span {
            font-weight: bold;
        }

        .panel {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <!------MENU SECTION START-->
    <?php include('includes/header.php'); ?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <!-- <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">My Profile</h4>
                </div>
            </div> -->
            <div class="row">
                <div class="col-md-9 col-md-offset-1">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            My Profile
                        </div>
                        <div class="panel-body">
                            <form name="signup" method="post">
                                <?php
                                $sid = $_SESSION['stdid'];
                                $sql = "SELECT StudentId,FullName,EmailId,MobileNumber,RegDate,UpdateDate,Status from tblstudents where StudentId=:sid ";
                                $query = $dbh->prepare($sql);
                                $query->bindParam(':sid', $sid, PDO::PARAM_STR);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                $cnt = 1;
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $result) {
                                ?>
                                        <div class="form-group">
                                            <label>Student Id: </label>
                                            <span><?php echo htmlentities($result->StudentId); ?></span>
                                        </div>

                                        <div class="form-group">
                                            <label>Registration Date : </label>
                                            <span><?php echo htmlentities($result->RegDate); ?></span>
                                        </div>
                                        <?php if ($result->UpdateDate != "") { ?>
                                            <div class="form-group">
                                                <label>Last Updation Date : </label>
                                                <span><?php echo htmlentities($result->UpdateDate); ?></span>
                                            </div>
                                        <?php } ?>

                                        <div class="form-group">
                                            <label>Profile Status : </label>
                                            <?php if ($result->Status == 1) { ?>
                                                <span style="color: green">Active</span>
                                            <?php } else { ?>
                                                <span style="color: red">Blocked</span>
                                            <?php } ?>
                                        </div>

                                        <div class="form-group">
                                            <label>Enter Full Name</label>
                                            <input class="form-control" type="text" name="fullanme" value="<?php echo htmlentities($result->FullName); ?>" autocomplete="off" required />
                                            <input class="form-control" type="hidden" name="updateDate" value="<?php echo date('Y-m-d H:i:s'); ?>" />
                                        </div>

                                        <div class="form-group">
                                            <label>Mobile Number :</label>
                                            <input class="form-control" type="text" name="mobileno" maxlength="10" value="<?php echo htmlentities($result->MobileNumber); ?>" autocomplete="off" required />
                                        </div>

                                        <div class="form-group">
                                            <label>Enter Email</label>
                                            <input class="form-control" type="email" name="email" id="emailid" value="<?php echo htmlentities($result->EmailId); ?>" autocomplete="off" required readonly />
                                        </div>
                                <?php }
                                } ?>

                                <button type="submit" name="update" class="btn btn-primary" id="submit">Update Now</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php'); ?>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
</body>

</html>

<?php } ?>
