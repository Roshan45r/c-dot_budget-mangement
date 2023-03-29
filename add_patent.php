<?php 

    include("config.php");
    include("patent.php");
    session_start();
    $con = mysqli_connect('localhost', 'root', '');
    mysqli_select_db($con, 'c-dot');
    if(isset($_POST['form_data'])) {
        $user_title = $db->real_escape_string($_POST['title']);
        $user_bps_date = $db->real_escape_string($_POST['bps_date']);
        $user_number = $db->real_escape_string($_POST['number']);
        $user_approval_amount = $db->real_escape_string($_POST['approval_amount']);
        $user_country = $db->real_escape_string($_POST['country']);
        // echo $user_title;
        // echo $user_bps_date;
        // echo $user_approval_amount;
        // echo $user_balance_amount;
        // echo $user_country;
        // echo $_POST['number'];
        // $number = ($_POST['number']!="") ? $_POST['number'] : '';
        echo $user_number;
        $sql = "select * from datas where number='$user_number' and category_id = 1";
        	$con = mysqli_connect('localhost', 'root', '');
            mysqli_select_db($con, 'c-dot');
            $res = mysqli_query($con, $sql);
            if ($con->query($sql) == TRUE)
            {
                $row =  mysqli_fetch_array($res);
                $app = $row['approval_amount'];
                $bal = $row['balance_amount'];
                $new_bal  = $bal + $user_approval_amount - $app;
                $sql = "UPDATE datas SET title= '$user_title',bps_date='$user_bps_date',approval_amount='$user_approval_amount',balance_amount='$new_bal',country='$user_country' WHERE number='$user_number' and category_id=1";
                $con = mysqli_connect('localhost', 'root', '');
                mysqli_select_db($con, 'c-dot');
                $con->query($sql);
                // if ($con->query($sql) === TRUE)
                // {
                //     echo "yes";
                // }else{echo "no";}
                $msg = "Successfully Updated Your Record";   
            }
        
        else{
            echo "helllo";
            $sql ="INSERT INTO `datas` (`category_id`, `title`, `bps_date`, `approval_amount`, `balance_amount`,`country`,`number`) VALUES (1, '$user_title', '$user_bps_date', '$user_approval_amount', '$user_approval_amount','$user_country','$user_number')";
        	$con = mysqli_connect('localhost', 'root', '');
            mysqli_select_db($con, 'c-dot');
            if ($con->query($sql) === TRUE)
            {
                echo "true";
            }else{ echo "invalnumber query";}
            $msg = "Successfully Inserted Your Record";        	
        }
        $_SESSION['flash_msg'] = $msg;
        //echo "<script>alert('Product is already added in the cart..!')</script>";
        echo "<script>window.location = 'patent.php'</script>";
        //header("Location:datas.php");
        }
        else{    echo "hello";
    echo $_POST['ct_number'];
    if(isset($_POST['ct_number'])) :
        $number = ($_POST['ct_number']!="") ? $_POST['ct_number'] : '';
        if($number!="") :
            $query = "DELETE FROM datas WHERE number =$number";
            $sql = $db->query($query);
            echo 1;
        else :
            echo 0;
        endif;
    else :
        echo 0;
    endif;
}
