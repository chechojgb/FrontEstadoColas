export const saveCheckboxState = () => {
    const checkboxes = document.querySelectorAll(".campaign-checkbox");
    const selectedCampaigns = Array.from(checkboxes)
        .filter((checkbox) => checkbox.checked)
        .map((checkbox) => checkbox.id);

    localStorage.setItem("selectedCampaigns", JSON.stringify(selectedCampaigns));
};

export const restoreCheckboxState = () => {
    const selectedCampaigns = JSON.parse(localStorage.getItem("selectedCampaigns")) || [];
    const checkboxes = document.querySelectorAll(".campaign-checkbox");

    checkboxes.forEach((checkbox) => {
        checkbox.checked = selectedCampaigns.includes(checkbox.id);
    });
};
