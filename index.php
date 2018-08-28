<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="vendor/css/bootstrap-4.1.2-dist/bootstrap.css">
    <link rel="stylesheet" href="vendor/css/bootstrap-4.1.2-dist/bootstrap.js">
    <link rel="stylesheet" href="resources/css/page_1.css">
    <link rel="stylesheet" href="resources/css/style.css">
</head>

<body>
    <div class="container">
        <div class="row">
<!--             <div class="col-md-6 mt-3">
                <a href="#" class="top-bg px-5 offset-md-3" id="totalIncomeTop"><strong>Total income:</strong></a>
            </div>

            <div class="col-md-6 mt-3">
                <a href="#" class="top-bg px-5 offset-md-3" id="totalBankBalanceTop"><strong>Bank balance</strong></a>
            </div> -->

            <div class="top-info">
                <div class="info1">
                    <span class="info1-txt">Total Income</span>
                    <span class="info1-value" id="totalIncomeTop">-----</span>
                </div>
                <div class="info2">
                    <span class="info2-txt">Bank Balance</span>
                    <span class="info2-value" id="totalBankBalanceTop" >-------</span>
                </div>

            </div>


        </div>
        <hr>
        <form action="" method="post" class="form-group">
            <div class="row">
                <div class="col-md-2">
                    <p class="font-weight-bold">Bill</p>
                    <input type="text" class="form-control" name="b_amount" required="required" id="bAmount" autofocus>
                </div>
                <div class="col-md-2">
                    <p class="font-weight-bold">Charge</p>
                    <input type="text" class="form-control" name="b_charge" required="required" id="bCharge">
                </div>
                <div class="col-md-2">
                    <p class="font-weight-bold">Gross</p>
                    <input type="text" class="form-control" name="b_gross" required="required" disabled id=bGross>
                </div>
                <div class="col-md-2">
                    <p class="font-weight-bold">Tendercash</p>
                    <input type="text" class="form-control" name="b_tenderCash" required="required" id="bTenderCash">
                </div>
                <div class="col-md-2">
                    <p class="font-weight-bold">Balance</p>
                    <input type="text" class="form-control" name="b_balance" required="required" id="bBalance" disabled>

                </div>
                <div class="col-md-2">
                    <p class="font-weight-bold">Income</p>
                    <input type="text" class="form-control" name="b_income" required="required" id="bIncome" disabled>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 py-3">
                    <select name="b_select" id="" class="form-control">
                      <option value="kseb">K.S.E.B</option>
                      <option value="bsnl">B.S.N.L</option>
                      <option value="photostat">Photostat</option>
                      <option value="kwa">K.W.A</option>
                      <option value="insurance">Insurance</option>
                  </select>
                </div>
                <div class="col-md-4">
                    <input type="submit" value="proceed" name="submit" class="form-control btn btn-primary mt-3 btn-proceed d-inline">
                </div>                
                <div class="col-md-4">
                    <input type="submit" value="CLEAR" name="clear" class="form-control btn btn-danger mt-3 btn-proceed d-inline">
                </div>
            </div>
       
    </div>
        
           <ul class="side-bar">
            <li>
                <a href="#" class="sidebar-item clear-fix btn btn-sidebar" onclick="myfun()">Deposit to bank</a>

            </li>
            <li>
                <a href="/print_record.php" class="sidebar-item clear-fix btn btn-sidebar">Print Record</a>

            </li>

            <li>
                <a href="Print all records" class="sidebar-item clear-fix btn btn-sidebar">Print All Records</a>

            </li>

        </ul>
    <div class="footer">
        <a href="https://wss.kseb.in/selfservices/quickpay" class="btn2 m-c2" target="_blank">K.S.E.B</a>
        <a href="https://portal2.bsnl.in/myportal/cfa.do" class="btn2" target="_blank">B.S.N.L</a>
        <a href="https://epay.kwa.kerala.gov.in/" class="btn2" target="_blank">Water Authority</a>
        <a href="https://orientalinsurance.org.in/web/guest/renew?isSelected=renew&isRefresh=true" class="btn2" target="_blank">Oriental Insurance</a>
        <a href="https://www.makemytrip.com/flights/" class="btn2" target="_blank">Flight</a>
    </div>



    <script type="text/javascript" src="event.js"></script>
    <script type="text/javascript">
        function myfun(){
            var amount = prompt("enter the amount that you deposited");
            window.location.href = "http://localhost/accountApp/index.php?amount=" + amount;
        } 

    </script>
</body>

</html>
<?php
//function to get all data from a table 
function getFromDatabase($table_name){
    $tableName= $table_name;
//     echo"<br> table name is ".$tableName;   
    global $conn;
    $conn   = mysqli_connect('localhost','root','root','accounts');

    if(!$conn){ echo "getFromDatabaseEror connection error".mysqli_error($conn);}
    $query  =     "SELECT *FROM $tableName ORDER BY id desc";
    $result =      mysqli_query($conn,$query);
    $row = mysqli_fetch_assoc($result);
    if(!$row){echo "getFromDatabaseEror".mysqli_error($conn);}
    return $row;
}


//function to update income value Prev income + current Gross 

function updateIncome(){
    global $b_income,$b_gross,$conn,$date; 
    $b_income = $b_income + $b_gross;
//    echo "bank balance is <br>".$b_bankBalance;echo "bill amount is: <br>".$b_amount;

    //add new balance to DB
    $query = "INSERT INTO income(total_income,rec_date) VALUES('$b_income','$date')";
    $re = mysqli_query($conn,$query);
}


//deduct bill amount from the Bank account balance 

