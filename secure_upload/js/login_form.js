document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById('form');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const email = document.getElementById('text').value;
        const password = document.getElementById('password').value;

        try {
            const response = await fetch('login_process.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email: email, password: password })
            });

            const data = await response.json();

            if (data.success) {
                alert(data.message);
                window.location.href = "upload_form.php";
            } else {
                alert(data.message);
            }
        } catch (err) {
            console.error('Error:', err);
            alert("Something went wrong. Please try again.");
        }
    });
});
