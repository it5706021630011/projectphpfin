<?php
    session_start();
    include("connect.php");
    if(isset($_GET["id"])){
      $sql_sel_pro = "SELECT * FROM product JOIN product_type ON product.pro_type_id = product_type.pro_type_id JOIN product_unit ON product.pro_unit_id = product_unit.pro_unit_id AND pro_id = '".$_GET["id"]."'";
      $query_sel_pro = mysqli_query($conn,$sql_sel_pro);
      $sel_pro = mysqli_fetch_array($query_sel_pro,MYSQLI_ASSOC);
    }
?>
<html>
<head>
<title>การจัดการสินค้า</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="plugins/select2/select2.min.css">

  <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="dist/css/styleFont.css"/>

  <script src="dist/js/app.min.js"></script>
  <script src="dist/js/demo.js"></script>

  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
  <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
  <script src="plugins/fastclick/fastclick.js"></script>
  <script src="plugins/select2/select2.full.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
  </style>
  <script>

    $(function () {

        $("#pro_table").DataTable({
            "oLanguage": {
                "sLengthMenu": 'แสดง _MENU_ รายการ ต่อหน้า',
                "sZeroRecords": 'ไม่ข้อมูลสินค้า',
                "sInfo": 'แสดง _START_ ถึง _END_ ของ _TOTAL_ รายการ',
                "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 รายการ",
                "sInfoFiltered": "(จากรายการทั้งหมด _MAX_ รายการ)",
                "sSearch": "ค้นหา :",
                "oPaginate": {
                    "sFirst":    "หน้าแรก",
                    "sPrevious": "ก่อนหน้า",
                    "sNext":     "ถัดไป",
                    "sLast":     "หน้าสุดท้าย"
                }
            },
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
  });
  </script>

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <?php include("aside.php");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        การจัดการข้อมูลสินค้า
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="#"></a>การจัดการข้อมูล</li>
        <li class="active">ดูข้อมูลสินค้า</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">ดูข้อมูลสินค้า</h3>
            </div>
            <div class="box-body">
              <form id="form-send" action="" method="post" enctype="multipart/form-data">
              <div class="form-group col-xs-12">
                  <label>รหัสสินค้า</label><br />
                  <?php echo "MCS-".sprintf("%04d",$sel_pro['pro_id']);?>
              </div>              
              <div class="form-group col-xs-6">
                  <label for="new_pro_name">ชื่อสินค้า</label><br />
                  <?php echo $sel_pro['pro_name'];?>
              </div>
              <div class="form-group col-md-12">
                  <label>รายละเอียดสินค้า</label><br />
                  <?php echo $sel_pro['pro_detail'];?>
              </div>
              <div class="form-group col-xs-4">
                  <label>ราคาสินค้า/หน่วย (บาท)</label><br />
                  <?php echo number_format($sel_pro['pro_price'],2);?>
              </div>
              <div class="form-group col-xs-4">
                  <label>จำนวน</label><br />
                  <?php echo $sel_pro['pro_amount'];?>
              </div>
              <div class="form-group col-xs-4">
                  <label>หน่วยของสินค้า</label><br />
                  <?php echo $sel_pro['pro_unit_name'];?>
              </div>
              <div class="form-group col-xs-4">
                  <label>ส่วนลด (%)</label><br />
                  <?php echo $sel_pro['pro_discount'];?>
              </div>
              <div class="form-group col-xs-4">
                  <label>รูปภาพ</label><br />
                  <?php echo $sel_pro['pro_picture'];?>
                  <div id="image_show">
                    <img src="<?php echo $sel_pro['pro_picture'];?>" alt="<?php echo $sel_pro['pro_name'];?>" width="270" height="360">
                  </div>
              </div>
              <div class="form-group col-md-12">
                  <label>หมายเหตุ</label><br />
                  <?php echo $sel_pro['pro_annotation'];?>
              </div>
            </form>
            </div>
          </div>
        </div>
        <div class="col-xs-12">
          <a href="javascript:location.href='product_page.php'" class="btn btn-primary"><i class="fa fa-arrow-circle-left"></i> ก่อนหน้า</a>
        </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
    </div>
</body>
</html>
