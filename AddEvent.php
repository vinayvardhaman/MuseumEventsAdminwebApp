<?php
$server_name = "tethys.cse.buffalo.edu";
$user_name = "vinayvar";
$password = "ChangeMe";
$db = "museum_db";

//create connection
$conn = new mysqli($server_name,$user_name,$password,$db);
$conn->set_charset("utf8");

//check connection
if($conn->connect_error){
	die("connection failed".$conn->connect_error);
}

$event_title = $_POST["etitle"];
$event_id = $_POST["eid"];
$category = $_POST["category"];
$recurfrequency = $_POST["recurfrequency"];
$memberonly = "";
$sendtomember = "";
$description = $_POST["description"];
$infourl = $_POST["infourl"];
$startdate = $_POST["startdate"];
$enddate = $_POST["enddate"];
$recurmonths = "";
$recurweeks  = "";
$recurdays   = "";
$photourl    = $_POST["infourl"];  
$infourl     = $_POST["infourl"];
$ticketurl   = $_POST["ticketurl"];
$location    = "Museum";
$isrecurring = "1";

if (!isset($_POST['memberonly'])) {
        
		$memberonly .= "0";
    } else {
        
		$memberonly .= "1";
    }
if (!isset($_POST['sendtomember'])) {
        
		$sendtomember .= "0";
    } else {
        $sendtomember .= "1";
    }


foreach($_POST["recurmonths"] as $selectedvalue)
{
		$recurmonths .= $selectedvalue.',';
}
$recurmonths = rtrim($recurmonths,", ");

foreach($_POST["recurdays"] as $selectedvalue)
{
		$recurdays .= $selectedvalue.', ';
}
$recurdays = rtrim($recurdays,", ");
foreach($_POST["recurweeks"] as $selectedvalue)
{
		$recurweeks .= $selectedvalue.', ';
}
$recurweeks = rtrim($recurweeks,", ");



$sql2 = "INSERT INTO Event_Table(Event_ID, Title, Short_Description, Long_Description, Location, Start_Date, End_Date, IsMemberOnly, SendToMembersOnly, IsRecurring, PhotoURL, TicketURL, MoreInfoURL)
         VALUES('$event_id', '$event_title', '$description', '$description', '$location', '$startdate', '$enddate', '$memberonly', '$sendtomember', $isrecurring, '$photourl', '$ticketurl', '$infourl')";

$response = new\stdClass();

if($conn->query($sql2) === TRUE){
	$response->message = "Event Added";	
	echo json_encode($response);
  
	
	}
	else{
		$response->error="Inserting to Event table failed";
		echo  json_encode($response);	
	}
	
if($isrecurring == "1")
{
	$sql3 = "INSERT INTO RecurringEvent_Table(Event_ID, Recurring_Days, Recurring_Weeks, Recurring_Months, Recurring_Frequency, End_Repeat)
	VALUES('$event_id', '$recurdays', '$recurweeks', '$recurmonths', '$recurfrequency', '$enddate')";
	
	if($conn->query($sql3) === TRUE){
	$response->message = "RecurringEvent Added";	
	echo json_encode($response);
  
	
	}
	else{
		$response->error="Inserting to RecurringEvent table failed";
		echo  json_encode($response);	
	}
}


$conn->close();

?>