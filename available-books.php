<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
    {   
header('location:index.php');
}
else{ 
if(isset($_GET['del']))
{
// $id=$_GET['del'];
// $sql = "delete from tblbooks  WHERE BookId=:id";
// $query = $dbh->prepare($sql);
// $query -> bindParam(':id',$id, PDO::PARAM_STR);
// $query -> execute();
// $_SESSION['delmsg']="Category deleted scuccessfully ";
// header('location:manage-books.php');

}


    ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Qlik2Read | Books Available</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
      rel="stylesheet"
    />    
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- DATATABLE STYLE  -->
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <style>
    .input-group {
      display: flex;
      background-color: aquamarine;
    }
    </style>
</head>
<body>
      <!------MENU SECTION START-->
<?php include('includes/header.php');?>
<!-- MENU SECTION END-->
    <div class="content-wrapper">
         <div class="container">
                    
         
    <form id="searchForm" method="GET" action="available-books.php">
    <div class="input-group">
        <input type="search" name="searchBarId" id="searchBarId" class="form-control" placeholder="Search..." aria-label="Search">
        <div class="input-group-append">
            <button id="btnStart" style="border-left: 0; border-right: 0; border-top: 0; border-bottom: 0;" class="btn btn-secondary" type="button">
                <i class="fas fa-microphone"></i>    
            </button>
        </div>
        <button style="border-left: 0; border-right: 0; border-top: 0; border-bottom: 0;" id="btnSearch" class="btn btn-primary" type="button"> <i class="fas fa-search"></i> </button>
        </div>
    </form>

        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Books Available</h4>
    </div>
     <div class="row">
    <?php if($_SESSION['error']!="")
    {?>
<div class="col-md-6">
<div class="alert alert-danger" >
 <strong>Error :</strong> 
 <?php echo htmlentities($_SESSION['error']);?>
<?php echo htmlentities($_SESSION['error']="");?>
</div>
</div>
<?php } ?>
<?php if($_SESSION['msg']!="")
{?>
<div class="col-md-6">
<div class="alert alert-success" >
 <strong>Success :</strong> 
 <?php echo htmlentities($_SESSION['msg']);?>
<?php echo htmlentities($_SESSION['msg']="");?>
</div>
</div>
<?php } ?>
<?php if($_SESSION['updatemsg']!="")
{?>
<div class="col-md-6">
<div class="alert alert-success" >
 <strong>Success :</strong> 
 <?php echo htmlentities($_SESSION['updatemsg']);?>
<?php echo htmlentities($_SESSION['updatemsg']="");?>
</div>
</div>
<?php } ?>


   <?php if($_SESSION['delmsg']!="")
    {?>
<div class="col-md-6">
<div class="alert alert-success" >
 <strong>Success :</strong> 
 <?php echo htmlentities($_SESSION['delmsg']);?>
<?php echo htmlentities($_SESSION['delmsg']="");?>
</div>
</div>
<?php } ?>

</div>


        </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Books Listing
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Book Name</th>
                                            <th>Category</th>
                                            <th>Author</th>
                                            <th>ISBN</th>
                                            <th>Price</th>
                                            <th style="width:16%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php    $searchBarValue = trim($_GET['searchBarId']); // Get the bookName from the URL query parameter
    // Prepare the SQL query with the provided bookName
    $sql = "SELECT tblbooks.BookName, tblcategory.CategoryName, tblauthors.AuthorName, tblbooks.ISBNNumber, tblbooks.BookPrice, tblbooks.BookId as bookid 
            FROM tblbooks 
            JOIN tblcategory ON tblcategory.CatId = tblbooks.CatId 
            JOIN tblauthors ON tblauthors.AuthorId = tblbooks.AuthorId 
            WHERE tblbooks.BookName LIKE '%$searchBarValue%' OR tblbooks.BookName = ''
            or tblcategory.CategoryName LIKE '%$searchBarValue%' OR tblcategory.CategoryName = ''
            or tblauthors.AuthorName LIKE '%$searchBarValue%' OR tblauthors.AuthorName = ''
            or tblbooks.ISBNNumber LIKE '%$searchBarValue%' OR tblbooks.ISBNNumber = ''";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>                                      
                                        <tr class="odd gradeX">
                                            <td class="center"><?php echo htmlentities($cnt);?></td>
                                            <td class="center"><?php echo htmlentities($result->BookName);?></td>
                                            <td class="center"><?php echo htmlentities($result->CategoryName);?></td>
                                            <td class="center"><?php echo htmlentities($result->AuthorName);?></td>
                                            <td class="center"><?php echo htmlentities($result->ISBNNumber);?></td>
                                            <td class="center"><?php echo htmlentities($result->BookPrice);?></td>
                                            <td class="center">

                                            <a href="download.php?bookid=<?php echo htmlentities($result->bookid); ?>">
                                            <button class="btn btn-primary">
                                            <i class="fa fa-download"></i> Download
                                            </button>
                                            </a>

                                         <!--  <a href="manage-books.php?del=<?php echo htmlentities($result->bookid);?>" onclick="return confirm('Are you sure you want to delete?');" >  <button class="btn btn-danger"><i class="fa fa-pencil"></i> Delete</button> -->
                                            </td>
                                        </tr>
 <?php $cnt=$cnt+1;}} ?>                                      
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>


            
    </div>
    </div>

     <!-- CONTENT-WRAPPER SECTION END-->
  <?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- DATATABLE SCRIPTS  -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
      <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
    <script>
    document.getElementById('btnSearch').addEventListener('click', function() {
        document.getElementById('searchForm').submit(); // Submit the form when btnSearch is clicked
    });
</script>
    <script>
      const searchBarVal = document.getElementById('searchBarId');

      if ('webkitSpeechRecognition' in window) {
    // Speech recognition API is available
    var recognition = new webkitSpeechRecognition();
    // Your code to use the recognition object
        } else {
    // Speech recognition API is not supported
    console.log('Speech recognition is not supported in this browser.');
    }
      recognition.continuous = false;
      recognition.lang = 'en-US';
      recognition.interimResults = false;
      recognition.maxAlternatives = 1;
      var buttonStart = document.getElementById('btnStart')
      // var buttonStop = document.getElementById('btnStop')
      var test = document.getElementById('testSpeak')
      //buttonStop.style.display = 'none'
      buttonStart.onclick = function () {
      buttonStart.style.display = 'none'
        //buttonStop.style.display = 'block'
        recognition.start();
      }
      recognition.onresult = function (event) {
        searchBarVal.value = event.results[0][0].transcript
      }
      recognition.onspeechend = function () {
        buttonStart.style.display = 'block'
        //buttonStop.style.display = 'none'
        recognition.stop();
      }
      recognition.onnomatch = function (event) {
        diagnostic.textContent = "I didn't recognise that color.";
      }
      recognition.onerror = function (event) {
        diagnostic.textContent = 'Error occurred in recognition: ' + event.error;
      }
      </script> 
</body>
</html>
<?php } ?>
