<?php
require 'sql.php';
header('Content-Type: application/json');
$action = $_GET['action'] ?? '';

switch ($action) {

    // Bookings summary grouped by status
    case 'bookings_by_status':
        echo json_encode($pdo->query("
            SELECT booking_status, COUNT(*) AS total, SUM(total_amount) AS revenue
            FROM Booking GROUP BY booking_status
        ")->fetchAll());
        break;

    // Payments summary grouped by method and status
    case 'payments_summary':
        echo json_encode($pdo->query("
            SELECT payment_method, payment_status, COUNT(*) AS total, SUM(amount) AS total_amount
            FROM Payment GROUP BY payment_method, payment_status
        ")->fetchAll());
        break;

    // Flights grouped by status
    case 'flights_by_status':
        echo json_encode($pdo->query("
            SELECT status, COUNT(*) AS total
            FROM Flight GROUP BY status
        ")->fetchAll());
        break;

    // Aircraft grouped by status
    case 'aircraft_by_status':
        echo json_encode($pdo->query("
            SELECT status, COUNT(*) AS total, SUM(capacity) AS total_capacity
            FROM Aircraft GROUP BY status
        ")->fetchAll());
        break;

    // Crew members grouped by role and status
    case 'crew_by_role':
        echo json_encode($pdo->query("
            SELECT role, status, COUNT(*) AS total
            FROM CrewMember GROUP BY role, status
        ")->fetchAll());
        break;

    // Airports by country
    case 'airports_by_country':
        echo json_encode($pdo->query("
            SELECT country, COUNT(*) AS total
            FROM Airport GROUP BY country ORDER BY total DESC
        ")->fetchAll());
        break;

    // Passengers with bookings above average amount
    case 'top_passengers':
        echo json_encode($pdo->query("
            SELECT P.passenger_id, P.first_name, P.last_name, P.nationality,
                   COUNT(B.booking_id) AS total_bookings,
                   SUM(B.total_amount) AS total_spent
            FROM Passenger P
            LEFT JOIN Booking B ON P.passenger_id = B.passenger_id
            GROUP BY P.passenger_id, P.first_name, P.last_name, P.nationality
            ORDER BY total_spent DESC
        ")->fetchAll());
        break;

    // Flights with date range filter
    case 'flights_by_date':
        $from = $_GET['from'] ?? '2000-01-01';
        $to   = $_GET['to']   ?? '2100-01-01';
        $s = $pdo->prepare("
            SELECT F.flight_no, F.departure_datetime, F.arrival_datetime,
                   F.status, A.model AS aircraft, 
                   F.origin_airport_code AS origin,
                   F.destination_airport_code AS destination
            FROM Flight F
            LEFT JOIN Aircraft A ON F.aircraft_id = A.aircraft_id
            WHERE F.departure_datetime BETWEEN ? AND ?
            ORDER BY F.departure_datetime ASC
        ");
        $s->execute([$from, $to]);
        echo json_encode($s->fetchAll());
        break;

    // Revenue by date range
    case 'revenue_by_date':
        $from = $_GET['from'] ?? '2000-01-01';
        $to   = $_GET['to']   ?? '2100-01-01';
        $s = $pdo->prepare("
            SELECT DATE(payment_date) AS date,
                   COUNT(*) AS total_payments,
                   SUM(amount) AS total_revenue
            FROM Payment
            WHERE payment_date BETWEEN ? AND ?
            GROUP BY DATE(payment_date)
            ORDER BY date ASC
        ");
        $s->execute([$from, $to]);
        echo json_encode($s->fetchAll());
        break;

    // Seats by class and availability
    case 'seats_summary':
        echo json_encode($pdo->query("
            SELECT class_type, availability_status, COUNT(*) AS total
            FROM Seat GROUP BY class_type, availability_status
            ORDER BY class_type
        ")->fetchAll());
        break;

    default:
        echo json_encode(["error" => "Unknown action."]);
}
?>