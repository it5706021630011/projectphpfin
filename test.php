<?php
    session_start();
	include("connect.php");

    $sql = "SELECT * FROM customer";
	$query = mysqli_query($conn,$sql);

    if(isset($_POST['edit_row'])){
        $row = $_POST['row_id'];
        $tle = $_POST['tle_id'];
        $emp_name_val = $_POST['emp_name_val'];
        $emp_user_val = $_POST['emp_user_val'];

        $sql_ck_update = "SELECT * FROM customer WHERE emp_id != '".$row."' AND (emp_name = '".$emp_name_val."' OR emp_user = '".$emp_user_val."')";
        $query_ck_update = mysqli_query($conn,$sql_ck_update);
        $num = mysqli_num_rows($query_ck_update);

        if($num > 0){
            $mgs = "ไม่สามารถแก้ไขข้อมูลได้ !! เนื่องจากข้อมูลถูกซ้ำ.";
            $_SESSION['mgs'] = $mgs;
        }
        else{
            mysqli_query($conn,"UPDATE customer SET tle_id='".$tle."',emp_name='".$emp_name_val."',emp_user='".$emp_user_val."' where emp_id='".$row."'");
            $mgs = "ทำการแก้ไขข้อมูลแล้ว!";
            $_SESSION['mgs'] = $mgs;
        }
        exit();
    }

    if(isset($_POST['delete_row'])){
        $row = $_POST['row_id'];

        $sql_delete = "DELETE FROM customer WHERE cus_id = '".$row."'";

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

    if(isset($_POST['insert_row'])){
        $tle_id = $_POST['tle_id'];
        $emp_name = $_POST['emp_name'];
        $emp_user = $_POST['emp_user'];
        $emp_pass = $_POST['emp_pass'];
        $emp_pass = md5($emp_pass);
        $emp_status = $_POST['emp_status'];

        $sql_ck_add = "SELECT * FROM customer WHERE emp_name = '".$emp_name."' OR emp_user = '".$emp_user."'";
        $query_ck_add = mysqli_query($conn,$sql_ck_add);
        $num = mysqli_num_rows($query_ck_add);

        if($num > 0){
            $mgs = "ไม่สามารถเพิ่มข้อมูลได้ !! เนื่องจากข้อมูลซ้ำ.";
            $_SESSION['mgs'] = $mgs;
        }
        else{
            $sql_add = "INSERT INTO customer VALUES('','".$tle_id."','".$emp_name."','".$emp_user."','".$emp_pass."','".$emp_status."')";
            mysqli_query($conn,$sql_add);
            $mgs = "ทำการเพิ่มข้อมูลแล้ว!";
            $_SESSION['mgs'] = $mgs;
        }
        exit();
    }

    if(isset($_POST['resetpass'])){
        $pass = $_POST['pass'];
        $pass = md5($pass);
        $id = $_POST['id'];
        $sql_resetpass = "UPDATE customer SET emp_pass='".$pass."' WHERE emp_id = '".$id."'";
        mysqli_query($conn,$sql_resetpass);
        exit();
    }

    if(isset($_POST['change'])){
        if($_POST['stu_name'] == "ADMIN"){
            $status = "ADMIN";
        }
        else if($_POST['stu_name'] == "USER_L1"){
           $status = "USER_L1";
        }
        else if($_POST['stu_name'] == "USER_L2"){
           $status = "USER_L2";
        }
        $emp_id = $_POST['id'];

        $sql_approve = "UPDATE customer SET emp_status='".$status."' WHERE emp_id = '".$emp_id."'";
        mysqli_query($conn,$sql_approve);
        exit();
    }

    if(isset($_POST['confirmPass'])){
        $pass = md5($_POST['name']);
        $pass = substr($pass,0,20);
        $sql_con_pass = "SELECT * FROM customer WHERE emp_id = '".$_POST['id']."' AND emp_pass = '".$pass."'";
        $query_con_pass = mysqli_query($conn,$sql_con_pass);
        $num = mysqli_num_rows($query_con_pass);

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
       var cus_id = document.getElementById("cus_id_val"+id).innerHTML;
       var cus_name = document.getElementById("cus_name_val"+id).innerHTML;
       var cus_address = document.getElementById("cus_address_val"+id).innerHTML;
       var cus_point = document.getElementById("cus_point_val"+id).innerHTML;
       var cus_email = document.getElementById("cus_email_val"+id).innerHTML;
       var cus_tel = document.getElementById("cus_tel_val"+id).innerHTML;
       var cus_user = document.getElementById("cus_user_val"+id).value;
       var bo_name = document.getElementById("bo_name_val"+id).value;

       document.getElementById("edit_cus_id").value = cus_id;
       document.getElementById("edit_cus_name").value = cus_name;
       document.getElementById("edit_cus_address").value = cus_address;
       document.getElementById("edit_cus_point").value = cus_point;
       document.getElementById("edit_cus_email").value = cus_email;
       document.getElementById("edit_cus_tel").value = cus_tel;
       document.getElementById("edit_cus_user").value = cus_user;
       document.getElementById("edit_bo_name").value = bo_name;
  }

  function save_row()
  {
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
                                 row_id:cus_id,
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
                          url:'customer_page.php',
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
                      $.alert('ยกเลิกการเพิ่มรายการข้อมูลพนักงานแล้ว!');
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
  //});
  }

  function resetpass(pass,id)
  {
      $.confirm({
              title: 'การยืนยัน!',
              content: 'คุณต้องการรีเซตรหัสผ่านพนักงานใช่หรือไม่!',
              buttons: {
                  ตกลง: function () {
                              $.ajax({
                              type:'post',
                              url:'customer_page.php',
                              data:{resetpass:'resetpass',
                              pass:pass,
                              id:id},
                              success: function(response){
                                // alert(pass+" "+id);
                                  $.alert('ทำการรีเซตรหัสผ่านพนักงานแล้ว!');
                                  setTimeout("location.reload(false)",1500);
                              }
                          });
                  },
                  ยกเลิก: function () {
                      $.alert('ยกเลิกการรีเซตรหัสผ่านพนักงานแล้ว!');
                      setTimeout("location.reload(false)",1500);
                  }
              }
      });
  }

  function confirmPass(id){
      $.confirm({
          title: 'รหัสผ่านใหม่!',
          content: '' +
          '<form action="" ">' +
          '<div class="form-group">' +
          '<input type="password" class="name form-control" required />' +
          '</div>' +
          '</form>',
          buttons: {
              formSubmit: {
                  text: 'ตกลง',
                  btnClass: 'btn-blue',
                  action: function () {
                      var name = this.$content.find('.name').val();
                      if(!name){
                          $.alert('กรุณาใสรหัสผ่าน');
                          return false;
                      }
                          resetpass(name,id);
                  }
              },
              ยกเลิก: function () {
                  //close
              },
          },
          onContentReady: function () {
              // bind to events
              var jc = this;
              this.$content.find('form').on('submit', function (e) {
                  // if the user submits the form by pressing enter in the field.
                  e.preventDefault();
                  jc.$$formSubmit.trigger('click'); // reference the button and click it
              });
          }
      });
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
        การจัดการข้อมูลลุกค้า
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
              <h3 class="box-title">ตารางข้อมูลลูกค้า</h3>
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> เพิ่มข้อมูลลูกค้า</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="pro_table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>รหัสลูกค้า</th>
                        <th>ชื่อ</th>
                        <th>ที่อยู่</th>
                        
                        <th>อีเมล์</th>
                        <th>เบอร์โทร</th>
                        <th>การจัดการข้อมูล</th>
                    </tr>
                </thead>
                <tbody>
                <?php
					while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
					{
                ?>
                    <tr id="row<?php echo $row['emp_id'];?>">
                        <td id="cus_id_val<?php echo $row['cus_id'];?>"><?php echo $row['cus_id'];?></td>
                        <td id="cus_name_val<?php echo $row['cus_id'];?>"><?php echo $row['cus_name'];?></td>
                        <td id="cus_address_val<?php echo $row['cus_id'];?>"><?php echo $row['cus_address'];?></td>
                       
                        <td id="cus_email_val<?php echo $row['cus_id'];?>"><?php echo $row['cus_email'];?></td>
                        <td id="cus_tel_val<?php echo $row['cus_id'];?>"><?php echo $row['cus_tel'];?></td>
                        <input type="hidden" id="cus_user_val<?php echo $row['cus_id'];?>" value="<?php echo $row['cus_user'];?>">
                        <input type="hidden" id="bo_name_val<?php echo $row['cus_id'];?>" value="<?php echo $row['bo_name'];?>">
                        <td>
                            <button class="btn btn-warning" data-toggle="modal" data-target="#myModal2" id="edit_button<?php echo $row['cus_id'];?>" onclick="edit_row('<?php echo $row['cus_id'];?>');"><i class="fa fa-fw fa-pencil-square-o"></i></button>
                            <button class="btn btn-danger" id="delete_button<?php echo $row['cus_id'];?>" onclick="delete_row('<?php echo $row['cus_id'];?>');"><i class="fa fa-fw fa-trash-o"></i></button>
                            <button class="btn btn-primary" id="resetpass_button<?php echo $row['cus_id'];?>" onclick="confirmPass('<?php echo $row['cus_id'];?>');"><i class="fa fa-key"></i> เปลี่ยนรหัสผ่าน</button>
                        </td>
                    </tr>
                <?php
					}
				?>
                </tbody>
              </table>
            </div>
          </div>

                <div class="modal fade" id="myModal" role="dialog">
                     <div class="modal-dialog">
                         <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">เพิ่มข้อมูลลูกค้า</h4>
                            </div>
                              <div class="modal-body">
                                <div class="form-group">
                                    <label>รหัสลูกค้า</label>
                                    <input type="text" class="form-control" id="add_cus_id" readonly>
                                </div>
                                <div class="form-group">
                                    <label>ชื่อ<font color="red"> *</font></label>
                                    <input type="text" class="form-control" id="add_cus_name" required>
                                </div>
                                <div class="form-group">
                                    <label>ที่อยู่<font color="red"> *</font></label>
                                    <input type="text" class="form-control" id="add_cus_address" required>
                                </div>
                                <div class="form-group">
                                    <label>อีเมล์<font color="red"> *</font></label>
                                    <input type="text" class="form-control" id="add_cus_email" required>
                                </div>
                                <div class="form-group">
                                    <label>เบอร์โทร<font color="red"> *</font></label>
                                    <input type="text" class="form-control" id="add_cus_tel" required>
                                </div>
                                <div class="form-group">
                                    <label>ชื่อผู้ใช้<font color="red"> *</font></label>
                                    <input type="text" class="form-control" id="add_cus_user" required>
                                </div>
                                <div class="form-group">
                                    <label>รหัสผ่าน<font color="red"> *</font></label>
                                    <input type="text" class="form-control" id="add_cuss_pass" required>
                                </div>
                                <div class="form-group">
                                    <label>ยืนยันรหัสผ่าน<font color="red"> *</font></label>
                                    <input type="text" class="form-control" id="add_cus_pass_con" required>
                                </div>
                                <div class="form-group">
                                    <label>ชื่อบนบอร์ดแสดงความเห็น<font color="red"> *</font></label>
                                    <input type="text" class="form-control" id="add_bo_name" required>
                                </div>
                              </div>
                              <div class="modal-footer">
                                  <button class="btn btn-default pull-left" data-dismiss="modal">ปิด</button>
                                  <button type="submit" class="btn btn-success" onclick="insert_row()">เพิ่ม</button>
                              </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="myModal2" role="dialog">
                     <div class="modal-dialog">
                         <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">แก้ไขข้อมูลลูกค้า</h4>
                            </div>
                            <div class="modal-body">
                              <div class="form-group">
                                  <label>รหัสลูกค้า</label>
                                  <input type="text" class="form-control" id="edit_cus_id" readonly>
                              </div>
                              <div class="form-group">
                                  <label>ชื่อ<font color="red"> *</font></label>
                                  <input type="text" class="form-control" id="edit_cus_name" required>
                              </div>
                              <div class="form-group">
                                  <label>ที่อยู่<font color="red"> *</font></label>
                                  <input type="text" class="form-control" id="edit_cus_address" required>
                              </div>

                              <div class="form-group">
                                  <label>อีเมล์<font color="red"> *</font></label>
                                  <input type="text" class="form-control" id="edit_cus_email" required>
                              </div>
                              <div class="form-group">
                                  <label>เบอร์โทร<font color="red"> *</font></label>
                                  <input type="text" class="form-control" id="edit_cus_tel" required>
                              </div>
                              <div class="form-group">
                                  <label>ชื่อผู้ใช้<font color="red"> *</font></label>
                                  <input type="text" class="form-control" id="edit_cus_user" required>
                              </div>
                              <div class="form-group">
                                  <label>ชื่อบนบอร์ดแสดงความเห็น<font color="red"> *</font></label>
                                  <input type="text" class="form-control" id="edit_bo_name" required>
                              </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-default pull-left" data-dismiss="modal">ปิด</button>
                            <button type="submit" class="btn btn-success" onclick="save_row()">บันทึก</button>
                        </div>
                    </div>
                </div>
          </div>
          <!-- /.box -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
</div>
</body>
</html>
