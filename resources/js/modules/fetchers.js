export async function loadTableContent() {
    try {
        const response = await fetch('/real-time-table-refresh');
        if (!response.ok) throw new Error("Error al cargar la tabla");
        const tableContent = await response.text();
        document.querySelector("#agent-table").innerHTML = tableContent;
    } catch (error) {
        console.error("Error al actualizar la tabla:", error);
    }
}

export async function loadQueueDetail() {
    try {
        const response = await fetch('/real-time-queueDetail-refresh');
        if (!response.ok) throw new Error("Error al cargar los detail queue");
        const iconContent = await response.text();
        document.querySelector("#queueDetail").innerHTML = iconContent;
    } catch (error) {
        console.error("Error al actualizar los queueDetail:", error);
    }
}

export async function loadstateInfo() {
    try {
        const response = await fetch('/real-time-stateInfo-refresh');
        if (!response.ok) throw new Error("Error al cargar los stateInfo");
        const iconContent = await response.text();
        document.querySelector("#stateInfo").innerHTML = iconContent;
    } catch (error) {
        console.error("Error al actualizar los stateInfo:", error);
    }
}

export async function loadAllCampaings() {
    try {
        const response = await fetch('/real-time-allCampaings-refresh');
        if (!response.ok) throw new Error("Error al cargar los allCampaings");
        const iconContent = await response.text();
        document.querySelector("#allCampaingsRefresh").innerHTML = iconContent;
    } catch (error) {
        console.error("Error al actualizar los allCampaings:", error);
    }
}
