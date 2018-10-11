<?php
    session_start();
    include("connect.php");
  if(isset($_GET['id']) && isset($_POST['date_start2']) && isset($_POST['date_end2'])){
      require_once 'library/pdf/vendor/autoload.php';
      $mpdf = new \Mpdf\Mpdf([
        'default_font_size' => 16,
        'default_font' => 'sarabun'
      ]);
      $date_start = $_POST['date_start2'];
      $date_end = $_POST['date_end2'];

      $sql = "SELECT *,sum(so_price_total) as total_so FROM sale_order WHERE sale_order.sal_stu_id = 2 AND (sale_order.so_date >= '".$date_start."' AND sale_order.so_date <= '".$date_end."') group by sale_order.so_date ";
      $query = mysqli_query($conn,$sql);
      $sql2 = "SELECT *,sum(po_price_total) as total_po FROM purchase_order WHERE purchase_order.po_stu_id = 2 AND (purchase_order.po_date >= '".$date_start."' AND purchase_order.po_date <= '".$date_end."') group by purchase_order.po_date";
      $query2 = mysqli_query($conn,$sql2);
      // echo $sql;
      // echo $sql2;
  ob_start();
?>
<html>
<head>
  <meta charset="utf-8">
</head>
<body>
  <div align="center" style="font-size: 16px">
    <img src="dist/img/logofin.png" align="middle"><br>
    บริษัท ไมโครซายน์ จำกัด<br>
    41/112 ถนนรัตนาธิเบศร์ ตำบลบางกระสอ อำเภอเมืองนนทบุรี จังหวัดนนทบุรี 11000<br>
    โทรศัพท์: 0-2969-9300-2 โทรสาร: 0-2526-4014<br>
    <h2 align="center">รายงานสรุปรายรับ-รายจ่าย</h2>
  </div>
  <div align="center">
    <table border="0" width="100%" align="center" style="font-size:16px;">
        <tr>
            <td width="20%"><b>วันที่พิมพ์รายงาน: </b></td>
            <td><?php echo date("Y-M-d");?></td>
        </tr>
        <tr>
            <td width="20%"><b>วันที่เอกสารตั้งแต่: </b></td>
            <td><?php echo date_format(date_create($date_start),'Y-M-d');?> ถึง <?php echo date_format(date_create($date_end),'Y-M-d');?></td>
        </tr>
  </table>
  </div>
  <br>
  <div align="center">
    <table border="1" width="100%" align="center" style="font-size:16px;">
      <thead>
          <tr>
              <th>รายรับ</th>
              <th>รายจ่าย</th>
              <th>คงเหลือ</th>
          </tr>
      </thead>
      <tbody>
          <?php
               $total = 0;
               if(mysqli_fetch_array($query,MYSQLI_ASSOC) != "" &&mysqli_fetch_array($query2,MYSQLI_ASSOC) != ""){
                  $row = mysqli_fetch_array($query,MYSQLI_ASSOC);
                  $row2 = mysqli_fetch_array($query2,MYSQLI_ASSOC);
                  $total = $row['total_so'] - $row2['total_po'];
          ?>
              <tr>
                  <td align="center" width="33%"><?php echo number_format($row['total_so'],2);?></td>
                  <td align="center" width="33%"><?php echo number_format($row2['total_po'],2);?></td>
                  <td align="right" width="33%"><?php echo number_format($total,2);?></td>
              </tr>
              <?php
              }else{
              ?>
                <tr><td colspan="3" align="center">ไม่มีข้อมูล</td></tr>
              <?php
              }
              ?>
      </tbody>
      <tfoot>
        <tr>
          <td align="left">พิมพ์โดย: <?php echo $_SESSION['UserName'];?></td>
        </tr>
      </tfoot>
    </table>
  </div>
</body>
</html>
<?php
  $html = ob_get_contents();
  ob_end_clean();
      $mpdf->WriteHTML($html,2);
      $mpdf->Output();
    }
    else{
?>
      <script>
        alert('ไม่มีรายการให้เลือกปริ้น');
        window.location='home.php';
      </script>
<?php
    }
?>
