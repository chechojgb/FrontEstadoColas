function saveSortStateToBackend(column, order) {
    fetch('/save-sort-state', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ column: column, order: order })
    }).catch(error => console.error("Error al guardar estado de ordenación:", error));
}

window.sortTableByTime = function(columnIndex, toggleOrder = true) {
    if (toggleOrder) {
        window.lastSortOrder = window.lastSortOrder === "asc" ? "desc" : "asc";
        localStorage.setItem("lastSortOrder", window.lastSortOrder);
    }

    localStorage.setItem("lastSortedColumn", columnIndex);
    localStorage.setItem("lastSortedType", "time");

    saveSortStateToBackend(columnIndex, window.lastSortOrder);

    let tableBody = document.getElementById("agent-table");
    if (!tableBody) return;

    let rows = Array.from(tableBody.getElementsByTagName("tr"));

    // **RESET** Todas las flechas antes de cambiar la actual
    document.querySelectorAll('.sort-arrow').forEach(arrow => {
        arrow.src = "/images/uptable.svg"; // Todas las flechas vuelven a su estado inicial
    });

    // **Actualizar solo la flecha de la columna seleccionada**
    let arrow = document.getElementById("arrow-time");
    if (arrow) {
        arrow.src = window.lastSortOrder === "asc" ? "/images/uptable.svg" : "/images/downtable.svg";
    }

    rows.sort((a, b) => {
        let timeA = a.getElementsByTagName("td")[columnIndex]?.innerText.trim() || "NA";
        let timeB = b.getElementsByTagName("td")[columnIndex]?.innerText.trim() || "NA";

        function timeToSeconds(time) {
            if (time === "NA") return -1;
            let parts = time.split(":").map(Number);
            return parts[0] * 3600 + parts[1] * 60 + parts[2];
        }

        let secondsA = timeToSeconds(timeA);
        let secondsB = timeToSeconds(timeB);

        return window.lastSortOrder === "asc" ? secondsA - secondsB : secondsB - secondsA;
    });

    tableBody.innerHTML = "";
    rows.forEach(row => tableBody.appendChild(row));
};


window.sortTable = function(columnIndex, type, toggleOrder = true) {
    if (toggleOrder) {
        window.lastSortOrder = window.lastSortOrder === "asc" ? "desc" : "asc";
        localStorage.setItem("lastSortOrder", window.lastSortOrder);
    }

    localStorage.setItem("lastSortedColumn", columnIndex);
    localStorage.setItem("lastSortedType", type);

    saveSortStateToBackend(columnIndex, window.lastSortOrder);

    let tableBody = document.getElementById("agent-table");
    if (!tableBody) return;

    let rows = Array.from(tableBody.getElementsByTagName("tr"));

    // **RESET** Todas las flechas antes de cambiar la actual
    document.querySelectorAll('.sort-arrow').forEach(arrow => {
        arrow.src = "/images/uptable.svg"; // Todas las flechas vuelven a su estado inicial
    });

    // **Actualizar solo la flecha de la columna seleccionada**
    let arrow = document.getElementById(`arrow-${type}`);
    if (arrow) {
        arrow.src = window.lastSortOrder === "asc" ? "/images/uptable.svg" : "/images/downtable.svg";
    }

    const orderCallState = ["Call in progress", "Call finished", "In transfer"];
    const orderState = ["Busy", "On Hold", "In Call", "Not in use", "Ringing"];

    let orderList = type === "call_state" ? orderCallState : orderState;

    rows.sort((a, b) => {
        let cellA = a.getElementsByTagName("td")[columnIndex]?.innerText.trim() || "";
        let cellB = b.getElementsByTagName("td")[columnIndex]?.innerText.trim() || "";

        let indexA = orderList.indexOf(cellA);
        let indexB = orderList.indexOf(cellB);

        indexA = indexA === -1 ? orderList.length : indexA;
        indexB = indexB === -1 ? orderList.length : indexB;

        return window.lastSortOrder === "asc" ? indexA - indexB : indexB - indexA;
    });

    tableBody.innerHTML = "";
    rows.forEach(row => tableBody.appendChild(row));
};


window.restoreSorting = function() {
    let columnIndex = localStorage.getItem("lastSortedColumn");
    let order = localStorage.getItem("lastSortOrder");
    let type = localStorage.getItem("lastSortedType");

    if (!columnIndex || !order || !type) return;

    columnIndex = parseInt(columnIndex);

    console.log(`Restaurando orden en columna ${columnIndex} con orden ${order} y tipo ${type}`);

    window.lastSortedColumn = columnIndex;
    window.lastSortOrder = order;

    if (type === "time") {
        window.sortTableByTime(columnIndex, false);
    } else if (type === "call_state" || type === "state") {
        window.sortTable(columnIndex, type, false);
    }
};
