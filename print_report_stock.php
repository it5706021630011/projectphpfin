<?php
    session_start();
    include("connect.php");
  if(isset($_GET['id'])){
      require_once 'library/pdf/vendor/autoload.php';
      $mpdf = new \Mpdf\Mpdf([
        'default_font_size' => 16,
        'default_font' => 'sarabun'
      ]);
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
    <h2 align="center">รายงานสินค้าคงคลัง</h2>
  </div>
  <div align="center">
    <table border="0" width="100%" align="center" style="font-size:16px;">
        <tr>
            <td width="20%"><b>วันที่พิมพ์รายงาน: </b></td>
            <td><?php echo date("Y-M-d");?></td>
        </tr>
  </table>
  </div>
  <br>
  <div align="center">
    <table border="1" width="100%" align="center" style="font-size:16px;">
      <thead>
          <tr>
              <th>รหัสสินค้า</th>
              <th>ประเภทสินค้า</th>
              <th>ชื่อสินค้า</th>
              <th>หน่วย</th>
              <th>จำนวน</th>
              <th>ต้นทุนหน่วย (บาท)</th>
              <th>ราคารวม (บาท)</th>
          </tr>
      </thead>
      <tbody>
          <?php
              $total = 0;

               $sql = "SELECT * FROM product JOIN product_type ON product_type.pro_type_id = product.pro_type_id JOIN product_unit ON product_unit.pro_unit_id = product.pro_unit_id order by product.pro_id";
               $query = mysqli_query($conn,$sql);

                  while($row = mysqli_fetch_array($query,MYSQLI_ASSOC)){
          ?>
              <tr>
                  <td align="center" width="5%"><?php echo "MCS-".sprintf("%04d",$row['pro_id']);?></td>
                  <td align="center" width="20%"><?php echo $row['pro_type_name'];?></td>
                  <td align="left" width="40%"><?php echo $row['pro_name'];?></td>
                  <td align="center" width="5%"><?php echo $row['pro_unit_name'];?></td>
                  <td align="right" width="5%"><?php echo $row['pro_amount'];?></td>
                  <td align="right" width="5%"><?php echo number_format($row['pro_price'],2);?></td>
                  <td align="right" width="5%"><?php echo number_format($row['pro_price']*$row['pro_amount'],2);$total+=$row['pro_price']*$row['pro_amount'];?></td>
              </tr>
              <?php
               }
              ?>
      </tbody>
      <tfoot>
        <tr>
          <td align="left" colspan="2">พิมพ์โดย: <?php echo $_SESSION['UserName'];?></td>
          <td colspan="3"></td>
          <td align="right">รวมราคาทั้งหมด</td>
          <td align="right"><?php echo number_format($total,2);?></td>
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
