function check_form() {
    let errors = 0;
    const client = document.querySelector('#client');
    const titre = document.querySelector('#titre');
    const enveloppe = document.querySelector('#enveloppe');
    const taux = document.querySelector('#taux');

    if (client.value === "") {
        document.querySelector('#client_error').classList.remove('titanic');
        errors++;
    } else {
        document.querySelector('#client_error').classList.add('titanic');
    }

    if (titre.value.trim() === "") {
        document.querySelector('#titre_error').classList.remove('titanic');
        errors++;
    } else {
        document.querySelector('#titre_error').classList.add('titanic');
    }

    if (enveloppe.value === "" || enveloppe.value <= 0) {
        document.querySelector('#enveloppe_error').classList.remove('titanic');
        errors++;
    } else {
        document.querySelector('#enveloppe_error').classList.add('titanic');
    }

    if (taux.value === "" || taux.value <= 0) {
        document.querySelector('#taux_error').classList.remove('titanic');
        errors++;
    } else {
        document.querySelector('#taux_error').classList.add('titanic');
    }

    return errors;
}

const f = document.querySelector('#submitform');
const btn = document.querySelector('#submit-btn');
const successMsg = document.querySelector('#success');

if (f) {
    f.addEventListener("submit", function(event) {
        event.preventDefault();

        if (check_form() === 0) {
            btn.classList.add('titanic');
            successMsg.classList.remove('titanic');
            
            f.reset();

            setTimeout(() => {
                window.location.href = "projets.html";
            }, 1200);
        }
    });
}