<?php 
    include("config.php");
    include("others.php");
    session_start();
    $con = mysqli_connect('localhost', 'root', '');
    mysqli_select_db($con, 'budget_management');
    if(isset($_POST['form_data'])) :
        $user_title = $db->real_escape_string($_POST['title']);
        $user_bps_date = $db->real_escape_string($_POST['bps_date']);
        $user_invoice_date = $db->real_escape_string($_POST['invoice_date']);
        $user_invoice_amount = $db->real_escape_string($_POST['invoice_amount']);
        $user_approval_amount = $db->real_escape_string($_POST['approval_amount']);
        $user_balance_amount = $db->real_escape_string($_POST['balance_amount']);
        $user_country = $db->real_escape_string($_POST['country']);
        echo $user_title;
        echo $user_bps_date;
        echo $user_invoice_date;
        echo $user_invoice_amount;
        echo $user_approval_amount;
        echo $user_balance_amount;
        echo $user_country;
        echo $_POST['data_id'];
        $data_id = ($_POST['data_id']!="") ? $_POST['data_id'] : '';
        if($data_id != "") :
            $sql = "UPDATE all_data SET title= '$user_title',bps_date='$user_bps_date',invoice_date='$user_invoice_date',invoice_amount='$user_invoice_amount',approval_amount='$user_approval_amount',balance_amount='$user_balance_amount' WHERE data_id='$data_id'";
        	$con = mysqli_connect('localhost', 'root', '');
            mysqli_select_db($con, 'budget_management');
            if ($con->query($sql) === TRUE)
            {
                echo "yes";
            }else{echo "no";}
        	$msg = "Successfully Updated Your Record";
        else:
            echo "helllo";
            $sql ="INSERT INTO `all_data` (`category_id`, `title`, `bps_date`, `invoice_date`, `invoice_amount`, `approval_amount`, `balance_amount`,`country`) VALUES (5, '$user_title', '$user_bps_date', '$user_invoice_date', '$user_invoice_amount', '$user_approval_amount', '$user_balance_amount','$user_country')";
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
        echo "<script>window.location = 'others.php'</script>";
        //header("Location:all_data.php");
    endif;

    if(isset($_POST['ct_data_id'])) :
        $data_id = ($_POST['ct_data_id']!="") ? $_POST['ct_data_id'] : '';
        if($data_id!="") :
            $query = "DELETE FROM all_data WHERE data_id =$data_id";
            $sql = $db->query($query);
            echo 1;
        else :
            echo 0;
        endif;
    else :
        echo 0;
    endif;
