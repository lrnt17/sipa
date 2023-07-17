var time = {
    updateTimestamps: function(element, timestamp) {
        var postTimestamp = new Date(timestamp); // Convert the timestamp to a JavaScript Date object
        var now = new Date();
        var elapsed = Math.floor((now - postTimestamp) / 1000); // Elapsed time in seconds
    
        /*if (elapsed < 60) {
            element.textContent = 'Just now';
        } else if (elapsed < 3600) {
            var minutes = Math.floor(elapsed / 60);
            element.textContent = minutes + ' minute' + (minutes > 1 ? 's' : '') + ' ago';
        } else {
            element.textContent = postTimestamp.toLocaleString(); // Display the full timestamp
        }*/

        if (elapsed < 60) {
            element.textContent = 'Just now';
        } else if (elapsed < 3600) {
            var minutes = Math.floor(elapsed / 60);
            element.textContent = minutes + ' minute' + (minutes > 1 ? 's' : '') + ' ago';
        } else if (elapsed < 86400) {
            var hours = Math.floor(elapsed / 3600);
            element.textContent = hours + ' hour' + (hours > 1 ? 's' : '') + ' ago';
        } else if (elapsed < 604800) {
            var days = Math.floor(elapsed / 86400);
            element.textContent = days + ' day' + (days > 1 ? 's' : '') + ' ago';
        } else if (elapsed < 2592000) {
            var weeks = Math.floor(elapsed / 604800);
            element.textContent = weeks + ' week' + (weeks > 1 ? 's' : '') + ' ago';
        } else if (elapsed < 31536000) {
            var months = Math.floor(elapsed / 2592000);
            element.textContent = months + ' month' + (months > 1 ? 's' : '') + ' ago';
        } else {
            var years = Math.floor(elapsed / 31536000);
            element.textContent = years + ' year' + (years > 1 ? 's' : '') + ' ago';
        }
    },
    
}; 