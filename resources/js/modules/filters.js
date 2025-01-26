export const initializeFilter = () => {
    const checkboxes = document.querySelectorAll(".campaign-checkbox");
    const campaignContainer = document.querySelector("#allCampaingsRefresh");
    const campaignElements = campaignContainer.querySelectorAll(".campaign-item");

    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", () => {
            const activeCampaigns = Array.from(checkboxes)
                .filter((checkbox) => checkbox.checked)
                .flatMap((checkbox) => checkbox.dataset.campaigns.split(",").map(Number));

            campaignElements.forEach((campaignElement) => {
                const campaignId = parseInt(campaignElement.dataset.id, 10);
                campaignElement.style.display = activeCampaigns.includes(campaignId) ? "inline-block" : "none";
            });
        });
    });

    checkboxes.forEach((checkbox) => checkbox.dispatchEvent(new Event("change")));
};

export const assignCheckboxEvents = () => {
    const checkboxes = document.querySelectorAll(".campaign-checkbox");
    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", () => {
            initializeFilter();
        });
    });
};
