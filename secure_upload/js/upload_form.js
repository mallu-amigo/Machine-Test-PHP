document.getElementById('uploadForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const fileInput = document.getElementById('fileInput');
    if (!fileInput.files.length) return alert('Please select a file.');

    const formData = new FormData();
    formData.append('file', fileInput.files[0]);

    try {
        const response = await fetch('upload_process.php', {
            method: 'POST',
            body: formData
        });

        const contentType = response.headers.get('content-type') || '';
        const text = await response.text();

        // Try to parse JSON if server returned JSON, otherwise handle raw text
        let data;
        if (contentType.includes('application/json')) {
            try {
                data = JSON.parse(text);
            } catch (parseErr) {
                console.error('Failed to parse JSON response:', parseErr, 'raw response:', text);
                throw new Error('Invalid JSON returned from server.');
            }
        } else {
            // Server returned non-JSON (HTML/plain text) — log it for debugging and show to user
            console.warn('Non-JSON response from server:', text);
            if (!response.ok) {
                throw new Error(`Upload failed: ${response.status} ${response.statusText}`);
            }
            alert(text);
            if (response.ok) fileInput.value = '';
            return;
        }

        if (!response.ok) {
            console.error('Server error response:', response.status, response.statusText, data);
            throw new Error(data.message || 'Server returned an error.');
        }

        alert(data.message || 'Upload completed.');
        if (data.success) fileInput.value = '';
    } catch (err) {
        console.error('Upload error:', err);
        alert("Something went wrong. Please try again. See console for details.");
    }
});
