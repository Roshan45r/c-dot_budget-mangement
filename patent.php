<?php
session_start();



$cid = $_GET['cid'];

if(empty($cid)){

    echo "404 ERROR NO CATEGORY";
}

$cid = (int)$cid;

if($cid > 0 && $cid < 5){
    if ($cid==1){
        $category = "Patent";
    }
    if ($cid==2){
        $category = "TradeMark";
    }
    if ($cid==3){
        $category = "Design";
    }
    if ($cid==4){
        $category = "Copyright";
    }
include('export_data.php');
$con = mysqli_connect('localhost', 'root', '');
mysqli_select_db($con, 'c-dot');
$sort = 0;
$ord = "title";

if (!empty($_GET['sort'])) {
    // Do something.

    $sort = $_GET['sort'];
}
if ($sort == 2) {
    $ord = "bps_date desc";
}
if ($sort == 3) {
    $ord = "number desc";
}
$q = "select * from datas where category_id='$cid' order by $ord";
if (!empty($_GET['search'])) {
    // Do something.
    $search = $_GET['search'];
    //echo $search;
    $q = "select * from datas where category_id='$cid' and (number like '$search%' or title like '$search%') order by $ord";
}
$res = mysqli_query($con, $q);
//$row = mysqli_fetch_array($res);
//echo $row['title'];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $category?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- jQuery library -->
    <!-- Latest compiled JavaScript -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
    <?php include('navbar.php'); ?>
    <div class="row">

        <div class="col-md-4" style="margin-left:250px;">
            <h2><a href="options.php"><span class="glyphicon glyphicon-chevron-left"></span></a><?php echo $category?></h2>
        </div>
    </div>
    <div class="row">

        <div class="col-md-4" style="margin-left:250px;MARGIN-BOTTOM:5PX;">
            <?php $apage = array('id' => '', 'title' => '','category_id'=>$cid); ?>
            <script>
                var page_0 = <?php echo json_encode($apage) ?>
            </script>
            <div style="display: flex;align-items: center;margin-left:10px;width:max-content;">
                <a data="page_0" class="model_form btn btn-sm btn-danger" href="#"><span class="glyphicon glyphicon-plus"></span> Add new <?php echo $category?></a>
                <style>
                    /* Style The Dropdown Button */
                    .dropbtn {
                        background-color: #5BC0DE;
                        color: white;
                        margin: 10px;
                        padding: 6px 8px;
                        font-size: 12px;
                        border: none;
                        cursor: pointer;
                        border-radius: 3px;
                    }

                    /* The container <div> - needed to position the dropdown content */
                    .dropdown {
                        position: relative;
                        display: inline-block;
                    }

                    /* Dropdown Content (Hidden by Default) */
                    .dropdown-content {
                        display: none;
                        position: absolute;
                        background-color: #f9f9f9;
                        min-width: 160px;
                        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
                        z-index: 1;
                    }

                    /* Links inside the dropdown */
                    .dropdown-content a {
                        color: black;
                        padding: 12px 16px;
                        text-decoration: none;
                        display: block;
                    }

                    /* Change color of dropdown links on hover */
                    .dropdown-content a:hover {
                        background-color: #f1f1f1
                    }

                    /* Show the dropdown menu on hover */
                    .dropdown:hover .dropdown-content {
                        display: block;
                    }

                    /* Change the background color of the dropdown button when the dropdown content is shown */
                    .dropdown:hover .dropbtn {
                        background-color: #337AB7;
                    }
                </style>

                <div class="dropdown">
                    <button class="dropbtn">Sort By<span class="caret"></span></button>
                    <div class="dropdown-content">
                        <a href="?sort=1&cid=<?php echo $cid ?>">TITLE</a>
                        <a href="?sort=3&cid=<?php echo $cid ?>"><?php echo $category?>-id</a>
                    </div>
                </div>

                <div style="margin-right: 10px;">
                    <div>
                        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                            <input type="hidden" value="All <?php echo $category?>" name="number" id="number">
                            <input type="hidden" value="<?php echo $q ?>" name="query" id="query">

                            <button type="submit" id="export_data" name='export_data' value="Export to excel" class="btn btn-success" style="font-size:12px;">Export<i class="fa fa-download" style="margin-left:5px;"></i></button>
                        </form>
                    </div>
                </div>
                <div class="search-container">
                    <form action="patent.php" method="GET">
                        <input type="text" placeholder="Search by ID,TITLE" name="search" id="search">
                        <input type="hidden" name="cid" value="<?php echo $cid ?>">
                        <button type="submit"><span class="glyphicon glyphicon-search"></span></button>
                    </form>
                </div>


            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <table class="table table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th><?php echo $category?> ID</th>
                        <th><?php echo $category?> TITLE</th>
                        <th>APPROVAL AMOUNT</th>
                        <th>BALANCE AMOUNT</th>
                        <th>COUNTRY</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($res)) : $i = 1; ?>
                        <?php while ($row = mysqli_fetch_array($res)) { ?>

                            <tr class="<?= $row['number'] ?>_del">
                                <td><?= $row['number']; ?></td>
                                <!-- <td><?= $row['number']; ?></td>         -->
                                <td><?= $row['title']; ?></td>
                                <!-- <td><?= $row['invoice_amount']; ?></td> -->
                                <td><?= $row['approval_amount']; ?></td>
                                <td><?= $row['balance_amount']; ?></td>
                                <td><?= $row['country']; ?></td>
                                <script>
                                    var page_<?php echo $row['number'] ?> = <?php echo json_encode($row); ?>
                                </script>
                                <td>
                                    <form method="GET" action="invoice_patent.php">
                                        <input type="hidden" name="number_p" id="number_p" value="<?php echo $row['number']; ?>">


                                        <a href="invoice_patent.php?no=<?php echo $row['number']; ?>&cid=<?php echo $cid ?>" title="View Invoices for <?php echo $row['number']; ?>" class="tip view_inv btn btn-info btn-sm "><span class="glyphicon glyphicon-list-alt "></span></a>



                                        <a data="<?php echo 'page_' . $row['number'] ?>" class="model_form btn btn-info btn-sm" href="#">
                                            <span class="glyphicon glyphicon-pencil"></span></a>
                                        <a data="<?php echo  $row['number'] ?>" title="Delete <?php echo $row['number']; ?>" class="tip delete_check btn btn-info btn-sm "><span class="glyphicon glyphicon-remove"></span> </a>

                                        <a href="approval_patent.php?no=<?php echo $row['number']; ?>&cid=<?php echo $cid; ?>" data="<?php echo  $row['number'] ?>" title="View <?php echo $row['number']; ?>" class="tip view_pat btn btn-info btn-sm "><span class="glyphicon glyphicon-eye-open"></span> </a>

                                    </form>
                                </td>
                            </tr>
                        <?php $i++;
                        } ?>
                    <?php else : echo '<tr><td colspan="8"><div align="center">-------No record found -----</div></td></tr>'; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            <?php
            if (isset($_SESSION['flash_msg'])) :
                $message = $_SESSION['flash_msg'];
                echo $error = '<div class="alert alert-success" role="alert">
               <span class="glyphicon glyphicon-envelope"></span> <strong>' . $message . '</strong> </div>';
                unset($_SESSION['flash_msg']);
            endif;

        }
        else{
            echo "404 ERROR CATEGORY INVALID";
        }
            ?>

        </div>
        <div class="col-md-2">

        </div>
    </div>



    <!-- End -->
