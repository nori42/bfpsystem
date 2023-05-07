@props(['for', 'establishment', 'owner', 'files', 'page'])
<x-pageWrapper>

    @if (session('toastMssg'))
        <x-toast :message="session('toastMssg')" />
    @endif
    {{-- Owner Info & Selected Establishment --}}
    <x-headingInfo :establishment="$establishment" :owner="$owner" />

    {{-- FSIC Action --}}
    <div class="d-flex  w-100 mt-3">
        <x-action.link href="/establishments/{{ $establishment->id }}/{{ $for }}" text="{{ $page }}" />
        {{-- <x-action.link href="/establishments/fsic/payment/{{ $establishment->id }}" text="Payment" /> --}}
        <x-action.link href="/establishments/{{ $establishment->id }}/{{ $for }}/attachment/" text="Attachments"
            :active="true" />
    </div>

    <div class="d-flex justify-content-end pt-3">
        <button class="btn btn-success" id="addPaymentBtn" onclick="openModal('addAttachmentModal')">
            <span class="material-symbols-outlined align-middle">
                attach_file
            </span>
            Add Attachment
        </button>
    </div>
    {{-- Attachments --}}
    <div id="attachments" class="h-75 overflow-y-auto mt-4 border-3">
        <table class="table">
            <thead class="sticky-top top bg-white z-0 border-5 border-dark-subtle">
                <th>File</th>
                <th>File Extension</th>
                <th>Date Added</th>
            </thead>
            <tbody>
                @foreach ($files as $file)
                    <tr>
                        <td><a href="/download/attachments/{{ $file->file_path }}">{{ $file->file_name }}</a></td>
                        <td>{{ $file->file_extension }}</td>
                        <td>{{ date('m/d/Y', strtotime($file->created_at)) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- The Modal -->
    {{-- Attachment --}}
    <x-modal id="addAttachmentModal" width="50" topLocation="5">
        <!-- Modal content -->

        <div class="bg-secondary-subtle filelist-container" style="display: none;">
            <div class="overflow-y-auto pb-0" style="height: 150px;">
                <ul class="list-unstyled filelist p-3 fw-bold text-center">
                </ul>
            </div>
            <button id="submitFile" class="btn btn-success float-end" type="button" onclick="uploadFile()"
                value="{{ $for }}">Submit
                Files</button>
        </div>
        <form id="{{ $for }}" class="rounded-2 d-flex flex-column justify-content-center gap-3 mx-auto w-100"
            action="/establishments/attachment/{{ $for }}/{{ $establishment->id }}/upload" method="POST"
            enctype="multipart/form-data" style="height: 250px;">
            @csrf
            <div class="h-100 d-flex flex-column gap-3 mt-2">
                <button id="submitFile" class="btn btn-success ml-auto" type="submit" style="display: none;">Submit
                    Files</button>
                <div class="h-100 position-relative">
                    <div class="fileuploadicon d-flex flex-column text-center p-2 position-absolute h-100 w-100"
                        style="pointer-events:none;">
                        <div class="my-auto">
                            <span class="material-symbols-outlined fs-2">description</span>
                            <span class="material-symbols-outlined fs-2">image</span>
                            <span class="material-symbols-outlined fs-2">folder</span>
                        </div>
                        <div class="my-auto">
                            <span>Click To Upload File(s)</span>
                        </div>
                    </div>

                    {{-- This is hidden it used for reference --}}
                    {{-- <input class="d-none" id="attachFor" name="attachFor" type="text" value="fsic"/> --}}

                    <input id="fileUpload" name="fileUpload[]" class="btn bg-secondary-subtle h-100" type="file"
                        value="Add" accept="image/*,.docx,.pdf,.doc,.xlsx,.xls,.txt" multiple
                        style="width: 100%; opacity: 1%;" />
                </div>
            </div>
        </form>
    </x-modal>
    <x-modal id="modalOwner" width="50" topLocation="5">
        <x-ownerInfo :establishment="$establishment" :owner="$owner" />
    </x-modal>
    </div>
</x-pageWrapper>

<script>
    function uploadFile() {
        const modalContent = document.querySelector('#addAttachmentModal').children[0]
        Array.from(modalContent.children).forEach(element => {
            element.style.opacity = '0%';
            element.style.pointerEvents = 'none';
        });
        // Add the loading screen
        modalContent.insertAdjacentHTML('afterbegin',
            '<div><div class="fw-bold fs-5" id="loading-message">Uploading...</div><div id="loading-bar-spinner" class="spinner"><div class="spinner-icon"></div></div></div>'
        )
        console.log(event.target.value)
        // Submit the file
        document.querySelector(`#${event.target.value}`).submit();
    }

    fileUpload.addEventListener('change', function() {
        const fileUpload = document.querySelector('#fileUpload')
        const files = fileUpload.files

        if (files != null) {
            document.querySelector('.filelist-container').style.display = "block"
            document.querySelector('#submitFile').style.display = "block"

            const filelist = document.querySelector('.filelist')
            filelist.innerHTML = ""

            Array.from(files).forEach(file => {
                const li = document.createElement('li');
                li.textContent = file.name
                filelist.appendChild(li)
            });
        }
    })
</script>
