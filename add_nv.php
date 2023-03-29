<?php 
    include("config.php");
    include("patent.php");
    session_start();
    $con = mysqli_connect('localhost', 'root', '');
    mysqli_select_db($con, 'c-dot');
    if(isset($_POST['form_data'])) :
        $user_invoice_id = $db->real_escape_string($_POST['invoice_id']);
        $user_invoice_date = $db->real_escape_string($_POST['invoice_date']);
        $user_invoice_amount = $db->real_escape_string($_POST['invoice_amount']);
        $user_category_id = $db->real_escape_string($_POST['category_id']);
        $user_number = $db->real_escape_string($_POST['number']);
        // echo $user_title;
        // echo $user_bps_date;
        // echo $user_invoice_date;
        // echo $user_invoice_amount;
        // echo $user_approval_amount;
        // echo $user_balance_amount;
        // echo $user_country;
        // echo $_POST['data_id'];
        //$data_id = ($_POST['data_id']!="") ? $_POST['data_id'] : '';
        if($invoice_id != "") :
            $sql = "UPDATE invoice SET invoice_id='$user_invoice_id',invoice_date='$user_invoice_date',invoice_amount='$user_invoice_amount' WHERE invoice_id='$invoice_id'";
        	$con = mysqli_connect('localhost', 'root', '');
            mysqli_select_db($con, 'budget_management');
            if ($con->query($sql) === TRUE)
            {
                echo "yes";
            }else{echo "no";}
        	$msg = "Successfully Updated Your Record";
        else:
            echo "helllo";
            $sql ="INSERT INTO `invoice` (`category_id`,`number`,`invoice_id`, `invoice_date`,`invoice_amount`) VALUES (1,'$user_number' , '$user_invoice_id', '$user_invoice_date', '$user_invoice_amount')";
        	$con = mysqli_connect('localhost', 'root', '');
            mysqli_select_db($con, 'budget_management');
            if ($con->query($sql) === TRUE)
            {
                echo "true";
            }else{ echo "invaldata_id query";}
            $msg = "Successfully Inserted Your Record";        	
        endif;
        $_SESSION['flash_msg'] = $msg;
        //echo "<script>alert('Product is already added in the cart..!')</script>";
        echo "<script>window.location = 'invoice_patent.php'</script>";
        //header("Location:invoice.php");
    endif;

    if(isset($_POST['ct_data_id'])) :
        $data_id = ($_POST['ct_data_id']!="") ? $_POST['ct_data_id'] : '';
        if($data_id!="") :
            $query = "DELETE FROM invoice WHERE data_id =$data_id";
            $sql = $db->query($query);
            echo 1;
        else :
            echo 0;
        endif;
    else :
        echo 0;
    endif;
