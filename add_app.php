<?php
include("config.php");

session_start();
$con = mysqli_connect('localhost', 'root', '');
mysqli_select_db($con, 'c-dot');
if (isset($_POST['form_data'])) :
    $user_approval_date = $db->real_escape_string($_POST['approval_date']);
    $user_approval_amount = $db->real_escape_string($_POST['approval_amount']);
    $user_category_id = $db->real_escape_string($_POST['category_id']);
    $user_number = $db->real_escape_string($_POST['number']);
    //include("invoice_patent.php?");
    // echo $user_title;
    // echo $user_bps_date;
    // echo $user_approval_date;
    // echo $user_approval_amount;
    // echo $user_approval_amount;
    // echo $user_balance_amount;
    // echo $user_country;
    // echo $_POST['data_id'];
    //$data_id = ($_POST['data_id']!="") ? $_POST['data_id'] : '';

    $sql1 = "select * from datas where category_id=$user_category_id and number='$user_number'";
    $res1 = mysqli_query($con, $sql1);
    $row1 = mysqli_fetch_array($res1);
    $app = $row1['approval_amount'];
    $bal = $row1['balance_amount'];



    $new_app = $app + $user_approval_amount;
    $new_bal = $bal + $user_approval_amount;
    $sql1 = "update datas set balance_amount='$new_bal',approval_amount='$new_app' where category_id=$user_category_id and number='$user_number'";
    $res1 = mysqli_query($con, $sql1);

    $sql = "INSERT INTO `approval` (`category_id`,`number`, `approval_date`,`approval_amount`) VALUES ('$user_category_id','$user_number' , '$user_approval_date', '$user_approval_amount')";
    $con = mysqli_connect('localhost', 'root', '');
    mysqli_select_db($con, 'c-dot');
    if ($con->query($sql) === TRUE) {
        echo "true";
    } else {
        echo "invaldata_id query";
    }
    $msg = "Successfully Inserted Your Record";
endif;
$_SESSION['flash_msg'] = $msg;
//echo "<script>alert('Product is already added in the cart..!')</script>";
echo "<script>window.location = 'approval_patent.php?no=$user_number&cid=$user_category_id'</script>";
//header("Location:invoice.php");


if (isset($_POST['ct_data_id'])) :
    $data_id = ($_POST['ct_data_id'] != "") ? $_POST['ct_data_id'] : '';
    $number = $_POST['number'];
    if ($data_id != "") :
        $sql1 = "select * from datas where category_id=$user_category_id and number='$number'";
        $res1 = mysqli_query($con, $sql1);
        $row1 = mysqli_fetch_array($res1);
        $bal = $row1['balance_amount'];
        $apr = $row1['approval_amount'];
        
        $sql2 = "select * from approval where category_id=$user_category_id and number='$number' and approval_id='$data_id'";
        $res2 = mysqli_query($con, $sql2);
        $row2 = mysqli_fetch_array($res2);
        $old_apr = $row2['approval_amount'];
        
        $new_bal = $bal-$old_apr;
        $new_apr = $apr - $old_apr;
        echo '<script> console.log("hello") </script>';
        echo '<script> console.log($old_inv , $new_bal);</script>';
            $q = "update datas set balance_amount='$new_bal' where number='$number' and category_id=$user_category_id";
            $q1 = "update datas set approval_amount='$new_apr' where number='$number' and category_id=$user_category_id";
        
            $res = mysqli_query($con,$q);
            $res1 = mysqli_query($con,$q1);
        $query = "DELETE FROM approval WHERE approval_id=$data_id";
        $sql = $db->query($query);
        echo 1;
    else :
        echo 0;
    endif;
else :
    echo 0;
endif;

