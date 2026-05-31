function validatePassengerForm() {
    let id = document.getElementById("passenger_id").value;
    let first = document.getElementById("first_name").value;
    let email = document.getElementById("email").value;

    if (id === "" || first === "" || email === "") {
        alert("Please fill all required fields.");
        return false;
    }

    if (isNaN(id)) {
        alert("Passenger ID must be numeric.");
        return false;
    }

    return true;
}

function confirmDelete() {
    return confirm("Are you sure you want to delete this record?");
}

function searchRecord(entity) {
    let id = document.getElementById("searchBox").value;

    if (id === "") {
        alert("Enter an ID to search");
        return;
    }

    alert("Searching " + entity + " with ID: " + id);
}

let index = 0;

let passengers = [
    {id: 1, name: "Ahmed Ali"},
    {id: 2, name: "Sara Mohamed"},
    {id: 3, name: "John Smith"}
];

function displayRecord() {
    let d = document.getElementById("display");
    if (!d) return;

    d.innerHTML = "ID: " + passengers[index].id + " | Name: " + passengers[index].name;
}

function firstRecord() {
    index = 0;
    displayRecord();
}

function lastRecord() {
    index = passengers.length - 1;
    displayRecord();
}

function nextRecord() {
    if (index < passengers.length - 1) {
        index++;
        displayRecord();
    }
}

function previousRecord() {
    if (index > 0) {
        index--;
        displayRecord();
    }
}

function updateRecord(entity) {
    alert("Update " + entity + " record triggered");
}

function deleteRecord(entity) {
    if (confirmDelete()) {
        alert(entity + " record deleted");
    }
}

function updatePassenger() {
    updateRecord("Passenger");
}

function deletePassenger() {
    deleteRecord("Passenger");
}

function searchPassenger() {
    searchRecord("Passenger");
}