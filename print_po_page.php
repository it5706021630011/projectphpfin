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
    <h2 align="center">ใบสั่งซื้อสินค้า</h2>
  </div>
  <div align="center">
    <table border="0" width="100%" align="center" style="font-size:16px;">
    <?php
        $sql_po1 = "SELECT * FROM purchase_order JOIN company ON purchase_order.com_id = company.com_id JOIN employee ON purchase_order.emp_id = employee.emp_id AND purchase_order.po_id = '".$_GET['id']."'";
        $query_po1 = mysqli_query($conn,$sql_po1);

        while($row = mysqli_fetch_array($query_po1,MYSQLI_ASSOC))
        {
    ?>
        <tr>
            <td width="20%"><b>เลขที่สั่งซื้อ</b></td>
            <td><?php echo "PO-".sprintf("%04d",$_GET['id']);?></td>
            <td width="20%"><b>วันที่สั่งซื้อ</b></td>
            <td><?php echo $row['po_date'];?></td>
        </tr>
        <tr>
            <td width="20%"><b>บริษัทจัดจำหน่าย</b></td>
            <td><?php echo $row['com_name'];?></td>
            <td width="20%"><b>พนักงาน</b></td>
            <td><?php echo $row['emp_name'];?></td>
        </tr>
    <?php
        }
    ?>
  </table>
  </div>
  <br>
  <div align="center">
    <table border="1" width="100%" align="center" style="font-size:16px;">
      <thead>
          <tr>
              <th>รหัสสินค้า</th>
              <th>รายการ</th>
              <th>จำนวน</th>
              <th>หน่วย</th>
              <th>ราคาหน่วย (บาท)</th>
              <th>ราคารวม (บาท)</th>
          </tr>
      </thead>
      <tbody>
          <?php
              $total = 0;

               $sql = "SELECT * FROM purchase_order_detail JOIN purchase_order ON purchase_order.po_id = purchase_order_detail.po_id JOIN product ON purchase_order_detail.pro_id = product.pro_id JOIN product_type ON product_type.pro_type_id = product.pro_type_id JOIN product_unit ON product_unit.pro_unit_id = product.pro_unit_id AND purchase_order_detail.po_id = '".$_GET['id']."'";
               $query = mysqli_query($conn,$sql);

                  while($row = mysqli_fetch_array($query,MYSQLI_ASSOC)){
          ?>
              <tr>
                  <td align="center" width="10%"><?php echo "MCS-".sprintf("%04d",$row['pro_id']);?></td>
                  <td align="left" width="60%"><?php echo $row['pro_type_name'];?><br><?php echo$row['pro_name'];?></td>
                  <td align="right" width="10%"><?php echo $row['pod_amount'];?></td>
                  <td align="center" width="10%"><?php echo $row['pro_unit_name'];?></td>
                  <td align="right" width="5%"><?php echo number_format($row['pod_price'],2);?></td>
                  <td align="right" width="5%"><?php echo number_format($row['pod_price']*$row['pod_amount'],2);$total += $row['pod_price']*$row['pod_amount'];?></td>
              </tr>
              <?php
               }
              ?>
      </tbody>
      <tfoot>
        <tr>
            <th colspan="4"></th>
            <th>รวม (บาท)</th>
            <th align="right"><b><?php echo number_format($total,2);?></b></th>
        </tr>
        <tr>
            <?php
              $sql_vat = "SELECT * FROM vat JOIN purchase_order ON vat.vat_id = purchase_order.vat_id WHERE purchase_order.po_id = '".$_GET['id']."'";
              $query_vat = mysqli_query($conn,$sql_vat);
              $row_vat = mysqli_fetch_array($query_vat,MYSQLI_ASSOC);
            ?>
            <th colspan="4"></th>
             <th>ค่าส่งสินค้า <?php echo $row_vat['vat_persent'];?></th><!--//ภาษี ลบ -->
            <th align="right"><b>
              <?php

              $vat = $row_vat['vat_persent'];
              echo number_format($vat,2);
              ?>
            </b></th>
        </tr>
        <tr>
            <th colspan="4"></th>
            <th>รวมราคาทั้งหมด (บาท)</th>
            <th align="right"><b><?php $total += $vat;
            echo number_format($total,2);?></b></th>
        </tr>
        <tr>
            <th>หมายเหตุ</th>
            <th colspan="5"><?php echo $row['po_annotation'];?></th>
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