function deductBill(){
    global $b_bankBalance,$b_amount,$conn; 
    $b_bankBalance = $b_bankBalance - $b_amount;
//    echo "bank balance is <br>".$b_bankBalance;echo "bill amount is: <br>".$b_amount;
    $date = date('d-m-Y');
    //add new balance to DB
    $query = "INSERT INTO bank(bank_balance,rec_date) VALUES('$b_bankBalance','$date')";
    $re = mysqli_query($conn,$query);
}

function makeRecord(){
    global $b_gross,$conn,$b_amount,$b_charge,$b_tenderCash,$b_balance,$b_income,$b_bankBalance,$b_type,$date;
    echo "b_select value is .".$b_type."<br> date is:".$date    ;
    $query = "INSERT INTO records(gross,amount,charge,tendercash,balance,income,bankbalance,type,date) VALUES('$b_gross','$b_amount','$b_charge','$b_tenderCash','$b_balance','$b_income','$b_bankBalance','$b_type','$date')";
    $re     = mysqli_query($conn,$query);
    
}




//function to update the top values 
function updateTop(){
global $b_income,$b_bankBalance;
                                                    ?>
    <script type="text/javascript">
        document.getElementById("totalIncomeTop").innerHTML = '<?php echo "".$b_income; ?>';
        document.getElementById("totalBankBalanceTop").innerHTML = '<?php echo "".$b_bankBalance; ?>';
    </script>
    <?php
}

function clearAll(){
    
    global $b_gross,$b_amount,$b_charge,$b_tenderCash,$b_balance,$b_income,$b_bankBalance;

    // echo "asasd<br>".$b_gross.$b_amount.$b_income.$b_charge.$b_tenderCash.$b_balance.$b_bankBalance;
        ?>
        <!-- make form values not disappear after submitting-->
        <script type="text/javascript">
            document.getElementById("bGross").value = "";
            document.getElementById("bAmount").value = "";
            document.getElementById("bCharge").value = "";
            document.getElementById("bTenderCash").value = "";
            document.getElementById("bBalance").value = "";
            document.getElementById("totalIncomeTop").innerHTML = "";
            document.getElementById("totalBankBalanceTop").innerHTML = "";

        </script>
        <?php
}

function dynUpdate(){
    
    global $b_gross,$b_amount,$b_charge,$b_tenderCash,$b_balance,$b_income,$b_bankBalance;

    // echo "asasd<br>".$b_gross.$b_amount.$b_income.$b_charge.$b_tenderCash.$b_balance.$b_bankBalance;
        ?>
        <!-- make form values not disappear after submitting-->
        <script type="text/javascript">
            document.getElementById("bGross").value = "<?php echo $b_gross; ?>";
            document.getElementById("bAmount").value = "<?php echo $b_amount; ?>";
            document.getElementById("bCharge").value = "<?php echo $b_charge; ?>";
            document.getElementById("bTenderCash").value = "<?php echo $b_tenderCash; ?>";
            document.getElementById("bBalance").value = "<?php echo $b_balance; ?>";
            document.getElementById("totalIncomeTop").innerHTML = "<?php echo 'Total Income: '.$b_income; ?>";
            document.getElementById("totalBankBalanceTop").innerHTML = "<?php echo 'Current Account Balance: '.$b_bankBalance; ?>";

        </script>
        <?php
}
      

if(isset($_GET["amount"])){
    global $conn,$date;
    $_SESSION['amount_prompt'] = $_GET['amount'];
//    echo " hello the amount is".$_GET['amount'];
    $amount = $_GET['amount'];
    //decrease income 
    $current_amount   =  getFromDatabase('income');
    $amount = $current_amount['total_income'] - $amount;
    $query = "INSERT INTO income(total_income,rec_date) VALUES('$amount','$date')";
    $re    = mysqli_query($conn,$query);
    // Increase the bank value
    $amount = $_GET['amount'];
    $current_amount   =  getFromDatabase('bank');
    $amount = $current_amount['bank_balance'] + $amount;
    $query = "INSERT INTO bank(bank_balance,rec_date) VALUES('$amount','$date')";
    $re    = mysqli_query($conn,$query);
    
    //update the new values
    updateTop();
}
    
    
if(isset($_POST['clear'])){
    clearAll();
}
    
    

//if press proceed 
if(isset($_POST['submit'])){
    $conn   =      mysqli_connect('localhost','root','','accounts');  
    $date = date('d-m-Y');
    if (!$conn) {echo "errrrrrrrrrrr";}
    $b_type        = $_POST['b_select'];
//    echo "b_type is".$b_type; 
    $b_amount      = $_POST['b_amount'];
    $b_charge      = $_POST['b_charge'];
    $b_tenderCash  = $_POST['b_tenderCash'];
    $b_income      = "";
    $b_gross       = $b_amount + $b_charge;
    $b_balance     = $b_tenderCash - $b_gross;
    $b_income      = getFromDatabase('income');
    $b_income      = $b_income['total_income'];
    $b_bankBalance = getFromDatabase('bank');
    $b_bankBalance = $b_bankBalance['bank_balance'];
    dynUpdate();


    if( $b_type == "photostat" ){
        //then calculate the new  income amount
        updateIncome();
        //then display the newly generated values 
        updateTop();
    }else{
        //reduce bill from account
        deductBill();
        updateIncome();
        //then display the newly generated values 
        updateTop();
    }
    makeRecord();
}else{
    //show the top values even if form not submitted
    $b_income      = getFromDatabase('income');
    $b_income      = $b_income['total_income'];
    $b_bankBalance = getFromDatabase('bank');
    $b_bankBalance = $b_bankBalance['bank_balance'];  
    // echo "bank balance is <br>".$b_bankBalance;
    // echo "income is <br>".$b_income;


      updateTop();


}
?>
