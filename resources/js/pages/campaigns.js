const REFRESH_RATE = 8;
    console.log(REFRESH_RATE);
    
    let secondsPassed = 0;
    setInterval(() => {
        secondsPassed++;
        console.log(`Seconds passed: ${secondsPassed}`);
    }, 1000);

    document.addEventListener('DOMContentLoaded', function () {
        let searchValue = '';

        const searchInput = document.querySelector('#search-dropdown');
        searchInput.addEventListener('input', function () {
            searchValue = searchInput.value; 
            filterTable(); 
        });

        // Función para aplicar el filtro
        function filterTable() {
            const rows = document.querySelectorAll('#agent-table tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchValue.toLowerCase())) {
                    row.style.display = ''; // Mostrar fila
                } else {
                    row.style.display = 'none'; // Ocultar fila
                }
            });
        }

        // Refrescar la tabla manteniendo el filtro
        async function loadTableContent() {
            try {
                const response = await fetch('/real-time-table-refresh');
                if (!response.ok) throw new Error('Error al cargar la tabla');
                const tableContent = await response.text();
                document.querySelector('#agent-table').innerHTML = tableContent;

                filterTable();
                console.log('Tabla actualizada');
            } catch (error) {
                console.error('Error al actualizar la tabla:', error);
            }
        }
        async function loadQueueDetail() {
            try {
                const response = await fetch('/real-time-queueDetail-refresh');
                if (!response.ok) throw new Error('Error al cargar los detail queue');
                if (response.ok) {
                    console.log('queueDetail actualizados');
                }
                const iconContent = await response.text(); // Obtén el HTML como texto
                document.querySelector('#queueDetail').innerHTML = iconContent;
            } catch (error) {
                console.error('Error al actualizar los queueDetail:', error);
            }
        }

        async function loadstateInfo() {
            try {
                const response = await fetch('/real-time-stateInfo-refresh');
                if (!response.ok) throw new Error('Error al cargar los  stateInfo');
                if (response.ok) {
                    console.log('stateInfo actualizados');
                }
                const iconContent = await response.text(); // Obtén el HTML como texto
                document.querySelector('#stateInfo').innerHTML = iconContent;
            } catch (error) {
                console.error('Error al actualizar los stateInfo:', error);
            }
        }

    



        function assignCheckboxEvents() {
            const checkboxes = document.querySelectorAll(".campaign-checkbox");
            const campaignElements = document.querySelectorAll(".campaign-item"); // Cambiado a ".campaign-item" para span dinámicos

            // Escucha los cambios en los checkboxes
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener("change", () => {
                    // Obtener todos los IDs activos de las campañas seleccionadas
                    const activeCampaigns = Array.from(checkboxes)
                        .filter(checkbox => checkbox.checked)
                        .flatMap(checkbox => checkbox.dataset.campaigns.split(",").map(Number)); // Convertimos a números

                    // Mostrar/ocultar las campañas dinámicamente
                    campaignElements.forEach(campaignElement => {
                        const campaignId = parseInt(campaignElement.dataset.id, 10); // ID como número
                        if (activeCampaigns.includes(campaignId)) {
                            campaignElement.style.display = "inline-block";
                        } else {
                            campaignElement.style.display = "none";
                        }
                    });
                });
            });

            // Inicializa mostrando todas las campañas
            checkboxes.forEach(checkbox => checkbox.dispatchEvent(new Event("change")));
        }


        // Guarda la selección de los checkboxes
        function saveCheckboxState() {
            const checkboxes = document.querySelectorAll(".campaign-checkbox");
            const selectedCampaigns = [];

            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    selectedCampaigns.push(checkbox.id); // Usa el ID del checkbox como referencia
                }
            });

            // Guarda los IDs de los checkboxes seleccionados en localStorage
            localStorage.setItem("selectedCampaigns", JSON.stringify(selectedCampaigns));
        }

        // Restaura el estado de los checkboxes
        function restoreCheckboxState() {
            const selectedCampaigns = JSON.parse(localStorage.getItem("selectedCampaigns")) || [];

            const checkboxes = document.querySelectorAll(".campaign-checkbox");

            checkboxes.forEach(checkbox => {
                checkbox.checked = selectedCampaigns.includes(checkbox.id);
            });
        }

        // Llama a saveCheckboxState cada vez que cambie un checkbox
        document.querySelectorAll(".campaign-checkbox").forEach(checkbox => {
            checkbox.addEventListener("change", saveCheckboxState);
        });

        // Llama a restoreCheckboxState después de cargar las campañas
        async function loadAllCampaings() {
            try {
                const response = await fetch('/real-time-allCampaings-refresh');
                if (!response.ok) throw new Error('Error al cargar los allCampaings');
                
                // Obtén el HTML del nuevo contenido
                const iconContent = await response.text();
                
                // Reemplaza el contenido del contenedor
                document.querySelector('#allCampaingsRefresh').innerHTML = iconContent;

                console.log('allCampaings actualizados');

                // Restaurar el estado de los checkboxes después de la actualización
                restoreCheckboxState();

                // Reasignar eventos a los nuevos elementos
                assignCheckboxEvents();

                // Aplicar el filtro inicial
                document.querySelectorAll(".campaign-checkbox").forEach(checkbox => {
                    checkbox.dispatchEvent(new Event("change"));
                });
            } catch (error) {
                console.error('Error al actualizar los allCampaings:', error);
            }
        }



        
        function loadContent() {
            loadTableContent();
            loadQueueDetail();
            loadstateInfo();
            loadAllCampaings();
        }

        setInterval(loadContent, REFRESH_RATE * 1000); 
    });