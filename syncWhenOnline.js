
// function syncWhenOnline(isArray, storedDataTemp) {

//   if (!isArray) {
//     const storedData = localStorage.getItem(storedDataTemp);
//     if (storedData) {
//       sendData(storedData);
//       localStorage.removeItem(storedDataTemp);
//     }
//   } else {
//     const storedData = JSON.parse(localStorage.getItem(storedDataTemp));
//     if (storedData && storedData.length > 0) {
//       sendData(storedData);
//       localStorage.removeItem(storedDataTemp);
//     }
//   }

// }

// function getParam(param1, param2) {

//   if (navigator.onLine) {
//     syncWhenOnline(param1, param2); // Sync immediately if online
//   }

//   // Run when the browser comes back online
//   window.addEventListener("online", syncWhenOnline(param1, param2));

// }
