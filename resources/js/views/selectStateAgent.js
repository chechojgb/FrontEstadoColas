document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("search-dropdown");

    window.filterTable = function(searchText) {
        const tableRows = document.querySelectorAll("table tbody tr"); 

        tableRows.forEach(row => {
            const cells = row.querySelectorAll("td"); 
            let matchFound = false;

            cells.forEach(cell => {
                if (cell.textContent.trim().toLowerCase().includes(searchText.toLowerCase())) {
                    matchFound = true;
                }
            });

            row.style.display = matchFound || searchText === '' ? "" : "none";
        });
    };



    window.initializeEventListeners = function() {
        const buttons = document.querySelectorAll(".state-button");

        // 🔥 Primero, eliminamos cualquier evento existente antes de agregar uno nuevo
        buttons.forEach(button => {
            button.removeEventListener("click", handleStateClick);
            button.addEventListener("click", handleStateClick);
        });

        console.log("Eventos de estado reasignados.");
    };

    document.addEventListener("click", function(event) {
        const button = event.target.closest(".state-button"); 
        if (button) {
            let state = button.getAttribute("data-state");
            if (state === 'Total Agents conected') {  
                searchInput.value = '';
                state = ''; 
                window.filterTable(state); 
                console.log('Filtro limpiado: mostrando todos los agentes.');
            } else {
                searchInput.value = state; 
                window.filterTable(state);
            }
             

            console.log(`Estado seleccionado: ${state}`);
            // window.filterTable(state);
        }
    });

    // function handleStateClick(event) {
    //     let stateAgent = event.currentTarget.getAttribute("data-state");
    
    //     if (stateAgent === 'Total Agents conected') {  
    //         searchInput.value = '';
    //         stateAgent = '';  // ✅ Borra la barra de búsqueda
    //         window.filterTable(stateAgent);  // ✅ Muestra todas las filas
    //         console.log('Filtro limpiado: mostrando todos los agentes.');
    //     } else {
    //         searchInput.value = stateAgent; 
    //         window.filterTable(stateAgent);
    //     }
    
    //     searchInput.focus();
    //     console.log(`Estado seleccionado: ${stateAgent}`);
    // }
    
    
    

    // Asignar eventos al cargar la página
    window.initializeEventListeners();

    searchInput.addEventListener("input", function() {
        window.filterTable(this.value);
    });
});






// document.addEventListener("DOMContentLoaded", function() {
//     const searchInput = document.getElementById("search-dropdown");

//     window.filterTable = function(searchText) {
//         const tableRows = document.querySelectorAll("table tbody tr"); 

//         tableRows.forEach(row => {
//             const cells = row.querySelectorAll("td"); 
//             let matchFound = false;

//             cells.forEach(cell => {
//                 if (cell.textContent.trim().toLowerCase().includes(searchText.toLowerCase())) {
//                     matchFound = true;
//                 }
//             });

//             row.style.display = matchFound || searchText === '' ? "" : "none";
//         });
//     };

//     // 🔥 Event delegation: Captura clics en los botones sin perder eventos después de una actualización
//     document.addEventListener("click", function(event) {
//         const button = event.target.closest(".state-button"); // Verifica si el clic fue en un botón de estado
//         if (button) {
//             const state = button.getAttribute("data-state");
//             searchInput.value = state; 
//             searchInput.focus(); 

//             console.log(`Estado seleccionado: ${state}`);
//             window.filterTable(state);
//         }
//     });

//     searchInput.addEventListener("input", function() {
//         window.filterTable(this.value);
//     });

//     console.log("Eventos de estado asignados con delegación.");
// });
