<?php
session_start();

include("export_data.php");
$con = mysqli_connect('localhost', 'root', '');
mysqli_select_db($con, 'c-dot');
$pat = $_GET['no'];
$cid = $_GET['cid'];
$sort = 0;
$ord = "approval_id";
if (!empty($_GET['sort'])) {
    // Do something.

    $sort = $_GET['sort'];
}
if ($sort == 2) {
    $ord = "approval_date desc";
}
//echo $inv;
$q = "select * from approval where category_id=$cid and number=$pat order by $ord";
$quer = $q;
$res = mysqli_query($con, $q);
$exp = mysqli_query($con, $q);
$developer_records = array();
while ($rows = mysqli_fetch_assoc($exp)) {
    $developer_records[] = $rows;
}
//$row = mysqli_fetch_array($res);
//echo $row['title'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Invoices</title>
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

            <h2><a href="patent.php?cid=<?php echo $cid ?>"><span class="glyphicon glyphicon-chevron-left"></span></a>APPROVALS - <?php echo $pat;?></h2>
        </div>
    </div>
    <div class="row">

        <div class="col-md-4" style="margin-left:250px;MARGIN-BOTTOM:5PX;">
            <?php $apage = array('id' => '', 'title' => ''); ?>
            <script>
                var page_0 = <?php echo json_encode($apage) ?>
            </script>
            <div class="row" style="display: flex;align-items: center;margin-left:10px;">
                <a data="page_0" class="model_form btn btn-sm btn-danger" href="#"><span class="glyphicon glyphicon-plus"></span> Add new Approval</a>
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
                        <a href="?no=<?php echo $pat ?>&cid=<?php echo $cid ?>&sort=1">APPROVAL ID</a>
                        <a href="?no=<?php echo $pat ?>&cid=<?php echo $cid ?>&sort=2">APPROVAL DATE</a>
                    </div>
                </div>
                <div class="col">
                    <div>
                        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>?no=<?php echo $pat ?>" method="post">
                            <input type="hidden" value="Patent ID = <?php echo $pat ?>" name="number" id="number">
                            <input type="hidden" value="<?php echo $quer ?>" name="query" id="query">

                            <button type="submit" id="export_data" name='export_data' value="Export to excel" class="btn btn-success" style="font-size:12px;">Export<i class="fa fa-download" style="margin-left:5px;"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8" id="inv-table">
            <table class="table table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>APPROVAL ID</th>
                        <th>APPROVAL DATE</th>
                        <th>APPROVAL AMOUNT</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($res)) : $i = 1; ?>
                        <?php while ($row = mysqli_fetch_array($res)) { ?>

                            <tr class="<?= $row['approval_id'] ?>_del">
                                <td><?= $row['approval_id']; ?></td>
                                <td><?= $row['approval_date']; ?></td>
                                <td><?= $row['approval_amount']; ?></td>
                                <script>
                                    var page_<?php echo $row['approval_id'] ?> = <?php echo json_encode($row); ?>
                                </script>
                                <td>
                                    <a data="<?php echo  $row['approval_id'] ?>" title="Delete <?php echo $row['approval_id']; ?>" class="tip delete_check btn btn-info btn-sm "><span class="glyphicon glyphicon-remove"></span> </a>
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
            ?>





        </div>
        <div class="col-md-2">

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
            console.log(data);
            $('#approval_id').val(data.approval_id);
            $('#approval_date').val(data.approval_date);
            $('#approval_amount').val(data.approval_amount);
            if (data.id != "")
                $('#pop_title').html('Edit');
            else
                $('#pop_title').html('Add');

        });
        $('#create_excel').click(function() {
            var excel_data = $('#inv-table').html();
            var page = "excel.php?data=" + excel_data;
            window.location = page;
        });

        $(document).on('click', '.delete_check', function() {
            if (confirm("Are you sure to delete data")) {
                var current_element = $(this);
                console.log($(current_element).attr('data'));
                url = "add_app.php";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        number: '<?php echo $pat; ?>',
                        ct_data_id: $(current_element).attr('data'),
                        category_id: "<?php echo  $cid?>"
                    },
                    success: function(data) {
                        location.reload();
                        $('.' + $(current_element).attr('data') + '_del').animate({
                            backgroundColor: "#003"
                        }, "slow").animate({
                            opacity: "bps_datee"
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
                <h4 class="modal-title"><i class="icon-paragraph-justify2"></i><span id="pop_title">Add</span> Invoices
                    information</h4>
            </div>
            <!-- Form inside modal -->
            <form method="post" action="add_app.php" id="cat_form">
                <input type="hidden" name="number" id="number" value="<?php echo $pat ?>">
                <input type="hidden" name="category_id" id="category_id" value="<?php echo $cid?>">
                <div class="modal-body with-padding">
                    <!-- <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>approval_id :</label>
                                <input type="text" name="approval_id" id="approval_id" class="form-control required">
                            </div>
                        </div>
                    </div> -->
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>approval_date :</label>
                                <input type="date" name="approval_date" id="approval_date" class="form-control required">
                            </div>
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>bps_date :</label>
                                <input type="date" name="bps_date" id="bps_date" class="form-control">
                            </div>
                        </div>
                    </div> -->
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>approval_amount :</label>
                                <input type="text" name="approval_amount" id="approval_amount" class="form-control required">
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
<!-- /form modal -->