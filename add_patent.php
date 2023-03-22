<?php 
    include("config.php");
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
        echo $user_title;
        echo $user_bps_date;
        echo $user_invoice_date;
        echo $user_invoice_amount;
        echo $user_approval_amount;
        echo $user_balance_amount;
        echo $_POST['id'];
        $id = ($_POST['id']!="") ? $_POST['id'] : '';
        if($id!="") :
            $sql = "UPDATE all_data SET title= '$user_title',bps_date='$user_bps_date',invoice_date='$user_invoice_date',invoice_amount='$user_invoice_amount',approval_amount='$user_approval_amount',balance_amount='$user_balance_amount' WHERE id='$id'";
        	$con = mysqli_connect('localhost', 'root', '');
            mysqli_select_db($con, 'budget_management');
            if ($con->query($sql) === TRUE)
            {
                echo "yes";
            }else{echo "no";}
        	$msg = "Successfully Updated Your Record";
        else:
            echo "helllo";
            $sql ="INSERT INTO `all_data` (`id`, `title`, `bps_date`, `invoice_date`, `invoice_amount`, `approval_amount`, `balance_amount`) VALUES (NULL, '$user_title', '$user_bps_date', '$user_invoice_date', '$user_invoice_amount', '$user_approval_amount', '$user_balance_amount')";
        	$con = mysqli_connect('localhost', 'root', '');
            mysqli_select_db($con, 'budget_management');
            if ($con->query($sql) === TRUE)
            {
                echo "true";
            }else{ echo "invalid query";}
            $msg = "Successfully Inserted Your Record";        	
        endif;
        $_SESSION['flash_msg'] = $msg;
        //echo "<script>alert('Product is already added in the cart..!')</script>";
        echo "<script>window.location = 'all_data.php'</script>";
        //header("Location:all_data.php");
    endif;

    if(isset($_POST['ct_id'])) :
        $id = ($_POST['ct_id']!="") ? $_POST['ct_id'] : '';
        if($id!="") :
            $query = "DELETE FROM all_data WHERE id =$id";
            $sql = $db->query($query);
            echo 1;
        else :
            echo 0;
        endif;
    else :
        echo 0;
    endif;
