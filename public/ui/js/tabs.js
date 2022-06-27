const buttonsArray = document.querySelectorAll('.tab-nav-button');
const tabs = document.querySelectorAll('.tab');

buttonsArray.forEach((button, index) =>{
    button.addEventListener('click', ()=>{
        buttonsArray.forEach(unclicked =>{
            unclicked.classList.remove('active');
        })
        changeContent(index);
        button.classList.add('active');
    })
})

const changeContent = index =>{
    tabs.forEach(tab=>{
        tab.classList.remove('hidden');
        tab.classList.add('hidden');
    })

    tabs[index].classList.remove('hidden');
}