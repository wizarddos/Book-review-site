const rejectBook = document.querySelectorAll('.button-danger');

rejectBook.forEach(el =>{
    el.addEventListener('click', ()=>{
        const reqBody = {
            method:'POST',
            body: JSON.stringify({bookID: el.id, action: 'deleteRequestedBook'})
        }

        fetch(`http://${window.location.host}/books-site/src/api/adminController.php`, reqBody)
        .then(res => res.json())
        .then(result => {
            window.location.reload()
        })
        .catch(err =>{
            alert('Coś Poszło nie tak')
        })
    })
})