
document.addEventListener('DOMContentLoaded', function() {
    const recipientInput = document.getElementById('recipient');
    const nameOptions = document.getElementById('nameOptions'); // Div to display options
    const namesArray = <?php echo json_encode($linkedNames); ?>;

    function updateNameList() {
        const inputValue = recipientInput.value.toLowerCase();
        nameOptions.innerHTML = ''; // Clear existing options

        const matchingNames = namesArray.filter(name => name.toLowerCase().includes(inputValue));

        matchingNames.forEach(name => {
            const option = document.createElement('div');
            option.className = 'option';
            option.textContent = name;
            option.addEventListener('click', function() {
                recipientInput.value = name;
                nameOptions.style.display = 'none';
            });
            nameOptions.appendChild(option);
        });

        // Show or hide the options div based on matches
        nameOptions.style.display = matchingNames.length > 0 ? 'block' : 'none';
    }

    recipientInput.addEventListener('input', updateNameList);

    document.addEventListener('click', function(event) {
        if (!recipientInput.contains(event.target) && !nameOptions.contains(event.target)) {
            nameOptions.style.display = 'none';
        }
    });

    // Trigger the update when the page loads
    updateNameList();
});
