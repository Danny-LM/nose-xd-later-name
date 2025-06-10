document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const name = document.getElementById("name").value;
    const pass = document.getElementById("pass").value;

    fetch('login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ name, pass })
    })
    .then(res => res.json())
    .then(data => {
        const divResponse = document.getElementById('response');
        if (data.success) {
            divResponse.innerHTML = `<span style="color:green">${data.message}</span>`;
            setTimeout(() => {
                window.location.href = "dashboard.php";
            }, 5000);
        } else {
            divResponse.innerHTML = `<span style="color:red">${data.message}</span>`;
        }
    })
    .catch(error => {
        console.error('Error processing the request:', error);
        document.getElementById('response').innerHTML = "Connection error with the server.";
    });
});
