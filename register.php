<?php
if($_SERVER["REQUEST_METHOD"]=="post"){
$name=$_POST['name];
$email=$_POST['email'];
$phone=$_POST['phone'];
$destination=$_POST['destination'];
if(empty($name) || empty($email) || empty($phone) || empty($destination)){
	echo"please fill in all fields.";
}
else{
$servername="localhost";
$username="username";
$password="password";
$dbname="travel_tourism";
$conn=new mysqli($servername,$username,$password,$dbname);
if($conn->connect_error){
	die("connection failed:".$conn->connect_error);
}
$sql="INSERT INTO registrations(name,email,phone,destination)VALUES('$name','$email','$phone','$destination')";
if($conn->query($sql)==TRUE){
	echo"Registration successful!";
}else{
	echo "Error:".$sql."<br>".$conn->error;
}
$conn->close();
}
}
?>