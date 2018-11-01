<?php
#get_events.php
include 'global.php';

// Create connection
$conn = new mysqli($server_name, $schema_username, $schema_password, $schema_name);
$conn->set_charset("utf8");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM Event_Table";
$sql2 = "SELECT * FROM RecurringEvent_Table";
$result = $conn->query($sql);
$result2 = $conn->query($sql2);
$response = new \stdClass(); 
$response2 = new \stdClass();
saveRecurringResponse($result2, $response2);
eventSuccessResponse($result, $response, $response2);
//echo json_encode($result);
//echo json_encode($result2);
echo json_encode($response); 

function eventSuccessResponse(&$result, &$response, &$response2){
	
        $a=array();
        while($row = $result->fetch_assoc()){

                $event = new \stdClass();
                $event->id=$row["Event_ID"];
                $event->title=$row["Title"];
                $event->short_desc=$row["Short_Description"];
                $event->long_desc=$row["Long_Description"];
                $event->location=$row["Location"];
                $event->start_date=$row["Start_Date"];
                $event->end_date=$row["End_Date"];
                $event->is_member_only=$row["IsMemberOnly"];
				$event->category=$row["Category"];
				$event->start_time=$row["StartTime"];
				$event->end_time=$row["EndTime"];
                $event->send_to_members_only=$row["SendToMembersOnly"];
                $event->is_recurring=$row["IsRecurring"];
		setRecurringResponse($event, $response2);
                $event->photo_url=$row["PhotoURL"];
                $event->ticket_url=$row["TicketURL"];
                $event->more_info_url=$row["MoreInfoURL"];

                array_push($a, $event);
        }

        $response=$a;
}

function saveRecurringResponse(&$result2, &$response2){
	
	$b = array();
	while($row2 = $result2->fetch_assoc()){
		
		$event2 = new \stdClass();
		$event2->id=$row2["Event_ID"];
		$event2->days=$row2["Recurring_Days"];
		$event2->weeks=$row2["Recurring_Weeks"];
		$event2->months=$row2["Recurring_Months"];
		$event2->frequency=$row2["Recurring_Frequency"];
		$event2->end_repeat=$row2["End_Repeat"];
		
		array_push($b, $event2);
	}
	$response2->array = $b;
}

function setRecurringResponse(&$event, &$response2){
	
	$a = $response2->array;
	//echo count($a)."<br>";

	foreach($a as $row){
		if($row->id == $event->id){
			$event->recurring_response=$row;
			break;	
		}
	}
}
 	
$conn->close();

?>	
