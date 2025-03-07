// const REFRESH_RATE = 60;

// document.addEventListener('DOMContentLoaded', function () {

//     function addToast(user, time) {
//         let container = document.getElementById("toast-container");

//         let toast = document.createElement("div");
//         toast.className = "toast flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-800 justify-end";
//         toast.innerHTML = `
//             <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-orange-500 bg-orange-100 rounded-lg dark:bg-orange-700 dark:text-orange-200">
//                 <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
//                     <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/>
//                 </svg>
//             </div>
//             <div class="ms-3 text-sm font-normal">El usuario <strong>${user}</strong> lleva <strong>${time}</strong> en gestión.</div>
//             <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" onclick="closeToast(this)">
//                 <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
//                     <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
//                 </svg>
//             </button>
//         `;

//         container.appendChild(toast);

//         //DELETE
//         setTimeout(() => toast.remove(), 5000);
//     }

//     function closeToast(button) {
//         let toast = button.parentElement;
//         toast.classList.add('opacity-0', 'transition-opacity', 'duration-500');
//         setTimeout(() => toast.remove(), 500);
//     }

//     function loadContent() {
//         fetch('/real-time-agent-data')  
//             .then(response => response.json()) 
//             .then(data => {
//                 data.forEach(agent => {
//                     let duration2 = agent.duration2 || "00:00:00";
//                     let timeInSeconds = new Date("1970-01-01T" + duration2 + "Z").getTime() / 1000;
    
//                     if (timeInSeconds > 600) {
//                         addToast(agent.name, agent.duration2);
//                     }
//                 });
//             })
//             .catch(error => console.error("Error al cargar los datos:", error));
//     }
    

//     // Cargar la información cada minuto
//     setInterval(loadContent, REFRESH_RATE * 1000);
// });


