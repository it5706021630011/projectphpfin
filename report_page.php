<?php
    session_start();
	  include("connect.php");
?>
<html>
<head>
<title>รายงาน</title>
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
  <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">

  <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="dist/css/styleFont.css" />

  <script src="dist/js/app.min.js"></script>
  <script src="dist/js/demo.js"></script>

  <script src="plugins/jQueryUI/jquery.ui.core.js"></script>
  <script src="plugins/jQueryUI/jquery.ui.datepicker.js"></script>
  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
  <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
  <script src="plugins/fastclick/fastclick.js"></script>
  <script src="plugins/select2/select2.full.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
  <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
  <script src="plugins/datepicker/locales/bootstrap-datepicker.th.js" charset="UTF-8"></script>
  <!-- date-range-picker -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
  <script src="plugins/daterangepicker/daterangepicker.js"></script>

  <script>

  $(function () {
    $('#daterange-btn').daterangepicker(
        {
          ranges: {
            'วันนี้': [moment(), moment()],
            'เมื่อวาน': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            '7 วัน ก่อนหน้า': [moment().subtract(6, 'days'), moment()],
            '30 วันก่อนหน้า': [moment().subtract(29, 'days'), moment()],
            'เดือนนี้': [moment().startOf('month'), moment().endOf('month')],
          },
          locale: {
            applyLabel: 'Apply',
            cancelLabel: 'Cancel',
            customRangeLabel: 'กำหนดเอง',
            daysOfWeek: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ', 'ศ.', 'ส.'],
            monthNames: ['มกราคม', 'กุมภาพันธุ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
            language: 'th',
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment(),
        },

        function (start, end) {
          $('#daterange-btn span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
          $('#date_start').val(start.format('YYYY-MM-DD'));
          $('#date_end').val(end.format('YYYY-MM-DD'));
        }
    );

    $('#daterange-btn2').daterangepicker(
        {
          ranges: {
            'วันนี้': [moment(), moment()],
            'เมื่อวาน': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            '7 วัน ก่อนหน้า': [moment().subtract(6, 'days'), moment()],
            '30 วันก่อนหน้า': [moment().subtract(29, 'days'), moment()],
            'เดือนนี้': [moment().startOf('month'), moment().endOf('month')],
          },
          locale: {
            applyLabel: 'Apply',
            cancelLabel: 'Cancel',
            customRangeLabel: 'กำหนดเอง',
            daysOfWeek: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ', 'ศ.', 'ส.'],
            monthNames: ['มกราคม', 'กุมภาพันธุ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
            language: 'th',
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment(),
        },

        function (start, end) {
          $('#daterange-btn2 span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
          $('#date_start2').val(start.format('YYYY-MM-DD'));
          $('#date_end2').val(end.format('YYYY-MM-DD'));
        }
    );

    // $( "#datepicker" ).datepicker( $.datepicker.regional["th"] );   // บอกให้ใช้ Propertie ภาษาที่เรานิยามไว้
    // $( "#datepicker" ).datepicker({ dateFormat: 'dd/mm/yy', isBuddhist: true, defaultDate: toDay });                                 //Innit DatePicker ไปที่ Control ที่มี ID = datepicker
// $('#myModal1').modal('hide');
    //$('#myModal1').hide();

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
        การจัดการข้อมูลรายงาน
        <!--<small>advanced tables</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">การจัดการข้อมูล</a></li>
        <li class="active">รายงาน</li>
      </ol>
    </section>

    <!-- Main content -->
   <section class="content">
     <div class="col-xs-12">
      <div class="row">
        <div class="box">
          <div class="box-body">
            <div class="margin">
              <button class="btn btn-info" onclick="javascript:window.open('print_report_stock.php?id=1')"><i class="fa fa-print"></i> สินค้าคงคลัง</button>

              <button class="btn btn-info" data-toggle="modal" data-target="#myModal1"><i class="fa fa-print"></i> สรุปการขายสินค้า</button>

              <button class="btn btn-info" onclick="javascript:window.open('print_report_orderPoint.php?id=2')"><i class="fa fa-print"></i> สินค้าถึงจุดสั่งซื้อ</button>

              <button class="btn btn-info" data-toggle="modal" data-target="#myModal2"><i class="fa fa-print"></i> สรุปรายรับ-รายจ่าย</button>
            </div>
          </div>
        </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

    <form action="print_report_sale.php?id=1" method="post">
    <div class="modal fade" id="myModal1" role="dialog">
         <div class="modal-dialog">
             <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">รายงานสรุปการขายสินค้า</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label>เลือกระยะเวลาของรายงาน</label>
                    <div class="input-group">
                      <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                        <span>
                          <i class="fa fa-calendar"></i> ระยะเวลา
                        </span>
                        <i class="fa fa-caret-down"></i>
                      </button>
                    </div>
                  </div>
                  <input type="hidden" name="date_start" id="date_start">
                  <input type="hidden" name="date_end" id="date_end">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default pull-left" data-dismiss="modal">ปิด</button>
                    <button class="btn btn-success" type="submit" name="submit">พิมพ์</button>
                </div>
            </div>
        </div>
    </div>
    </form>

    <form action="print_report_income.php?id=2" method="post">
    <div class="modal fade" id="myModal2" role="dialog">
         <div class="modal-dialog">
             <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">รายงานสรุปรายรับ-รายจ่าย</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label>เลือกระยะเวลาของรายงาน</label>
                    <div class="input-group">
                      <button type="button" class="btn btn-default pull-right" id="daterange-btn2">
                        <span>
                          <i class="fa fa-calendar"></i> ระยะเวลา
                        </span>
                        <i class="fa fa-caret-down"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <input type="hidden" name="date_start2" id="date_start2">
                <input type="hidden" name="date_end2" id="date_end2">
                <div class="modal-footer">
                    <button class="btn btn-default pull-left" data-dismiss="modal">ปิด</button>
                    <button class="btn btn-success" type="submit" name="submit">พิมพ์</button>
                </div>
            </div>
        </div>
    </div>
    </form>

  </div>
</div>
</body>
</html>
