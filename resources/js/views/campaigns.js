
const REFRESH_RATE = 8;
console.log(REFRESH_RATE);

// let secondsPassed = 0;
// setInterval(() => {
//     secondsPassed++;
//     console.log(`Seconds passed: ${secondsPassed}`);
// }, 1000);

document.addEventListener('DOMContentLoaded', function () {
    let searchValue = '';

    const searchInput = document.querySelector('#search-dropdown');
    searchInput.addEventListener('input', function () {
        searchValue = searchInput.value; 
        filterTable(); 
    });

    function filterTable() {
        const rows = document.querySelectorAll('#agent-table tr');
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchValue.toLowerCase())) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }


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
            const iconContent = await response.text();
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
            const iconContent = await response.text();
            document.querySelector('#stateInfo').innerHTML = iconContent;
        } catch (error) {
            console.error('Error al actualizar los stateInfo:', error);
        }
    }





    function assignCheckboxEvents() {
        const checkboxes = document.querySelectorAll(".campaign-checkbox");
        const campaignElements = document.querySelectorAll(".campaign-item"); 

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener("change", () => {
                
                const activeCampaigns = Array.from(checkboxes)
                    .filter(checkbox => checkbox.checked)
                    .flatMap(checkbox => checkbox.dataset.campaigns.split(",").map(Number)); // Convert to numbers

                
                campaignElements.forEach(campaignElement => {
                    const campaignId = parseInt(campaignElement.dataset.id, 10); // ID with number
                    if (activeCampaigns.includes(campaignId)) {
                        campaignElement.style.display = "inline-block";
                    } else {
                        campaignElement.style.display = "none";
                    }
                });
            });
        });

       
        checkboxes.forEach(checkbox => checkbox.dispatchEvent(new Event("change")));
    }


    function saveCheckboxState() {
        const checkboxes = document.querySelectorAll(".campaign-checkbox");
        const selectedCampaigns = [];

        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selectedCampaigns.push(checkbox.id); 
            }
        });
        localStorage.setItem("selectedCampaigns", JSON.stringify(selectedCampaigns));
    }


    function restoreCheckboxState() {
        const selectedCampaigns = JSON.parse(localStorage.getItem("selectedCampaigns")) || [];

        const checkboxes = document.querySelectorAll(".campaign-checkbox");

        checkboxes.forEach(checkbox => {
            checkbox.checked = selectedCampaigns.includes(checkbox.id);
        });
    }


    document.querySelectorAll(".campaign-checkbox").forEach(checkbox => {
        checkbox.addEventListener("change", saveCheckboxState);
    });


    let activeModalId = null; 
    let modalOpenedByUser = false; 

    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
        activeModalId = modalId;
        modalOpenedByUser = true;
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        modalOpenedByUser = false;  
    }


    async function loadAllCampaings() {
        try {
            const response = await fetch('/real-time-allCampaings-refresh');
            if (!response.ok) throw new Error('Error al cargar los allCampaings');

            const iconContent = await response.text();
            document.querySelector('#allCampaingsRefresh').innerHTML = iconContent;

            console.log('allCampaings actualizados');
            restoreCheckboxState();
            assignCheckboxEvents();

   
            document.querySelectorAll('button[data-modal-toggle]').forEach(button => {
                button.addEventListener('click', function() {
                    const modalId = button.getAttribute('data-modal-target');
                    openModal(modalId);
                });
            });

            document.querySelectorAll('[data-modal-hide]').forEach(button => {
                button.addEventListener('click', function() {
                    const modalId = button.getAttribute('data-modal-hide');
                    closeModal(modalId); 
                });
            });

            if (activeModalId && modalOpenedByUser) {
                openModal(activeModalId);
            }

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
