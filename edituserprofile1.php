<?php
session_start();
include_once 'dbconnect.php';

//set validation error flag as false
$error = false;
mysqli_select_db($con,'testdb');

$id = $_SESSION['usr_id'];
$result = mysqli_query($con, "SELECT * FROM `users` WHERE uid = $id ");
//echo "SELECT * FROM users WHERE uid = $id ";



$row = mysqli_fetch_array($result);
//echo $row;
	$fname = $row['name'];
    $fgender = $row['gender']; 
    $fcaste = $row['caste'];
    $fpercentage = $row['percentage'];
    $fcontact = $row['contact'];
    $fuaddress =$row['uaddress'];
    $fcity = $row['city'];
	$dis=$row['distance'];
	//echo $fname;
//check if form is submitted
if (isset($_POST['submit'])) {
	//echo "submitit";
	$id = $_SESSION['usr_id'];
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $caste = mysqli_real_escape_string($con, $_POST['caste']);
    $percentage = $_POST['percentage'];
    $contact = mysqli_real_escape_string($con, $_POST['contact']);
    $uaddress = mysqli_real_escape_string($con, $_POST['home_address']);
    $city = mysqli_real_escape_string($con, $_POST['city']);
	$dis = $_POST['dis'];

   
  
    //name can contain only alpha characters and space
    if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
        $error = true;
        $name_error = "Name must contain only alphabets and space";
    }
    if (!preg_match("/(7|8|9)\d{9}/",$contact)) {
        $error = true;
        $contact_error = "Mobile number is not in correct format";
    }
    if (!$error) {
		/*echo "INSERT INTO users VALUES (" . $id . ", '" . $name . "', '" . $gender . "',
					'" . $caste ."', " . $percentage ."," . $contact . ", '" . $uaddress ."', '" . $city. "');";*/
		//echo "in if";
		mysqli_select_db($con,'testdb');
				/*if(mysqli_query($con, "INSERT INTO users VALUES (" . $id . ", '" . $name . "', '" . $gender . "',
					'" . $caste ."', " . $percentage ."," . $contact . ", '" . $uaddress ."', '" . $city. "');")) {*/
				//echo "UPDATE users SET name='" . $name . "', gender='" . $gender . "', caste='" . $caste ."',percentage= " . $percentage .",contact=" . $contact . ", uaddress='" . $uaddress ."', city='" . $city. "' where uid = ".$id;
		if(mysqli_query($con, "UPDATE users SET name='" . $name . "', gender='" . $gender . "',
			caste='" . $caste ."',percentage= " . $percentage .",contact=" . $contact . ", uaddress='" . $uaddress ."', city='" . $city. "',distance=".$dis." where uid = ".$id)) {
									
						//if(mysqli_query($con, "INSERT INTO users VALUES(".$_POST["id"].",'".$_POST["name"]."','".$_POST["gender"]."','".$_POST["caste"]."',".$_POST["percentage"].",".$_POST["contact"].",
						//'".$_POST["uaddress"]."','".$_POST["city"]."')"){
							

		
		$successmsg = "Successfully Edited!"; 
		header("Location: hostels3.php");
		unset($name);
		unset($gender);
		unset($caste);
		unset($percentage);
		unset($contact);
		unset($home_address);
		unset($city);
        }

		/*if(mysqli_query($con, "INSERT INTO images VALUES (" . $marksheet . ", '" . $address . "', '" . $caste . "',
					'" . $caste ."', " . $percentage ."," . $contact . ", '" . $uaddress ."', '" . $city. "');"));*/
		else {
            $errormsg = "Error in editing...Please try again later!";
        }
    }
}
?>
<html lang="en-US">

	<head>
		<title>Edit User Profile</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/hostels.css">
	</head>
	<body>
		<nav class="navbar navbar-inverse navbar-static-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="hostels3.php"><img class="logo" src="images/hh_white.png" alt="logo" /></a>
        </div>
        <ul class="nav navbar-nav">
          <li><a href="hostels3.php">Home</a></li>
          <li><a href="faqs.php">FAQs</a></li>
          <li><a href="sitemap.php">Sitemap</a></li>
          <li><a href="contact.php">Contact</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li style="color: white"><a href="#"><span class="glyphicon glyphicon-user"></span> <?php echo  $_SESSION['usr_name']; ?></a></li>
          <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
        </ul>
      </div>
    </nav>
		<form name="edituserprofile" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<table align="center" border="0" cellspacing="25px" cellpadding="25px" width="80">
				<tr>
					<td>Name</td>
					<td><input type="text" name="name" value="<?php echo $fname;?>" required/>
				</tr>
				<tr>						
					<td>Gender</td>
					<td>
					<?php if($fgender=='Male') {echo '
					<input type="radio" name="gender" value = "Male" checked>Male
						<input type="radio" name="gender" value = "Female">Female</td>';
					}
			elseif($fgender=='Female'){ echo '
						<input type="radio" name="gender" value = "Male">Male
						<input type="radio" name="gender" value = "Female" checked>Female</td>
			';}
			else
			{
				 echo '<input type="radio" name="gender" value = "Male">Male
						<input type="radio" name="gender" value = "Female">Female</td>';
				
			} ?>
					
				</tr>
				<tr>
					<td>Caste</td>
					<td>
					<?php if($fcaste=='Open'){ echo '
					<select name="caste">
							<option value="Open" selected>General</option>
							<option value="SC">Scheduled Caste</option>
							<option value="ST">Scheduled Tribe</option>
							<option value="SEBC">Socially and Educationally Backward Classes</option>
</select>';}
						
						 elseif($fcaste=='SC') {echo '
					<select name="caste">
							<option value="Open" selected>General</option>
							<option value="SC" selected>Scheduled Caste</option>
							<option value="ST">Scheduled Tribe</option>
							<option value="SEBC">Socially and Educationally Backward Classes</option>
						 </select>';}
						
						 elseif($fcaste=='ST') {echo '
					<select name="caste">
							<option value="Open">General</option>
							<option value="SC">Scheduled Caste</option>
							<option value="ST" selected>Scheduled Tribe</option>
							<option value="SEBC">Socially and Educationally Backward Classes</option>
						 </select>';}
						
						 elseif($fcaste=='SEBC') {echo '
					<select name="caste">
							<option value="Open">General</option>
							<option value="SC">Scheduled Caste</option>
							<option value="ST">Scheduled Tribe</option>
							<option value="SEBC" selected>Socially and Educationally Backward Classes</option>
						 </select>';}
						
						else
							
							{echo '<select name="caste">
							<option value="Open">General</option>
							<option value="SC">Scheduled Caste</option>
							<option value="ST">Scheduled Tribe</option>
							<option value="SEBC">Socially and Educationally Backward Classes</option>
							</select>';}
						
						?>
						
						
					</td>
				</tr>
				<tr>
					<td>Percentage</td>
					<td><input type="text" name="percentage"  value="<?php echo $fpercentage;?>" required/>
				</tr>
				<tr>
					<td>Contact</td>
					<td><input type="text" name="contact" value="<?php echo $fcontact;?>" required/></td>
				</tr>
				<tr>
					<td>Address</td>
					<td><textarea rows="6" cols="40" name="home_address" value="<?php echo $fuaddress;?>" required></textarea></td>
				</tr>
				<tr>
					<td>City</td>
					<td><input type="text" name="city"  value="<?php echo $fcity;?>" required/>
				</tr>
				<tr>
					<td>Distance from institute</td>
					<td><input type="number" name="dis"  value="<?php echo $fdis;?>" required/>
				</tr>
				<tr>
					<td>Marksheet Image</td>
					<td><input type="file" name="marksheet" />
				</tr>
				<tr>
					<td>Address Verification Image</td>
					<td><input type="file" name="marksheet" />
				</tr>
				<tr>
					<td>Caste Verification Image</td>
					<td><input type="file" name="caste_image" />
				</tr>
				<br />
				<tr>
					<td><input type="submit" name="submit"></td>
					<td><button type="reset">Discard</button></td>
				</tr>
			</table>
		</form>
	</body>
</html>