function check_title() {
    const titre = document.querySelector('#titre');
    const titre_error = document.querySelector('#titre_error');

    if (titre.value.trim() === "") {
        titre_error.classList.remove('titanic');
        return 1;
    } 
    titre_error.classList.add('titanic');
    return 0;
}

const f = document.querySelector('#submitform');
const btn = document.querySelector('#submit-btn');
const successMsg = document.querySelector('#success');

if (f) {
    f.addEventListener("submit", function(event) {
        event.preventDefault();

        if (check_title() === 0) {

            btn.classList.add('titanic');
            successMsg.classList.remove('titanic');
            
            f.reset();
            setTimeout(() => {
                window.location.href = "tickets.html";
            }, 1200);
        }
    });
}