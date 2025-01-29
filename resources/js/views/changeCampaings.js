const checkboxes = document.querySelectorAll(".campaign-checkbox");
const campaignContainer = document.querySelector("#allCampaingsRefresh");

// Function to initialize the visibility of dynamic elements.
const initializeFilter = () => {
    const campaignElements = campaignContainer.querySelectorAll(".campaign-item");

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener("change", () => {
            const activeCampaigns = Array.from(checkboxes)
                .filter(checkbox => checkbox.checked)
                .flatMap(checkbox => checkbox.dataset.campaigns.split(",").map(Number)); 
   
            campaignElements.forEach(campaignElement => {
                const campaignId = parseInt(campaignElement.dataset.id, 10); 
                if (activeCampaigns.includes(campaignId)) {
                    campaignElement.style.display = "inline-block";
                } else {
                    campaignElement.style.display = "none";
                }
            });
        });
    });
    checkboxes.forEach(checkbox => checkbox.dispatchEvent(new Event("change")));
};

// Rerun filter after refresh
document.addEventListener("DOMContentLoaded", initializeFilter);