</body>

</html>
<script src="js/script.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '.model_form', function() {
            $('#form_modal').modal({
                keyboard: false,
                show: true,
                backdrop: 'static'
            });
            var data = eval($(this).attr('data'));
            console.log(data.number);
            $('#number-id').val(data.number);
            $('#title').val(data.title);
            //$('#number').val(data.number);
            $('#category_id').val(data.category_id);
            //$('#approval_amount').val(data.approval_amount);
            $('#country').val(data.country);
            if (data.id != ""){
                $('#pop_title').html('Edit');
                $('#pid').val(data.number);}
            else
                $('#pop_title').html('Add');

        });
        $(document).on('click', '.delete_check', function() {
            if (confirm("Are you sure to delete data")) {
                var current_element = $(this);
                console.log($(current_element).attr('data'));
                url = "add_patent.php";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        ct_number: $(current_element).attr('data')
                    },
                    success: function(data) {
                        //location.reload();
                        $('.' + $(current_element).attr('data') + '_del').animate({
                            backgroundColor: "#003"
                        }, "slow").animate({
                            opacity: "hide"
                        }, "slow");
                    }
                });
            }
        });
    });
</script>


<!-- Form modal -->
<div id="form_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-bps_dateden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-paragraph-justify2"></i><span id="pop_title">Add</span> <?php echo $category?>
                    information</h4>
            </div>
            <!-- Form inside modal -->
            <form method="post" action="add_patent.php" id="cat_form">
                <input type="hidden" name="category_id" id="category_id" value="<?php echo $cid; ?>">
                <input type="hidden" name="pid" id="pid" >
                <div class="modal-body with-padding">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>title :</label>
                                <input type="text" name="title" id="title" class="form-control required">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label><?php echo $category?> id :</label>
                                <input type="text" name="number" id="number-id" class="form-control required">
                            </div>
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>invoice_amount :</label>
                                <input type="text" name="invoice_amount" id="invoice_amount"
                                    class="form-control required">
                            </div>
                        </div>
                    </div> -->
                    <!-- <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>approval_amount :</label>
                                <input type="text" name="approval_amount" id="approval_amount" class="form-control required">
                            </div>
                        </div>
                    </div> -->
                    <!-- <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>balance_amount :</label>
                                <input type="text" name="balance_amount" id="balance_amount" class="form-control required">
                            </div>
                        </div>
                    </div> -->
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>country :</label>
                                <input type="text" name="country" id="country" class="form-control required">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                    <span id="add">
                        <button type="submit" name="form_data" class="btn btn-primary">Submit</button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /form modalssssss -->