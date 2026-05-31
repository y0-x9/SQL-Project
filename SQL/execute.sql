SELECT 
P.first_name,
P.last_name,
B.booking_status,
B.total_amount
FROM Passenger P
INNER JOIN Booking B
ON P.passenger_id = B.passenger_id;


SELECT 
F.flight_no,
F.status,
B.booking_id
FROM Flight F
LEFT JOIN Booking B
ON F.flight_id = B.flight_id;


SELECT 
B.booking_id,
B.booking_status,
Pay.payment_status
FROM Booking B
RIGHT JOIN Payment Pay
ON B.booking_id = Pay.booking_id;

SELECT 
C.first_name,
C.role,
FCA.flight_id
FROM CrewMember C
LEFT JOIN FlightCrewAssignment FCA
ON C.crew_id = FCA.crew_id

UNION

SELECT 
C.first_name,
C.role,
FCA.flight_id
FROM CrewMember C
RIGHT JOIN FlightCrewAssignment FCA
ON C.crew_id = FCA.crew_id;


SELECT 
booking_status,
COUNT(*) AS total_bookings
FROM Booking
GROUP BY booking_status;

SELECT 
flight_no,
departure_datetime,
status
FROM Flight
ORDER BY departure_datetime ASC;

SELECT 
model,
manufacturer,
capacity
FROM Aircraft
WHERE capacity > 250;

SELECT 
first_name,
last_name
FROM Passenger
WHERE passenger_id IN (
SELECT passenger_id
FROM Booking
WHERE total_amount > (
SELECT AVG(total_amount)
FROM Booking
)
);
SELECT * FROM Seat; ;