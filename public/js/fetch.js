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

async function populateEstablSearchSuggestion(baseURL,search,datalist){

    try
    {
        const hostUrl = baseURL
        const response = await fetch(hostUrl+`/resources/establishments?search=${search}`)
        const json = await response.json();
        
        datalist.innerHTML = ""
        json.data.forEach((establishment )=> {

            const nameOpt = document.createElement("option")
            const representative = establishment.last_name ? `${establishment.first_name} ${establishment.last_name}` : establishment.corporate_name 
            console.log(representative)
            nameOpt.setAttribute("value",`${establishment.business_permit_no ? establishment.business_permit_no +'-':''}${establishment.establishment_name}-${representative}-${establishment.id}`)
            datalist.appendChild(nameOpt)
            
        });

    }
    catch (err){
        console.log(err)
    }

}

async function populateBuildPlanSearchSuggestion(baseURL,search,datalist,inputId = null){

    try
    {
        const hostUrl = baseURL
        const response = await fetch(hostUrl+`/resources/buildingplans?search=${search}`)
        const json = await response.json();
        
        console.log(json.data)
        datalist.innerHTML = ""
        json.data.forEach(buildingPlan => {
            if(inputId != null && index == 0)
            inputId.value = buildingPlan.id;

            const nameOpt = document.createElement("option")
            nameOpt.setAttribute("value",`${buildingPlan.name != " "? buildingPlan.name:buildingPlan.corporate_name}-${buildingPlan.status}-${buildingPlan.id}`)
            datalist.appendChild(nameOpt)
        });

    }
    catch (err){
    }

}