<?php
session_start();
require_once('connection.php');
if (
    empty($_POST['flight_code']) || empty($_POST['departure_date'])
    || empty($_POST['eco_price']) || empty($_POST['bus_price'])
    || empty($_POST['eco_seat']) || empty($_POST['bus_seat'])
) {
    $_SESSION['res_add_state'] = "Vui lòng nhập đầy đủ thông tin";
    header("Location: ../admin/manage_ticket.php");
    exit();
}

$ticket_id = $_POST['ticket_id'];
$flight_code = $_POST['flight_code'];
$departure_date = $_POST['departure_date'];
$eco_price = $_POST['eco_price'];
$bus_price = $_POST['bus_price'];
$eco_seat = $_POST['eco_seat'];
$bus_seat = $_POST['bus_seat'];

// add ticket
$sql = 'UPDATE ticket set FlightCode =?, DepartureDate=?,EcoPrice=?, BusPrice=?, 
AvailEcoSeat=?, AvailBusSeat=? where TicketID=?';

try {
    $stmt = $dbCon->prepare($sql);
    $stmt->execute(
        array(
            $flight_code,
            $departure_date,
            $eco_price
            ,
            $bus_price,
            $eco_seat,
            $bus_seat,
            $ticket_id
        )
    );
    $_SESSION['res_add_state'] = "Chỉnh sửa vé thành công";
    header("Location: ../admin/manage_ticket.php");
    exit();
} catch (PDOException $ex) {
    die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
}
?>