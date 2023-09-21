    
    const searchInput = document.querySelector('#search');
    const datalist = document.querySelector('#searchSuggestion')
    const typingDelay = 350; //Add a delay so that it will not request every stroke
    const baseURL = APP_URL;

    let typingTimer;
    let searchController;

    async function populateEstablSearchSuggestion(baseURL, search, datalist) {

        try {
            clearTimeout(typingTimer);

            typingTimer = setTimeout(async () => {

                if (searchController) {
                    // If there's an ongoing fetch, abort it
                    searchController.abort();
                }

                searchController = new AbortController();
                const signal = searchController.signal;

                const hostUrl = baseURL
                const response = await fetch(hostUrl + `/resources/establishments?search=${search}`, {
                    signal
                })
                const json = await response.json();
                const result = [];


                datalist.innerHTML = ""

                if (json.data != null) {
                    json.data.forEach((establishment) => {

                        // const nameOpt = document.createElement("option")
                        const representative = establishment.last_name ?
                            `${establishment.first_name} ${establishment.last_name}` :
                            establishment.corporate_name

                        // nameOpt.setAttribute("value",`${establishment.business_permit_no ? establishment.business_permit_no +'-':''}${establishment.establishment_name}-${representative}-${establishment.id}`)
                        // datalist.appendChild(nameOpt)

                        // result.push(`${establishment.business_permit_no ? establishment.business_permit_no +'-':''}${establishment.establishment_name}-${representative}-${establishment.id}`)

                        const text =
                            `${establishment.business_permit_no ? establishment.business_permit_no +'-':''}${establishment.establishment_name}-${representative}`

                        result.push({
                            dataId: establishment.id,
                            text
                        })
                    });

                    showAutocomplete(result)
                }

            }, typingDelay)
        } catch (err) {
            console.log(err)
        }

    }

    searchInput.addEventListener('input', (e) => {
        selectedIndex = -1;
        if (e.target.value.length != 0) {
            populateEstablSearchSuggestion(baseURL, e.target.value, datalist);
        } else {
            hideAutocomplete();
        }
    })