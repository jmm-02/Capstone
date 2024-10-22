function initPangkatDropdown() {
  var lupons = luponsArray;
    var pangkatInput = document.getElementById("Pangkat"); // Define pangkatInput here
    var dropdown = document.getElementById("pangkatDropdown");
        pangkatInput.addEventListener("input", function () {
            var inputValue = pangkatInput.value.trim();
            var lastCommaIndex = inputValue.lastIndexOf(",");
            var currentName = inputValue.substring(lastCommaIndex + 1).trim();
            var filteredLupons = lupons.filter(function (lupon) {
                return lupon.toLowerCase().includes(currentName.toLowerCase());
            });

            
            dropdown.innerHTML = "";
            filteredLupons.forEach(function (lupon) {
                var option = document.createElement("div");
                option.textContent = lupon;
                option.className = "dropdown-option";
                option.addEventListener("click", function () {
                    var prefix = inputValue.substring(0, lastCommaIndex + 1);
                    pangkatInput.value = prefix + " " + lupon + ", ";
                    dropdown.innerHTML = "";
                });
                dropdown.appendChild(option);
            });

            
            var inputRect = pangkatInput.getBoundingClientRect();
            dropdown.style.top = inputRect.bottom + "px";
            dropdown.style.left = inputRect.left + "px";
            dropdown.style.width = pangkatInput.offsetWidth + "px";
            dropdown.style.display = "block";
        });

        // Hide the dropdown when clicking outside
        document.addEventListener("click", function (event) {
            if (event.target !== pangkatInput && event.target !== dropdown) {
                dropdown.style.display = "none";
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        initPangkatDropdown();
    });
