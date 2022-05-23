const filterButton = document.querySelector('#filter');

filterButton.addEventListener('click', e => {
    e.preventDefault();

    const filter = document.querySelector('.filter-conditions');
    const shouldBeFiltered = document.querySelector('[name="isFiltered"]');
    if(filter.classList.contains('hidden')) { 
        filter.classList.remove('hidden');
        shouldBeFiltered.value = 1;
    }else{
        filter.classList.add('hidden');
        shouldBeFiltered.value = 0;
    }

})