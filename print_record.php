<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Print record</title>
    <link rel="stylesheet" href="vendor/css/bootstrap-4.1.2-dist/bootstrap.css">
    <style>
        .container{
            margin: 5% 50%;
            transform: translateX(-50%);
        }
        .input-field{
            margin-left: 10%;
            margin-right: 3%;     
            width: 50%;
        }
        .margin-top{
            margin-top: 5%;
        }
        body{
            height: 100vh;
             background: linear-gradient(rgba( 255, 255, 255, 0.7), rgba( 255, 255, 255, 0.7)),
    url("https://wallpaperwire.com/wp-content/uploads/2018/03/Abstract-background-3.jpg");
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            
                <form action="" method="post" class="form-group input-field">
                    <input type="date" name="date" class="form-control">
                    <input type="submit" name="submit" class="btn btn-primary form-control">
                </form>
                <div class="col-md-4">
                <button class="btn btn-warning d-inline" ><a href="http://localhost/accountsApp" >Goback</a></button>
            </div>
        </div>
    

<?php   

if(isset($_POST['submit'])){
    $date = $_POST['date'];
//    echo "date is ".$date;
    $date = explode("-",$date);
    $date = $date[2]."-".$date[1]."-".$date[0];
    $date = trim($date);
//    echo "<br>".$date;
    $conn = mysqli_connect('localhost','root','','accounts');
    $query = "SELECT *FROM records WHERE date='$date'";
    $result = mysqli_query($conn,$query);
    
    ?>
    <table class="table table-dashed table-hover table-condensed margin-top">
        <tr>
            <th>No.</th>
            <th>Amount</th>
            <th>Gross</th>
            <th>Charge</th>
            <th>Income</th>
            <th>Type</th>
            <th>Date</th>
        </tr>
        
        <?php
               while( $row = mysqli_fetch_assoc($result) ){
                   ?>
                   <tr>
                       <td><?php echo $row['id']; ?></td>
                       <td><?php echo $row['amount']; ?></td>
                       <td><?php echo $row['gross']; ?></td>
                       <td><?php echo $row['charge']; ?></td>
                       <td><?php echo $row['income']; ?></td>
                       <td><?php echo $row['type']; ?></td>
                       <td><?php echo $row['date']; ?></td>
                   </tr><?php
               }?>

    </table>
</div>
  </body>

</html>
    <?php
    
}














?>