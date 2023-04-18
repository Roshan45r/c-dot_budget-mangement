<?php 
    include("config.php");
    
    session_start();
    $con = mysqli_connect('localhost', 'root', '');
    mysqli_select_db($con, 'c-dot');
    if(isset($_POST['form_data'])) :
        $user_invoice_id = $db->real_escape_string($_POST['invoice_id']);
        $user_invoice_date = $db->real_escape_string($_POST['invoice_date']);
        $user_bps_date = $db->real_escape_string($_POST['bps_date']);
        $user_invoice_amount = $db->real_escape_string($_POST['invoice_amount']);
        $user_category_id = $db->real_escape_string($_POST['category_id']);
        $user_number = $db->real_escape_string($_POST['number']);
        //include("invoice_patent.php?");
        // echo $user_title;
        // echo $user_bps_date;
        // echo $user_invoice_date;
        // echo $user_invoice_amount;
        // echo $user_approval_amount;
        // echo $user_balance_amount;
        // echo $user_country;
        // echo $_POST['data_id'];
        //$data_id = ($_POST['data_id']!="") ? $_POST['data_id'] : '';
        
        $sql = "select * from invoice where invoice_id='$user_invoice_id' and number='$user_number'";
        $con = mysqli_connect('localhost', 'root', '');
        mysqli_select_db($con, 'c-dot');
        $res = mysqli_query($con, $sql);


        $sql1 = "select * from datas where category_id='$user_category_id' and number='$user_number'";
        $res1 = mysqli_query($con, $sql1);
        $row1 = mysqli_fetch_array($res1);
        $bal = $row1['balance_amount'];

        if(mysqli_num_rows($res)>0):

            $sql1 = "select * from invoice where category_id='$user_category_id' and number='$user_number' and invoice_id='$user_invoice_id'";
        $res1 = mysqli_query($con, $sql1);
        $row1 = mysqli_fetch_array($res1);
        $old_inv = $row1['invoice_amount'];

        $new_bal = $bal + $old_inv - $user_invoice_amount;
            $sql1 = "update datas set balance_amount='$new_bal' where category_id='$user_category_id' and number='$user_number'";
            $res1 = mysqli_query($con, $sql1);
            
            $sql = "UPDATE invoice SET invoice_id='$user_invoice_id',bps_date = '$user_bps_date',invoice_date='$user_invoice_date',invoice_amount='$user_invoice_amount' WHERE invoice_id='$user_invoice_id'";
        	$con = mysqli_connect('localhost', 'root', '');
            mysqli_select_db($con, 'c-dot');
            if ($con->query($sql) === TRUE)
            {
                echo "yes";
            }else{echo "no";}
        	$msg = "Successfully Updated Your Record";
            echo $msg;
        else:
            echo "helllo";
            $new_bal = $bal - $user_invoice_amount;
            $sql1 = "update datas set balance_amount='$new_bal' where category_id='$user_category_id' and number='$user_number'";
            $res1 = mysqli_query($con, $sql1);

            $sql ="INSERT INTO `invoice` (`category_id`,`number`,`invoice_id`, `invoice_date`,`bps_date`,`invoice_amount`) VALUES ($user_category_id,'$user_number' , '$user_invoice_id', '$user_invoice_date','$user_bps_date', '$user_invoice_amount')";
        	$con = mysqli_connect('localhost', 'root', '');
            mysqli_select_db($con, 'c-dot');
            if ($con->query($sql) === TRUE)
            {
                echo "true";
            }else{ echo "invaldata_id query";}
            $msg = "Successfully Inserted Your Record";        	
        endif;
        $_SESSION['flash_msg'] = $msg;
        //echo "<script>alert('Product is already added in the cart..!')</script>";
        echo "<script>window.location = 'invoice_patent.php?no=$user_number&cid=$user_category_id'</script>";
        //header("Location:invoice.php");
    endif;

    if(isset($_POST['ct_data_id'])) :
        $data_id = ($_POST['ct_data_id']!="") ? $_POST['ct_data_id'] : '';
        $number = $_POST['number'];
        if($data_id!="") :
            $sql1 = "select * from datas where category_id='$user_category_id' and number='$number'";
        $res1 = mysqli_query($con, $sql1);
        $row1 = mysqli_fetch_array($res1);
        $bal = $row1['balance_amount'];

            $sql1 = "select * from invoice where category_id='$user_category_id' and number='$number' and invoice_id='$data_id'";
        $res1 = mysqli_query($con, $sql1);
        $row1 = mysqli_fetch_array($res1);
        $old_inv = $row1['invoice_amount'];

        $new_bal = $bal+$old_inv;
        echo '<script> console.log("hello") </script>';
        echo '<script> console.log($old_inv , $new_bal);</script>';
            $q = "update datas set balance_amount='$new_bal' where number='$number' and category_id='$user_category_id'";

            $res = mysqli_query($con,$q);
            $query = "DELETE FROM invoice WHERE invoice_id=$data_id";

            $sql = $db->query($query);
            echo 1;
        else :
            echo 0;
        endif;
    else :
        echo 0;
    endif;
