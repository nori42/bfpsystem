<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>
    @vite('resources/sass/bootstrap.scss')
    @vite('resources/css/pages/attachments.css')
</head>

<body>
    <div class="d-flex justify-content-between pt-3 align-items-center">
        <div>
            @if (count($files) != 0)
                <div class="fs-4 fw-semibold">Firedrill Attachments</div>
                <div class="fs-6 text-secondary">List of firedrill related files</div>
            @endif
        </div>
        <button class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#addAttachmentModal">
            <span class="material-symbols-outlined align-middle">
                attach_file
            </span>
            Add Attachment
        </button>
    </div>
    {{-- Attachments --}}
    <div id="attachments" class="h-75 overflow-y-auto mt-2 border-3">
        @if (count($files) != 0)
            <table class="table table-striped">
                <thead class="sticky-top top bg-white z-0">
                    <th>File</th>
                    <th>File Extension</th>
                    <th>Date Added</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($files as $file)
                        <tr>
                            <td><a href="/download/attachments/{{ $file->file_path }}">{{ $file->file_name }}</a></td>
                            <td>{{ $file->file_extension }}</td>
                            <td>{{ date('m/d/Y', strtotime($file->created_at)) }}</td>
                            <td>
                                <form action="/delete/attachments/{{ $file->file_path }}/{{ $file->id }}"
                                    method="POST">
                                    @csrf
                                    <input type="hidden" name="redirectPath" value={{ request()->path() }}>
                                    <button class="btn btn-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <h2 class="text-center text-secondary">No attachment</h2>
            <div class="text-center text-secondary">Put inspection related files for this establishment here.</div>
        @endif
    </div>

    <div class="modal" id="addAttachmentModal">
        <div class="modal-dialog modal-dialog-centered" style="min-width: 750px;">
            <div class="modal-content py-4 px-5">
                <div class="text-center py-5 d-none" spinner>
                    <div class="spinner-border" role="status" style="width: 3rem; height:3rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div class="text-secondary mt-3 fs-5">
                        Uploading Files...
                    </div>
                </div>

                <div modal-content>
                    <div class="bg-secondary-subtle filelist-container" style="display: none;">
                        <div class="overflow-y-auto pb-0" style="height: 150px;">
                            <ul class="list-unstyled filelist p-3 fw-bold text-center">
                            </ul>
                        </div>
                    </div>
                    <form id="fsic" class="rounded-2 d-flex flex-column justify-content-center gap-3 mx-auto w-100"
                        action="/establishments/attachment/firedrill/{{ $establishment->id }}/upload" method="POST"
                        enctype="multipart/form-data" style="height: 250px;" autocomplete="off">
                        @csrf
                        <div class="h-100 d-flex flex-column gap-3 mt-2">
                            <div class="h-100 position-relative">
                                <div class="fileuploadicon d-flex flex-column text-center p-2 position-absolute h-100 w-100"
                                    style="pointer-events:none;">
                                    <div class="my-auto">
                                        <span class="material-symbols-outlined fs-2">description</span>
                                        <span class="material-symbols-outlined fs-2">image</span>
                                        <span class="material-symbols-outlined fs-2">folder</span>
                                    </div>
                                    <div class="my-auto">
                                        <span>Click or Drag To Upload File(s)</span>
                                    </div>
                                </div>

                                {{-- This is hidden it used for reference --}}
                                {{-- <input class="d-none" id="attachFor" name="attachFor" type="text" value="fsic"/> --}}

                                <input id="fileUpload" name="fileUpload[]" class="btn bg-secondary-subtle h-100"
                                    type="file" value="Add" accept="image/*,.docx,.pdf,.doc,.xlsx,.xls,.txt"
                                    multiple style="width: 100%; opacity: 1%;" />
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button id="submitFile" class="btn btn-primary float-end d-none" type="button"
                            onclick="uploadFile()" value="fsic">Submit
                            Files</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @vite(['resources/js/app.js'])
    <script>
        function uploadFile() {
            document.querySelector('[spinner]').classList.remove('d-none')
            document.querySelector('[modal-content]').classList.add('d-none')
            // Submit the file
            document.querySelector(`#${event.target.value}`).submit();
        }

        fileUpload.addEventListener('change', function() {
            const fileUpload = document.querySelector('#fileUpload')
            const files = fileUpload.files

            document.querySelector('#submitFile').classList.remove('d-none')

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
</body>

</html>
