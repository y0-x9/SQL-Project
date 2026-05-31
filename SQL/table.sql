CREATE TABLE Passenger (
passenger_id INT PRIMARY KEY,
first_name VARCHAR(50),
last_name VARCHAR(50),
gender VARCHAR(10),
date_of_birth DATE,
phone VARCHAR(20),
email VARCHAR(100) UNIQUE,
passport_no VARCHAR(30) UNIQUE,
nationality VARCHAR(50)
);

CREATE TABLE Airport (
airport_code CHAR(3) PRIMARY KEY,
airport_name VARCHAR(100),
city VARCHAR(50),
country VARCHAR(50)
);

CREATE TABLE Aircraft (
aircraft_id INT PRIMARY KEY,
model VARCHAR(50),
manufacturer VARCHAR(50),
capacity INT,
registration_no VARCHAR(30) UNIQUE,
status VARCHAR(20)
);

CREATE TABLE Flight (
flight_id INT PRIMARY KEY,
flight_no VARCHAR(10),
departure_datetime DATETIME,
arrival_datetime DATETIME,
status VARCHAR(20),
aircraft_id INT DEFAULT NULL,
origin_airport_code CHAR(3) DEFAULT 'DEF',
destination_airport_code CHAR(3) DEFAULT 'DEF',
FOREIGN KEY (aircraft_id) REFERENCES Aircraft(aircraft_id) ON DELETE SET NULL,
FOREIGN KEY (origin_airport_code) REFERENCES Airport(airport_code) ON DELETE SET DEFAULT,
FOREIGN KEY (destination_airport_code) REFERENCES Airport(airport_code) ON DELETE SET DEFAULT
);

CREATE TABLE Seat (
seat_id INT PRIMARY KEY,
seat_number VARCHAR(5),
class_type VARCHAR(20),
availability_status VARCHAR(20),
aircraft_id INT DEFAULT NULL,
FOREIGN KEY (aircraft_id) REFERENCES Aircraft(aircraft_id) ON DELETE SET NULL
);

CREATE TABLE Booking (
booking_id INT PRIMARY KEY,
booking_date DATETIME,
booking_status VARCHAR(20),
total_amount DECIMAL(10,2),
passenger_id INT DEFAULT NULL,
flight_id INT DEFAULT NULL,
seat_id INT DEFAULT NULL,
FOREIGN KEY (passenger_id) REFERENCES Passenger(passenger_id) ON DELETE SET NULL,
FOREIGN KEY (flight_id) REFERENCES Flight(flight_id) ON DELETE SET NULL,
FOREIGN KEY (seat_id) REFERENCES Seat(seat_id) ON DELETE SET NULL,
CONSTRAINT uq_flight_seat UNIQUE (flight_id, seat_id)
);

CREATE TABLE CrewMember (
crew_id INT PRIMARY KEY,
first_name VARCHAR(50),
last_name VARCHAR(50),
role VARCHAR(30),
phone VARCHAR(20),
email VARCHAR(100) UNIQUE,
license_no VARCHAR(50),
status VARCHAR(20)
);

CREATE TABLE FlightCrewAssignment (
assignment_id INT PRIMARY KEY,
flight_id INT DEFAULT NULL,
crew_id INT DEFAULT NULL,
duty_role VARCHAR(30),
FOREIGN KEY (flight_id) REFERENCES Flight(flight_id) ON DELETE SET NULL,
FOREIGN KEY (crew_id) REFERENCES CrewMember(crew_id) ON DELETE SET NULL
);

CREATE TABLE Payment (
payment_id INT PRIMARY KEY,
payment_date DATETIME,
amount DECIMAL(10,2),
payment_method VARCHAR(20),
payment_status VARCHAR(20),
booking_id INT UNIQUE,
FOREIGN KEY (booking_id) REFERENCES Booking(booking_id) ON DELETE CASCADE
);