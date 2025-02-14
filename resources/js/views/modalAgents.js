document.addEventListener("DOMContentLoaded", function () {
    // Función para crear el modal dinámicamente
    function createModal(agentName, agentExtension) {
        let modal = document.querySelector("#agentModal");
        if (!modal) {
            modal = document.createElement("div");
            modal.id = "agentModal";
            modal.className = "fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden";
            modal.innerHTML = `
                <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
                    <h2 class="text-xl font-bold mb-4">Editar Agente</h2>
                    <p><strong>Nombre:</strong> <span id="modalAgentName"></span></p>
                    <p><strong>Extensión:</strong> <span id="modalAgentExtension"></span></p>
                    <button id="closeModal" class="bg-[#00acc1] hover:bg-[#00b7c1] text-white font-bold py-2 px-6 rounded-lg shadow-lg mt-2">Cerrar</button>
                </div>
            `;
            document.body.appendChild(modal);
        }
        
        // Actualizar la información del modal
        document.querySelector("#modalAgentName").textContent = agentName;
        document.querySelector("#modalAgentExtension").textContent = agentExtension;
        
        // Mostrar el modal
        modal.classList.remove("hidden");
    }
    
    // Función para cerrar el modal
    function closeModal() {
        let modal = document.querySelector("#agentModal");
        if (modal) {
            modal.classList.add("hidden");
        }
    }
    
    // Delegación de eventos para capturar clicks en botones de edición
    document.querySelector("#agent-table").addEventListener("click", function (event) {
        let button = event.target.closest("button");
        if (button && button.querySelector("img").alt.startsWith("editAgent")) {
            let row = button.closest("tr");
            let agentName = row.children[1].textContent.trim();
            let agentExtension = row.children[0].textContent.trim();
            createModal(agentName, agentExtension);
        }
    });

    // Delegación de eventos para cerrar el modal
    document.body.addEventListener("click", function (event) {
        if (event.target.id === "closeModal" || event.target.id === "agentModal") {
            closeModal();
        }
    });
});
