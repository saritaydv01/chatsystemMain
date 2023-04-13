<?php
include("dbcon.php");

$function = $_REQUEST;
// echo json_encode($function);
// exit;
if ($function['function'] == 'all_chats') {
    // echo "all_chats";
    $user = "select * from sessions;";
    $result = mysqli_query($conn, $user);

    while ($r = mysqli_fetch_assoc($result)) $rows[] = $r;
    echo json_encode($rows);
    exit;
}

if ($function['function'] == 'open_chat') {
    // echo "open_chats";
    $user = "select * from messages where session_id = '" . $_REQUEST['session_id'] . "'";
    $result = mysqli_query($conn, $user);
    while ($r = mysqli_fetch_assoc($result)) $rows[] = $r;
    echo json_encode($rows);
    exit;
}

if ($function['function'] == 'send_msg') {
    $msg = $function['msg'];
    $session_id = $function['session_id'];

    $query = "select * from sessions where session_id = '$session_id' ";
    $result = mysqli_query($conn, $query);
    while ($r = mysqli_fetch_assoc($result)) $rows[] = $r;

    $sender = $rows[0]['sender'];
    $sender_id = $rows[0]['sender_id'];
    $receiver = $rows[0]['receiver'];
    $receiver_id = $rows[0]['receiver_id'];

     $query = "INSERT INTO `messages`(`session_id`,`sender`,  `sender_id` ,`receiver`, `receiver_id`, `msg`, `is_outgoing`) values ('$session_id','$sender' , '$sender_id' , '$receiver' , '$receiver_id' , '$msg' , '1') ";
    $result = mysqli_query($conn, $query);

    exit;

}
