async function populateSearchSuggestion(baseURL,search,datalist){

    try
    {
        const hostUrl = baseURL
        const response = await fetch(hostUrl+`/resources/owners?search=${search}`)
        const json = await response.json();

        datalist.innerHTML = ""
        json.data.forEach(owner => {
            const nameOpt = document.createElement("option")
            nameOpt.setAttribute("value",`${owner.first_name} ${owner.last_name}`)
            datalist.appendChild(nameOpt)

        });
    }
    catch (err){
    }

}

async function getInspectionById(baseURL,id){

    try
    {
        const hostUrl = baseURL
        const response = await fetch(hostUrl+`/resources/inspection/${id}`)
        const json = await response.json();
        
        return json.data
    }
    catch (err){
    }

}