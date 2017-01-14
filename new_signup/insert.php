<script src="jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="script.js" type="text/javascript"></script>

<?php
include_once "dbconnect.php";
date_default_timezone_set("America/Vancouver");
if(isset($_POST['data'])){
$data=$_POST['data'];
  parse_str($data, $value);
  insert_data($con,$value);
}
function nullcheck($data){
if(isset($data) && $data!=null){
return $data;
}else{
return '';
}

}

function insert_data($con,$val){

 $fname=nullcheck($val['fname']);	 //done

 $lname=nullcheck($val['lname']); 	//done

 $email=nullcheck($val['email']); 	//done

 $pwd=md5(nullcheck($val['pass'])); 	//done

 $number=nullcheck($val['phone']);	//done

 $pcode=nullcheck($val['pcode']);	//done

 $address=nullcheck($val['address']);	//done

 $date=date("Y-m-d H:i:s"); 	//done

 $ally=$val['storeeValue']; 	//done

 echo print_r($val);


mysqli_query($con,"INSERT INTO user_tbl_2 (FirstName,LastName,email,upassword,phone_number,address,date,ally,PostalCode) 
VALUES ('$fname','$lname','$email','$pwd','$number','$address','$date',$ally,'$pcode')");
mysqli_close($con);
}
?>