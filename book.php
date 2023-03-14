<?php
	$host="m.sevens.ga"; //Add your SQL Server host here
	$user="sevns"; //SQL Username
	$pass="6u2KuF5tKW"; //SQL Password
	$dbname="sevns_book"; //SQL Database Name
	$con=mysqli_connect($host,$user,$pass,$dbname);
	if (mysqli_connect_errno($con))
	{
		echo "<h1>Failed to connect to MySQL: " . mysqli_connect_error() ."</h1>";
	}
	$name=$_POST['name'];
	$message=$_POST['message'];
	$sql="INSERT INTO guestbook(name,message) VALUES('$name','$message')";
	if (!mysqli_query($con,$sql))
	{
		die('Error: ' . mysqli_error($con));
	}
	else
		echo "Values Stored in our Database!";
    mysqli_close($con);
    $con=mysqli_connect($host,$user,$pass,$dbname);
	if (mysqli_connect_errno($con))
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$result = mysqli_query($con,"SELECT name,message FROM guestbook");
	while($row = mysqli_fetch_array($result))
	{ ?>
	<h3><?php echo $row['name']; ?></h3>
    <p><?php echo $row['message']; ?></p>
	<?php } 
		mysqli_close($con);
?>