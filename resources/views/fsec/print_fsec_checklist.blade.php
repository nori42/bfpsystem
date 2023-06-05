<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="/css/printfsecchecklist.css">
    <link rel="stylesheet" href="/css/googlefonts.css">
</head>

@php
    $person = $buildingPlan->owner->person;
    $corporate = $buildingPlan->owner->corporate;
    $receipt = $buildingPlan->receipt;
    
    if (auth()->user()->type != 'ADMIN') {
        $personnelName = auth()->user()->personnel->person->first_name . ' ' . auth()->user()->personnel->person->last_name;
    }
    
    $evaluator = auth()->user()->type != 'ADMIN' ? $personnelName : 'ADMIN';
    
    //Person Name
    // $middleInitial = $person->middle_name ? $person->middle_name[0] . '.' : '';
    // $personName = $person->first_name . ' ' . $middleInitial . ' ' . $person->last_name . ' ' . $person->suffix;
    // $representative = $person->last_name != null ? $personName : $corporate->corporate_name;
    
    $json = resource_path('json\printSettings.json');
    $jsonData = File::get($json);
    $printSettings = json_decode($jsonData, true);
    ['CityMarshal' => $marshal, 'ChiefFSES' => $chief] = $printSettings['settings'];
@endphp

<body>
    <form id="print" action="/fsecdisapprove/print/{{ $buildingPlan->id }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $evaluator }}" name="evaluator">
    </form>


    <div class="editToolBox">

        {{-- Tool For Debugging --}}
        {{-- <button class="btnTools" id="btnMove" onclick="handleMove(this)">Move</button>
        <button class="btnTools" id="btnEdit" onclick="handleEdit(this)">Add Note</button> --}}
        <button class="btnTools" id="btnCheckmarkAdd" onclick="addCheckmarkEvent(event)">Toggle Checkmark</button>
    </div>

    <div class="nav">
        <a id="back" href="/fsec/{{ $buildingPlan->id }}">
            Back
        </a>
        <button onclick="printOnly()" class="printBtn">
            <div>Print Certificate</div><span class="material-symbols-outlined print-ico"
                style="background-color: #FFC900;">print</span>
        </button>
        <div class="printby">
            <strong>Printing as: </strong> <span>{{ auth()->user()->type }} User</span>
        </div>
    </div>

    <div class="printablePage" page="1">
        {{-- <div data-draggable="true" class="header bold">
            <div>Cebu City Fire Office</div>
            <div>N. Bacalso Avenue, Pahina Central, Cebu City</div>
            <div>Tel. Nos. (032) - 256-0544 / 262-3110</div>
            <div>Email Address: cebucityfsn@yahoo.com</div>
        </div> --}}
        <img class="certificate" src="{{ asset('img/checklist_1.png') }}" alt=""
            style="width: 100%; height: 100%;">
        {{-- 
        <div data-draggable="true" class="date-container bold">
            {{ date('F d, Y') }}
        </div>
        

        <div data-draggable="true" class="rep-name bold">
            <span>{{ $representative }}</span>
        </div>
         --}}
        <div data-draggable="true" id="series-no" class="series-no bold">
            <span>{{ $buildingPlan->series_no }}</span>
        </div>

        <div data-draggable="true" id="evaluator" class="evaluator bold">
            <span>{{ auth()->user()->name }}</span>
        </div>

        <div data-draggable="true" id="estabName" class="establishment-name bold">
            <span>{{ $representative }}</span>
        </div>

        <div data-draggable="true" id="projectTitle" class="project-title bold">
            <span>{{ $buildingPlan->project_title }}</span>
        </div>

        <div data-draggable="true" id="projectTitle" class="date-received bold">
            <span>{{ date('m/d/Y', strtotime($buildingPlan->date_received)) }}</span>
        </div>

        <div data-draggable="true" id="buildingStory" class="building-story bold">
            <span>{{ $buildingPlan->building->building_story }}</span>
        </div>


        <div data-draggable="true" class="address bold">
            <span>{{ $buildingPlan->building->address }}</span>
        </div>
    </div>
    <div class="page-break"></div>
    <div class="printablePage" page="2">
        <img class="certificate" src="{{ asset('img/checklist_2.png') }}" alt=""
            style="width: 100%; height: 100%;">


        <textarea class="deficiency" maxlength="288">
        </textarea>
        <textarea class="deficiency deficiency-right" maxlength="288">
        </textarea>

        <div data-draggable="true" data-editable="false" id="chiefName" class="chiefName bold">{{ $chief }}
        </div>

        <div data-draggable="true" data-editable="false" id="marshalName" class="marshalName bold">{{ $marshal }}
        </div>

        <div data-draggable="true" id="evaluator2" class="evaluator-2 bold">
            <span>{{ auth()->user()->name }}</span>
        </div>

        <div data-draggable="true" class="fc-fee">
            <div id="amount" class="fc-fee-font-size">{{ $receipt->amount }}</div>
            <div id="or_no" class="fc-fee-font-size">{{ $receipt->or_no }}</div>
            <div id="date" class="fc-fee-font-size">{{ date('m/d/Y', strtotime($receipt->date_of_payment)) }}
            </div>
        </div>
    </div>


    <script src="/js/print.js"></script>
    <script>
        function addCheckmark(event) {
            // Do Nothing if the button is clicked
            if (event.target.id == "btnAddCheck" || event.target.id == "btnCancel")
                return;

            if (event.target.hasAttribute('checkmark')) {
                // Remove the clicked checkmark
                event.target.remove();
                return;
            }

            const printables = document.querySelectorAll('.printablePage')

            // Create a new <span> element
            var checkmark = document.createElement('span');

            // Set the inner HTML to display the checkmark symbol (✓)
            checkmark.innerHTML = '&#10003;';

            // Add CSS styles to the checkmark
            checkmark.style.fontSize = '28px';
            checkmark.style.position = 'absolute';
            checkmark.style.cursor = 'cursor';
            checkmark.style.left = (event.offsetX - 6) + 'px';
            checkmark.style.top = (event.offsetY - 10) + 'px';
            checkmark.setAttribute('checkmark', '')
            // Append the checkmark to the body of the document
            try {

                switch (event.target.parentElement.attributes.page.value) {
                    case '1':
                        printables[0].appendChild(checkmark);
                        break;
                    case '2':
                        printables[1].appendChild(checkmark);
                        break;
                }
            } catch (e) {}

        }


        function addCheckmarkEvent(event) {

            if (event.target.innerText === "Toggle Checkmark") {
                document.addEventListener('click', addCheckmark);

                // Change Cursor when hover on page
                document.querySelectorAll(".printablePage")[0].style.cursor = "cell";
                document.querySelectorAll(".printablePage")[1].style.cursor = "cell";
                event.target.innerText = "Cancel"
                event.target.style.backgroundColor = "gray"
            } else {
                document.removeEventListener('click', addCheckmark);
                // Change Cursor when hover on page
                document.querySelectorAll(".printablePage")[0].style.cursor = "default";
                document.querySelectorAll(".printablePage")[1].style.cursor = "default";
                event.target.innerText = "Toggle Checkmark"
                event.target.style.backgroundColor = "#FFC900"
            }
        }

        function cancel() {
            document.removeEventListener('click', addCheckmark)
            document.querySelector("#body").style.cursor = "default";
            console.log("Remove Event Listener")
        }
    </script>
</body>

</html>
