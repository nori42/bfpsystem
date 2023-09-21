//dropdown sripts

export const closeDropdownOnClick = (ev)=> {
    const dropdowns = document.querySelectorAll(['[dropdown]']);
    
    dropdowns.forEach((dropdown)=>{
        if(dropdown != ev.target.closest(['[dropdown]']))
        dropdown.querySelector(['[dropdown-menu]']).style.display = 'none';
    })
}

export const addEventDropdown = (dropdowns)=> {
    // console.log(dropdowns)
    dropdowns.forEach(dropdown => {
        dropdown.querySelector(['[dropdown-btn']).addEventListener('click',()=>{
            const menu = dropdown.querySelector('[dropdown-menu]')
            if(getComputedStyle(menu).display == 'none')
                menu.style.display = 'block';
            else
                menu.style.display = 'none';
        })
    })
}