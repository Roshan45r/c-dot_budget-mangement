<?php
session_start();
$con = mysqli_connect('localhost', 'root', '');
mysqli_select_db($con, 'c-dot');
$inv = $_POST['number_p'];
//echo $inv;
$q = "select * from invoice where category_id=1 and number=$inv";
$res = mysqli_query($con, $q);

//$row = mysqli_fetch_array($res);
//echo $row['title'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Invoices</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- jQuery library -->
    <!-- Latest compiled JavaScript -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
    <?php include('navbar.php');?>
    <div class="row">

        <div class="col-md-4" style="margin-left:250px;">
            <h2>INVOICES</h2>
        </div>
    </div>
    <div class="row">

        <div class="col-md-4" style="margin-left:250px;MARGIN-BOTTOM:5PX;">
            <?php $apage = array('id'=>'','title'=>'');?>
            <script>
            var page_0 = <?php echo json_encode($apage)?>
            </script>
            <h3><a data="page_0" class="model_form btn btn-sm btn-danger" href="#"><span
                        class="glyphicon glyphicon-plus"></span> Add new Invoices</a></h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <table class="table table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>INVOICE ID</th>
                        <th>INVOICE DATE</th>
                        <th>INVOICE AMOUNT</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($res))  : $i=1; ?>
                    <?php  while ($row = mysqli_fetch_array($res)) { ?>

                    <tr class="<?=$row['invoice_id']?>_del">
                        <td><?=$row['invoice_id'];?></td>
                        <td><?=$row['invoice_date'];?></td>
                        <td><?=$row['invoice_amount'];?></td>
                        <script>
                        var page_<?php echo $row['invoice_id'] ?> = <?php echo json_encode($row);?>
                        </script>
                        <td><a data="<?php echo 'page_'.$row['invoice_id'] ?>" class="model_form btn btn-info btn-sm" href="#">
                                <span class="glyphicon glyphicon-pencil"></span></a>
                            <a data="<?php echo  $row['invoice_id'] ?>" title="Delete <?php echo $row['invoice_id'];?>"
                                class="tip delete_check btn btn-info btn-sm "><span
                                    class="glyphicon glyphicon-remove"></span> </a>
                        </td>
                    </tr>
                    <?php $i++; } ?>
                    <?php else : echo '<tr><td colspan="8"><div align="center">-------No record found -----</div></td></tr>'; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            <?php
              if(isset($_SESSION['flash_msg'])) :  
               $message = $_SESSION['flash_msg'];
               echo $error= '<div class="alert alert-success" role="alert">
               <span class="glyphicon glyphicon-envelope"></span> <strong>'.$message.'</strong> </div>';
               unset($_SESSION['flash_msg']);
              endif;
          ?>


            <!-- Ads and more  -->
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- header_responsive_ads -->
            <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-9665679251236729"
                data-ad-slot="9239985429" data-ad-format="auto"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>


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
        console.log(data);
        $('#invoice_id').val(data.invoice_id);
        $('#invoice_date').val(data.invoice_date);
        $('#invoice_amount').val(data.invoice_amount);
        if (data.id != "")
            $('#pop_title').html('Edit');
        else
            $('#pop_title').html('Add');

    });
    $(document).on('click', '.delete_check', function() {
        if (confirm("Are you sure to delete data")) {
            var current_element = $(this);
            console.log($(current_element).attr('data'));
            url = "add_nv.php";
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    ct_invoice_id: $(current_element).attr('data')
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
            <form method="post" action="add_nv.php" id="cat_form">
                <input type="hidden" name="number" id="number" value="<?php echo $row['number']?>">
                <input type="hidden" name="category_id" id="category_id" value="<?php echo $row['category_id']?>">
                <div class="modal-body with-padding">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>invoice_id :</label>
                                <input type="text" name="invoice_id" id="invoice_id" class="form-control required">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>invoice_date :</label>
                                <input type="text" name="invoice_date" id="invoice_date" class="form-control required">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>invoice_amount :</label>
                                <input type="text" name="invoice_amount" id="invoice_amount"
                                    class="form-control required">
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