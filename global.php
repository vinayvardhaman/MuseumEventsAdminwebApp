<?php

$server_name="tethys.cse.buffalo.edu";
$schema_name="museum_db";
$schema_username="sajidkha";
$schema_password="ChangeMe";

# strings
$fill_all="Please Fill All The Mandatory Fields";
$multiple_users="Multiple User Entries Found";
$no_user="User Not Found";
$email_sent="An Activation Code Is Sent To You, Check Your Email";
$email_already="An Activation Link Has Already Been Sent To Your Email, Check Your Email";
$insert_fail="Insert failed!";
$delete_fail="Error in deleting record";

# Email configuration
$subject="Activation code for Buffalo Museum App";
$from='vinayvar@buffalo.edu';
$code_size=15;

# Other configuration
$php_server='localhost';

# functions
function userSuccessResponse(&$row, &$response){

        $response->id=intval($row["User_Id"]);
        $response->name=$row["User_Name"];
        $response->email=$row["User_Email"];
        $response->phone=$row["User_Phone"];
        $response->is_member=$row["is_Member"];
        $response->member_id=$row["Member_Id"];

}

?>
