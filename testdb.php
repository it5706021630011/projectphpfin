<?php
if($submit == "submit"){

$fname = $_POST["fname"];
$lname = $_POST["lname"];

echo "aaaa";
echo "$lname";
?> 
}
 
   <html>
   <body>
   <form action="#" method="post">
   fname<input type="text" name="fname"><br />
   lname<input type ="text" name="lname"><br />
   <input type = "submit" name="submit">
   <?php  echo "aaaa";
   echo "$lname";?>
   
 

  

  
   </form>
   </body>
   </html>