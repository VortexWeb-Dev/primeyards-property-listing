<div id="toast" class="fixed top-4 right-4 px-6 py-3 bg-gray-800 text-white rounded-md shadow-md flex items-center space-x-4 opacity-0 pointer-events-none transition-opacity duration-300">
    <span id="toastMessage" class="text-sm"></span>
    <button id="closeToast" class="text-lg font-bold text-white ml-4">&times;</button>
</div>

<script>
    function getMessageFromURL() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('message'); // Returns the message if it exists
    }

    const toast = document.getElementById('toast');
    const closeButton = document.getElementById('closeToast');
    const toastMessage = document.getElementById('toastMessage');

    window.onload = function() {
        const message = getMessageFromURL(); // Get the message from the URL
        if (message) {
            toastMessage.textContent = message; // Set the toast message
            toast.classList.remove('opacity-0');
            toast.classList.add('opacity-100', 'pointer-events-auto'); // Show toast

            // Automatically close the toast after 5 seconds
            setTimeout(function() {
                toast.classList.remove('opacity-100');
                toast.classList.add('opacity-0', 'pointer-events-none');
            }, 5000);
        } else {
            toast.classList.remove('opacity-100', 'pointer-events-auto');
            toast.classList.add('opacity-0', 'pointer-events-none'); // Keep toast hidden if no message
        }
    };

    // Close toast on manual click
    closeButton.addEventListener('click', function() {
        toast.classList.remove('opacity-100');
        toast.classList.add('opacity-0', 'pointer-events-none');
    });
</script>