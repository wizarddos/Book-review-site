const stars = document.querySelectorAll('[name="stars"]');


stars.forEach(star => {
    star.addEventListener('change', (e) => {
        e.preventDefault();

        for(let i =0; i < 5; i++){
            const star = stars[i].parentNode.classList;
            star.remove('checked'); 
        }
        
        for(let i =0; i < e.target.value; i++){
            const star = stars[i].parentNode.classList;
            star.add('checked'); 
        }
        
    });
}, false);