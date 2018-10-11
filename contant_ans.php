<?php
    session_start();
	include("connect.php");

    $sql = "SELECT * FROM contact";
    $query = mysqli_query($conn,$sql);
    $sql1 = "SELECT * FROM contact_emp";
	$query1 = mysqli_query($conn,$sql1);

    // if(isset($_POST['edit_row'])){
    //     $row = $_POST['row_id'];
    //     $tle = $_POST['tle_id'];
    //     $emp_name_val = $_POST['contact_id'];
    //     $emp_user_val = $_POST['emp_user_val'];

    //     $sql_ck_update = "SELECT * FROM contact_emp WHERE contact_emp_id != '".$row."' AND (contact_id = '".$emp_name_val."' OR emp_user = '".$emp_user_val."')";
    //     $query_ck_update = mysqli_query($conn,$sql_ck_update);
    //     $num = mysqli_num_rows($query_ck_update);

    //     if($num > 0){
    //         $mgs = "ไม่สามารถแก้ไขข้อมูลได้ !! เนื่องจากข้อมูลถูกซ้ำ.";
    //         $_SESSION['mgs'] = $mgs;
    //     }
    //     else{
    //         mysqli_query($conn,"UPDATE contact_emp SET tle_id='".$tle."',emp_name='".$emp_name_val."',emp_user='".$emp_user_val."' where emp_id='".$row."'");
    //         $mgs = "ทำการแก้ไขข้อมูลแล้ว!";
    //         $_SESSION['mgs'] = $mgs;
    //     }
    //     exit();
    // }



    // if(isset($_POST['insert_row'])){
    //     $tle_id = $_POST['tle_id'];
    //     $emp_name = $_POST['emp_name'];
    //     $emp_user = $_POST['emp_user'];
    //     $emp_pass = $_POST['emp_pass'];
    //     $emp_pass = md5($emp_pass);
    //     $emp_status = $_POST['emp_status'];

    //     $sql_ck_add = "SELECT * FROM customer WHERE emp_name = '".$emp_name."' OR emp_user = '".$emp_user."'";
    //     $query_ck_add = mysqli_query($conn,$sql_ck_add);
    //     $num = mysqli_num_rows($query_ck_add);

    //     if($num > 0){
    //         $mgs = "ไม่สามารถเพิ่มข้อมูลได้ !! เนื่องจากข้อมูลซ้ำ.";
    //         $_SESSION['mgs'] = $mgs;
    //     }
    //     else{
    //         $sql_add = "INSERT INTO customer VALUES('','".$tle_id."','".$emp_name."','".$emp_user."','".$emp_pass."','".$emp_status."')";
    //         mysqli_query($conn,$sql_add);
    //         $mgs = "ทำการเพิ่มข้อมูลแล้ว!";
    //         $_SESSION['mgs'] = $mgs;
    //     }
    //     exit();
    // }
        // if(isset($_POST['change'])){
    //     if($_POST['stu_name'] == "ADMIN"){
    //         $status = "ADMIN";
    //     }
    //     else if($_POST['stu_name'] == "USER_L1"){
    //        $status = "USER_L1";
    //     }
    //     else if($_POST['stu_name'] == "USER_L2"){
    //        $status = "USER_L2";
    //     }
    //     $emp_id = $_POST['id'];

    //     $sql_approve = "UPDATE customer SET emp_status='".$status."' WHERE emp_id = '".$emp_id."'";
    //     mysqli_query($conn,$sql_approve);
    //     exit();
    // }

    if(isset($_POST['delete_row'])){
        $row = $_POST['row_id'];

        $sql_delete = "DELETE FROM contact WHERE contact_id = '".$row."'";

        if(mysqli_query($conn,$sql_delete)){
            $mgs = "ทำการลบข้อมูลแล้ว!";
            $_SESSION['mgs'] = $mgs;
        }
        else{
            $mgs = "ไม่สามารถลบข้อมูลได้ !! เนื่องจากข้อมูลถูกใช้อยู่.";
            $_SESSION['mgs'] = $mgs;
        }
        exit();
    }

    if(isset($_POST['con_ans'])){
        $Ans = $_POST['ans'];
        $Ans = md5($Ans);
        $contact_id = $_POST['id'];
        $contact_id = md5($contact_id);
        
        $sql_con_ans = "INSERT INTO contact_emp VALUES('','".$contact_id."','".$Ans."')";
        mysqli_query($conn,$sql_con_ans);
        exit();
    }


    if(isset($_POST['confirmAns'])){
        $Ans = md5($_POST['name']);
        $contact_id = md5($_POST['id']);      
        $sql_con_Ans = "INSERT INTO contact_emp VALUES('','".$contact_id."','".$Ans."')";
        $query_con_Ans = mysqli_query($conn,$sql_con_Ans);
        $num = mysqli_num_rows($query_con_Ans);

    }
