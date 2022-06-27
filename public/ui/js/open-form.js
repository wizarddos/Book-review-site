const button = document.querySelectorAll('.openForm');

button.forEach(button =>{
    button.addEventListener('click', ()=>{
        const properForm = document.querySelector(`#${button.value}`);
        properForm.classList.toggle('hidden')
        ;button.textContent = button.textContent == 'Zmień' ? "Ukryj" : "Zmień"
    })
})