document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById('form');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const email = document.getElementById('text').value;
        const password = document.getElementById('password').value;

        if (!email || !password) {
            alert("Please enter both email and password");
            return;
        }

        try {
            const response = await fetch('signup_process.php', {
                method: "POST",
                headers: { 'Content-Type': 'application/json' }, 
                body: JSON.stringify({ email: email, password: password })
            });

            const data = await response.json();

            if (data.success) {
                alert(data.message); // show signup success
                form.reset();       // clear form
                window.location.href = "login_form.php"; // redirect to login page
            } else {
                alert(data.message);
                form.reset(); 
                window.location.href = "login_form.php"
            }

        } catch (err) {
            console.error('Error:', err);
            alert("Something went wrong. Please try again.");
        }
    });
});