?>
<html>
<head>
<title>การจัดการลูกค้า</title>
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
  <link rel="stylesheet" type="text/css" href="dist/css/styleFont.css" />

  <script src="dist/js/app.min.js"></script>
  <script src="dist/js/demo.js"></script>

  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
  <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
  <script src="plugins/fastclick/fastclick.js"></script>
  <script src="plugins/select2/select2.full.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
  <script src="http://malsup.github.com/jquery.form.js"></script>

  <script>

  $(function () {

    $("#pro_table").DataTable({
                        "oLanguage": {
                        "sLengthMenu": 'แสดง _MENU_ รายการ ต่อหน้า',
                        "sZeroRecords": 'ไม่เจอข้อมูลที่ค้นหา',
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
                }
    });
  });

  function edit_row(id)
  {
       var cus_id = document.getElementById("contact_id_val"+id).innerHTML;
       var cus_name = document.getElementById("contact_type_id_val"+id).innerHTML;
       var cus_address = document.getElementById("so_id_val"+id).innerHTML;
       var cus_email = document.getElementById("contact_detail_val"+id).innerHTML;
       var cus_tel = document.getElementById("cus_id_val"+id).innerHTML;
 

       document.getElementById("edit_contact_id").value = cus_id;
       document.getElementById("edit_contact_type_id").value = cus_name;
       document.getElementById("edit_so_id").value = cus_address;
       document.getElementById("edit_contact_detail").value = cus_point;
       document.getElementById("edit_cus_id").value = cus_email;
  }

  function save_row()
  {
    var cus_id = document.getElementById("contact_id_val").value;
    var cus_name = document.getElementById("contact_type_id_val").value;
    var cus_address = document.getElementById("so_id_val").value;
    var cus_email = document.getElementById("contact_detail_val").value;
    var cus_tel = document.getElementById("cus_id_val").value;

    var cus_id = document.getElementById("edit_cus_id").value;
    var cus_name = document.getElementById("edit_cus_name").value;
    var cus_address = document.getElementById("edit_cus_address").value;
    var cus_point = document.getElementById("edit_cus_point").value;
    var cus_email = document.getElementById("edit_cus_email").value;
    var cus_tel = document.getElementById("edit_cus_tel").value;
    var cus_user = document.getElementById("edit_cus_user").value;
    var bo_name = document.getElementById("edit_bo_name").value;

       $.confirm({
              title: 'การยืนยัน!',
              content: 'คุณต้องการแก้ไขรายการข้อมูลลูกค้าใช่หรือไม่!',
              buttons: {
                  ตกลง: function () {
                             $.ajax({
                                type:'post',
                                url:'customer_page.php',
                                data:{
                                 edit_row:'edit_row',
                                 row_id:contact_id,
                                 cus_name:cus_name,
                                 cus_address:cus_address,
                                 cus_point:cus_point,
                                 cus_email:cus_email,
                                 cus_tel:cus_tel,
                                 cus_user:cus_user,
                                 bo_name:bo_name,
                               },
                                 success:function(response) {
                                     location.reload(false);
                                 }
                          });
                  },
                  ยกเลิก: function () {
                      $.alert('ยกเลิกการแก้ไขแล้ว!');
                  }
              }
      });

  }

  function delete_row(id)
  {
      $.confirm({
              title: 'การยืนยัน!',
              content: 'คุณต้องการลบรายการข้อมูลลูกค้าใช่หรือไม่!',
              buttons: {
                  ตกลง: function () {
                      $.ajax({
                          type:'post',
                          url:'contant_ans.php',
                          data:{delete_row:'delete_row',
                          row_id:id},
                          success: function(response){
                              location.reload(false);
                          }
                      });
                  },
                  ยกเลิก: function () {
                      $.alert('ยกเลิกการลบแล้ว!');
                  }
              }
      });
  }

  function insert_row(){

      var tle_id = document.getElementById("new_tle_id").value;
      var emp_name = document.getElementById("new_emp_name").value;
      var emp_user = document.getElementById("new_emp_user").value;
      var emp_pass = document.getElementById("new_emp_pass").value;
      var emp_pass_con = document.getElementById("new_emp_pass_con").value;
      var emp_status = document.getElementById("new_emp_status").value;
      var text_null = false;

      if(emp_pass != "" && emp_pass_con != "" && emp_pass == emp_pass_con && tle_id != "" && emp_name != "" && emp_user != "" && emp_status != ""){
          text_null = true;
      }
      else{
           $.alert('เติมข้อมูลไม่ครบ หรือ รหัสผ่านไม่ตรงกัน!');
      }

      if(text_null == true){
          $.confirm({
              title: 'การยืนยัน!',
              content: 'คุณต้องการเพิ่มรายการข้อมูลพนักงานใช่หรือไม่!',
              buttons: {
                  ตกลง: function () {
                          $.ajax({
                              type:'post',
                              url:'customer_page.php',
                              data:{insert_row:'insert_row',
                              tle_id:tle_id,
                              emp_name:emp_name,
                              emp_user:emp_user,
                              emp_pass:emp_pass,
                              emp_status:emp_status},
                              success: function(response){
                                  location.reload(false);
                              }
                          });
                      }
                  },
                  ยกเลิก: function () {
                      $.alert('ยกเลิกการตอบกลับ!');
                      document.getElementById("new_tle_id").value = "";
                      document.getElementById("new_emp_name").value = "";
                      document.getElementById("new_emp_user").value = "";
                      document.getElementById("new_emp_pass").value = "";
                      document.getElementById("new_emp_pass_con").value = "";
                      document.getElementById("new_emp_status").value ="";
                      setTimeout("location.reload(false)",1500);
                  }
          });
      }
  }

  function con_ans(ans,id)
  {
      $.confirm({
              title: 'การยืนยัน!',
              content: 'คุณต้องการตอบกลับใช่หรือไม่!',
              buttons: {
                ตกลง: function () {
                              $.ajax({
                              type:'post',
                              url:'customer_ans.php',
                              data:{con_ans:'con_ans',
                              ans:ans,
                              id:id},
                              success: function(response){
                                alert(ans+" "+id);
                                  $.alert('ทำการตอบกลับเรียบร้อยแล้ว!');
                                  setTimeout("location.reload(false)",1500);
                              }
                          });
                  },
                  ยกเลิก: function () {
                      $.alert('ยกเลิกการตอบกลับ!');
                      setTimeout("location.reload(false)",1500);
                  }
              }
      });
  }


  


  function confirmAns(id){
      alert(id);
    //   $.confirm({
    //       title: 'ตอบกลับ!',
    //       content: '' +
    //       '<form action="" ">' +
    //       '<div class="form-group">' +
    //       '<input type="text" class="name form-control" required />' +
    //       '</div>' +
    //       '</form>',
    //       buttons: {
    //           formSubmit: {
    //               text: 'ตกลง',
    //               btnClass: 'btn-blue',
    //               action: function () {
    //                   var name = this.$content.find('.name').val();
    //                   if(!name){
    //                       $.alert('กรุณาใส่ข้อความ');
    //                       return false;
    //                   }
    //                       con_ans(name,id);
    //               }
    //           },
    //           ยกเลิก: function () {
    //               //close
    //           },
    //       },
    //       onContentReady: function () {
    //           // bind to events
    //           var jc = this;
    //           this.$content.find('form').on('submit', function (e) {
    //               // if the user submits the form by pressing enter in the field.
    //               e.preventDefault();
    //               jc.$$formSubmit.trigger('click'); // reference the button and click it
    //           });
    //       }
    //   });
  }

  </script>
  <script>
      var m = '<?=$_SESSION['mgs'];?>';
    if(m){
       $.alert(m);
       <?php unset($_SESSION['mgs']);?>
    }
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
        การจัดการข้อมูลตอบกลับลูกค้า
        <!--<small>advanced tables</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="#">การจัดการข้อมูล</a></li>
        <li class="active">ลูกค้า</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">ตอบกลับลูกค้า</h3>
              <!-- <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> เพิ่มข้อมูลลูกค้า</button> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="pro_table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>รหัสการติดต่อ</th>
                        <th>หัวข้อ</th>
                        <th>รหัสการสั่งซื้อ</th>
                        <th>รายละเอียดเนื้อหา</th>
                        <th>ผู้ส่ง</th>
                        <th>ตอบกลับ</th>
                        <!-- <th>เบอร์โทร</th>
                        <th>การจัดการข้อมูล</th> -->
                    </tr>
                </thead>
                <tbody>
                <?php
					while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
					{
                ?>
                    <tr id="row<?php echo $row['contact_emp_id'];?>">
                        <td id="contact_id_val<?php echo $row['contact_id'];?>"><?php echo $row['contact_id'];?></td>
                        <td id="contact_type_id_val<?php echo $row['contact_id'];?>"><?php echo $row['contact_type_id'];?></td>
                        <td id="so_id_val<?php echo $row['contact_id'];?>"><?php echo $row['so_id'];?></td>
                        <td id="contact_detail_val<?php echo $row['contact_id'];?>"><?php echo $row['contact_detail'];?></td>
                        <td id="cus_id_val<?php echo $row['contact_id'];?>"><?php echo $row['cus_id'];?></td>
                        <?php  while($row1 = mysqli_fetch_array($query1,MYSQLI_ASSOC)) {?>
                        <td id="contact_emp_detail_val<?php echo $row1['contact_emp_id'];?>"><?php echo $row1['contact_emp_detail'];?></td>
                        <?php
                        }
                        ?>
                        <!-- <input type="hidden" id="cus_user_val<?php echo $row['contact_id'];?>" value="<?php echo $row['cus_user'];?>">
                        <input type="hidden" id="bo_name_val<?php echo $row['contact_id'];?>" value="<?php echo $row['bo_name'];?>"> -->
                        <td>
                            <!-- <button class="btn btn-warning" data-toggle="modal" data-target="#myModal2" id="edit_button<?php echo $row['cus_id'];?>" onclick="edit_row('<?php echo $row['cus_id'];?>');"><i class="fa fa-fw fa-pencil-square-o"></i></button>-->
                            <button class="btn btn-danger" id="delete_button<?php echo $row['contact_id'];?>" onclick="delete_row('<?php echo $row['contact_id'];?>');"><i class="fa fa-fw fa-trash-o"></i></button> 
                            <button class="btn btn-primary" id="con_ans_button<?php echo $row['contact_id'];?>" onclick="confirmAns('<?php echo $row['contact_id'];?>');"></i> ตอบกลับ</button>
                        </td>
                    </tr>
                <?php
					}
				?>
                </tbody>
              </table>
            </div>
          </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
</div>
</body>
</html>
