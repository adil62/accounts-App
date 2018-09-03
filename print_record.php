<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Print record</title>
    <link rel="stylesheet" href="vendor/css/bootstrap-4.1.2-dist/bootstrap.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
    
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
             background: 
            url("resources/images/background.jpg");
        }
        .fa-cus{
            font-size: 1.5em;
        }
    </style>
    
</head>

<body>
<div class="header">
    <div class="row">
    <div class="col-md-2 my-3 mx-3">
        <a href="index.php" class="btn btn-warning d-inline btn-lg">Go Back</a>   
    </div>
    </div>
</div>
<div class="container-fluid">
   <form action="" class="form-group" method="POST">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-4">
                <label for="date" class="">Paraticular Date</label>
                <input type="text" id="date" placeholder="Select" name="date" size="12">

            </div>
            <div class="col-md-6">
               <label for="date2">Date From</label>
<!--                <input type="date" id="date2" name="datePer1" value="from">   -->
               <input placeholder="From" name="datePer1" type="text" id="date2" size="12">
               <label>To</label>
               <input placeholder="To" name="datePer2" type="text" id="date3" size="12">
               <input type="submit" name="submit" class="btn btn-outline-success">   
            </div>
               

        </div>
    </form>
<script type="text/javascript">
$(document).ready(function(){
    $('#date').datepicker({format: "dd-mm-yyyy"});
    $('#date2').datepicker({format: "dd-mm-yyyy"});
    $('#date3').datepicker({format: "dd-mm-yyyy"});
});
    
</script>
<?php   

if(isset($_POST['submit'])){
    require_once 'connection.php';
    // function to find the difference / number of days between 2 dates(intimestamps) 
    // then rconverts the difference in seconds to days by deviding it with 86400(24hours in seconds)
    function daydiff($from,$to){
        $re  = $to-$from;
        $re  = round($re/86400);
        // echo $re;
        return $re;
    }
    function formatDate($date){
        if ($date!="") {
            $date = explode("-",$date);
            // print_r( $date);echo "<br>";
            $date = $date[0]."-".$date[1]."-".$date[2];
            // print_r($date);        
            $date = trim($date);
        }
//        echo $date;
        return $date;
    }
    // makes array of strings to actual date format
    function generateDate($day,$month,$year){
        if (strlen($day)==1) {
            // echo "<br>len is 1 ";
            $date = "0".$day."-".$month."-".$year;      
        }else{
            $date = $day."-".$month."-".$year;
        }
        // echo "agenratDate()".$date."<br>";
        return $date;
    }
    function calculateDates($from,$days){
        $genDate_combi = array();
        $init = date("d-m-Y",$from);
        $init = explode("-", $init);// echo "in the calc";// echo $init[0]."--before";// echo $init[1];// echo $init[2];
        $i=1;
        while($days>$i){
            $init[0] = $init[0]+1;
            $genDate = generateDate($init[0],$init[1],$init[2]);
            array_push($genDate_combi, $genDate);
            // echo $init[0];
            $i++;
        }
//         print_r($genDate_combi);
        return $genDate_combi;
    }


    function build_query($gendate){
        $date_string    = implode("','", $gendate);
        $query = "SELECT *FROM records WHERE date IN('$date_string')";
//             echo $query;
            return $query;  

    }
    function displayRecords($result){
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
    <?php } 


    if(!$conn){echo "errrrrrrr";}
    $date =      $_POST['date'];
    $date_from = $_POST['datePer1'];
    $date_to   = $_POST['datePer2'];
    
    $flag = $date_from != "" && $date_to != "" ?1:0;
//     echo "flag is ".$flag;
//    echo "date is ".$date;

    $date = formatDate($date);
    $date_from = formatDate($date_from);
    $date_to = formatDate($date_to);
    // echo $date_from.$date_to;

//    echo "<br>".$date;
    if($flag == false){
        $query = "SELECT *FROM records WHERE date='$date'";
        $result = mysqli_query($conn,$query);
    //    var_dump($result);
        displayRecords($result);

        
    }elseif ($flag==true) {
        $from = strtotime($date_from);
        $to   = strtotime($date_to);
        $days = daydiff($from,$to);
//        echo "<br>$days";
        // print_r($genDate_combi);
        $genDate_combi  = calculateDates($from,$days);
        // echo $date_from.$date_to;

        // echo sizeof($genDate_combi);
        $query  = build_query($genDate_combi);
        $result = mysqli_query($conn,$query);
        if (!$result) {
            echo mysqli_error($conn);
        }
        // print_r($result);   
        displayRecords($result);

    }
    ?>    
    <!--container ends here  -->
    </div> <?php
    
}
?>
    </body>

    </html>



