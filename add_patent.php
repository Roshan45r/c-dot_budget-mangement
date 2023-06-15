<?php 
    include("config.php");
    //include("patent.php");
    session_start();
    $con = mysqli_connect('localhost', 'root', '');
    mysqli_select_db($con, 'c-dot');
    if(isset($_POST['form_data'])) {
        
$cid = $db->real_escape_string($_POST['category_id']);
        $user_title = $db->real_escape_string($_POST['title']);
        $user_number = $db->real_escape_string($_POST['number']);
        $pid = $db->real_escape_string($_POST['pid']);
        // $user_approval_amount = $db->real_escape_string($_POST['approval_amount']);
        $user_country = $db->real_escape_string($_POST['country']);
        // echo $user_title;
        // echo $user_bps_date;
        // echo $user_approval_amount;
        // echo $user_balance_amount;
        // echo $user_country;
        // echo $_POST['number'];
        // $number = ($_POST['number']!="") ? $_POST['number'] : '';
        echo $user_number;
        $sql = "select * from datas where number='$pid' and category_id = 1";
        	$con = mysqli_connect('localhost', 'root', '');
            mysqli_select_db($con, 'c-dot');
            $res = mysqli_query($con, $sql);
            if (mysqli_num_rows($res)>0)
            {
                $row =  mysqli_fetch_array($res);
                $app = $row['approval_amount'];
                $bal = $row['balance_amount'];
                $new_bal  = $bal + $user_approval_amount - $app;
                $sql = "UPDATE datas SET title='$user_title',number='$user_number',balance_amount='$new_bal',country='$user_country' WHERE number='$pid' and category_id='$cid'";
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
            $sql ="INSERT INTO `datas` (`category_id`, `title`, `approval_amount`,`balance_amount`,`country`,`number`) VALUES ('$cid', '$user_title',0, 0, '$user_country','$user_number')";
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
    echo "<script>window.location = 'patent.php?cid=$cid'</script>";
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
