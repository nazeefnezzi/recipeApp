
// selecting the elements.
const readMore = document.querySelector('.ownclass');



//  click event for reasd more
readMore.addEventListener('click', readFull);




// function for expand the cards
function readFull(event) {
    // console.log('readfull');
    const target = event.target;
    //console.log(target);

    const card = document.querySelector('.card');

    if( card.classList[2] === 'owncard' ) {

        card.classList.remove('owncard');
        readMore.innerText= 'read less';

    }else if( card.classList[2] == null ) {

        card.classList.add('owncard');
        readMore.innerText= 'read More';
        

    }

    

}

