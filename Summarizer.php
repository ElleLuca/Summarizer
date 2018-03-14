<?php 
  ini_set('session.gc_maxlifetime',60*60*6);
  ini_set('session.gc_probability',1);
  ini_set('session.gc_divisor',1);
  session_start();

//  echo $_SESSION['loggedin'];
//  echo " ";
//  echo $_SESSION["Last_Activity"];
//  echo " ";
//  echo time();
 if(!isset($_SESSION['loggedin'])){
   
  header("Location:logout.php");
  exit();
}

// if (isset($_SESSION["Last_Activity"]) && (time() - $_SESSION["Last_Activity"] >2880000)) {

//   header("Location:logout.php");



// }else{

//  $_SESSION["Last_Activity"] = time();
 
// }
  $user=$_SESSION['loggedin'];
  $type=$_SESSION['type'];

?>
<html lang="en">
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->

<!-- Latest compiled JavaScript -->

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
  <style>
    .paginate_button{
      margin-left:5px;
    } 
    .navbar{
      z-index:1;
      min-height:33px;
    }
    #SummarizerTable_filter{
      position:fixed;
      margin-left:60%;
      margin-top:-77px;
      z-index:9999;
    }
    
  </style>


</head>
<?php

echo ' 
  <body>
  
    <div style="width:80%;margin-left:auto;margin-right:auto">
      <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
          <p style="display:inline">'.$user.'</p>
          <button style="margin-left:40px;display:inline-block" ><a href="logout.php">Log Out</a></button>
          <button style="margin-top:5px;display:inline-block"><a href="loader.php">Loader</a></button>
          <h2 style="text-align:center; margin-top:-29px;">Summarizer</h2>
          <p style="margin-top:-23px;">'.$type.'</p>
        </div>
      </nav>
  
    <p style="text-align:center; margin-top:58px">List of active securities</p>
    
    <table style="margin-right:10%" id="SummarizerTable" class="table table-striped">
      <thead>
        <tr>
          <th>Symbol</th>
          <th>Analysis Date</th>
          <th>Current Price ($)</th>
          <th>Price Target</th>
          <th>Upside</th>
          <th>Rank</th>
          <th>Target Weight</th>
          <th>Actual Weight</th>
          <th>Difference</th>
          <th>Next Earnings Date</th>
        </tr>
      </thead>
      <tbody>';
    
     
      
       
         
          $con = mysqli_connect("rendertech.com","pupone_Runhao","Runhao1212","pupone_Summarizer");
          if (!$con)
            {
            die('Could not connect: '.mysqli_error());
            }

          mysqli_select_db($con,"pupone_Summarizer");
          if($result = mysqli_query($con,"SELECT symbol, price, analysis_date, price_target, upside, rank, target_weight,actual_weight,diff,next_earnings FROM main_table"))
          {
              /* pull data from database and insert into data table. */
              while($row = mysqli_fetch_array($result))
              {
                  echo '<tr>
                          <td ><a class="name" >'.$row['symbol'].'</a></td>
                          <td>'.$row['analysis_date'].'</td>
                          <td>'.$row['price'].'</td>
                          <td>'.$row['price_target'].'</td>
                          <td>'.$row['upside'].'</td>
                          <td>'.$row['rank'].'</td>
                          <td>'.$row['target_weight'].'</td>
                          <td>'.$row['actual_weight'].'</td>
                          <td>'.$row['diff'].'</td>
                          <td>'.$row['next_earnings'].'</td>
                        </tr>'     ;   
              }
              mysqli_free_result($result);
        }
          mysqli_close($con);
          
      
          ?>
    </tbody>
  </table>
</div>
<?php $_SESSION["selected_symbol"]=$_POST["symbol"] ?>
<footer style="text-align:center">
  <p>Prototype Posted by: Runhao Zhao</p>
  <p>Date Released: 02/04/2018</p>
  <nav>
  <a href="SummarizerLogin.html">Login</a>
  <a href="SummarizerStock.html">Stock</a>
  <a href="SummarizerTable.html">Table</a>
</nav>
</footer>

<script>
$(document).ready(function() {
 
$('#SummarizerTable').DataTable({
    paging: false
   
});


$(document).on("click", ".name", function() {
    var mySymbol = $(this).text();
             
    window.location.href = 'symbol.php?name='+mySymbol;

       
});
})
</script>
</body>
</html>

