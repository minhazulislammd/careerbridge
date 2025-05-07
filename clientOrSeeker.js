document.addEventListener('DOMContentLoaded', () => {
    const clientRadio = document.getElementById('client');
    const jobSeekerRadio = document.getElementById('job_seeker');
    const submitBtn = document.getElementById('submit_btn');
    const clientBox = document.getElementById('client_box');
    const jobSeekerBox = document.getElementById('job_seeker_box');

    if (!clientRadio || !jobSeekerRadio || !submitBtn || !clientBox || !jobSeekerBox) {
        console.error("One or more elements are missing!");
        return;
    }

    const updateButtonState = () => {
        if (clientRadio.checked) {
            submitBtn.textContent = 'Join as a Client';
            submitBtn.disabled = false;
            submitBtn.classList.remove('disabled');
            submitBtn.classList.add('enabled');
        } else if (jobSeekerRadio.checked) {
            submitBtn.textContent = 'Apply as a Job Seeker';
            submitBtn.disabled = false;
            submitBtn.classList.remove('disabled');
            submitBtn.classList.add('enabled');
        } else {
            submitBtn.textContent = 'Create Account';
            submitBtn.disabled = true;
            submitBtn.classList.remove('enabled');
            submitBtn.classList.add('disabled');
        }
    };

    const selectOption = (radio, box) => {
        radio.checked = true;
        updateButtonState();
        document.querySelectorAll('.box').forEach(box => box.classList.remove('selected'));
        box.classList.add('selected');
    };

    clientBox.addEventListener('click', () => selectOption(clientRadio, clientBox));
    jobSeekerBox.addEventListener('click', () => selectOption(jobSeekerRadio, jobSeekerBox));

    submitBtn.addEventListener('click', () => {
        if (!submitBtn.disabled) {
            // Determine selected role
            const selectedRole = clientRadio.checked ? 'client' : 'seeker';
            
            // Store the role in sessionStorage and redirect
            sessionStorage.setItem('selectedRole', selectedRole);
            window.location.href = "signup_page.php";
        }
    });

    updateButtonState();
});
