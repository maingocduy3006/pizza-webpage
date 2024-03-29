var request = new XMLHttpRequest();

function requestData() {
    "use strict";
    request.open("GET", "KundenStatus.php");
    request.onreadystatechange = processData;
    request.send(null);
}

function processData() {
    "use strict";
    if (request.readyState === XMLHttpRequest.DONE) {
        if (request.status === 200) {
            if (request.responseText !== null) {
                const data = JSON.parse(request.responseText);
                process(data);
            } else {
                console.error("Dokument ist leer");
            }
        } else {
            console.error("Uebertragung fehlgeschlagen");
        }
    }
}

function process(jsonData) {
    "use strict";
    const statusContainer = document.getElementById("status-container");
    // Clear any existing content in the status container
    while (statusContainer.firstChild) {
        statusContainer.removeChild(statusContainer.firstChild);
    }
    // Make h1 for kunde string
    const kunde = document.createElement("h1");
    kunde.textContent = "Kunde";
    statusContainer.appendChild(kunde);
    // Make hr
    const hr = document.createElement("hr");
    statusContainer.appendChild(hr);
    const navbar = document.createElement("div");
    navbar.classList.add("topNav");
    const nav5 = document.createElement("a");
    nav5.textContent = "Uebersicht"; // Updated text to "Uebersicht"
    nav5.href = "Uebersicht.php"; // Updated href to "Uebersicht.php"
    navbar.appendChild(nav5);
    const nav1 = document.createElement("a");
    nav1.textContent = "Bestellung";
    nav1.href = "bestellung.php";
    navbar.appendChild(nav1);
    const nav2 = document.createElement("a");
    nav2.textContent = "Baecker";
    nav2.href = "baecker.php";
    navbar.appendChild(nav2);
    const nav3 = document.createElement("a");
    nav3.textContent = "Fahrer";
    nav3.href = "fahrer.php";
    navbar.appendChild(nav3);
    const nav4 = document.createElement("a");
    nav4.textContent = "Kunde";
    nav4.href = "kunde.php";
    navbar.appendChild(nav4);
    statusContainer.appendChild(navbar);
    // Style navbar
    const nav = document.getElementsByClassName("topNav");
    nav[0].setAttribute("class", "topnav");
    if (jsonData.length === 0) {
        const noPizzaMessage = document.createElement("p");
        noPizzaMessage.textContent = "No pizzas available.";
        statusContainer.appendChild(noPizzaMessage);
        return;
    }
    jsonData.forEach(function(statusObj) {
        // Make fieldset
        const fieldset = document.createElement("fieldset");
        const statusElement = document.createElement("div");
        statusElement.classList.add("status");
        const articleName = document.createElement("p");
        articleName.textContent = "Pizza: " + statusObj.name;
        statusElement.appendChild(articleName);

        for (let i = 0; i < 5; i++) {
            const radio = document.createElement("input");
            radio.type = "radio";
            radio.name = "status_" + statusObj.ordered_article_id;
            radio.value = i;
            radio.disabled = true;
            statusElement.appendChild(radio);
            const label = document.createElement("label");

            if (i === 0) {
                label.textContent = "Bestellt";
            } else if (i === 1) {
                label.textContent = "Im Offen";
            } else if (i === 2) {
                label.textContent = "Fertig";
            } else if (i === 3) {
                label.textContent = "unterwegs";
            } else if (i === 4) {
                label.textContent = "Geliefert";
            }
            statusElement.appendChild(label);
            // Add spacing between radio buttons
            statusElement.appendChild(document.createTextNode(" "));
            // Check the radio button that matches the current status
            if (statusObj.status == i) {
                radio.checked = true;
            }
        }
        // Append the status element to the fieldset
        fieldset.appendChild(statusElement);
        statusContainer.appendChild(fieldset);
    });
}

// Start the polling after the page finishes loading
window.onload = function () {
    requestData();
    setInterval(requestData, 2000);
};
