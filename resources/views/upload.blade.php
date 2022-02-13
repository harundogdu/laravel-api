@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        <form role="form" class="form" onsubmit="return false;">
                            <div class="form-group">
                                <input type="file" name="uploadFile" class="form-control" id="uploadFile">
                            </div>
                            <button id="btnUpload" type="submit" class="btn btn-success mt-2">Upload</button>
                        </form>
                    </div>

                    <div class="card-footer">
                        <div id="output" class="container"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        (function () {
            var output = document.getElementById('output');
            document.getElementById('btnUpload').onclick = function () {
                if (document.getElementById('uploadFile').files.length !== 0) {
                    var formData = new FormData();
                    formData.append('uploadFile', document.getElementById('uploadFile').files[0]);

                    axios.post('/api/upload', formData, {
                        headers: {'Content-Type': 'multipart/form-data'},
                        onUploadProgress: function (progressEvent) {
                            var percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                            output.innerHTML = percentCompleted + '%';
                        }
                    })
                        .then(function (res) {
                            if (res.data.success) {
                                output.className = 'container text-success h4';
                                output.innerHTML = res.data.data;
                                document.getElementById('uploadFile').value = '';
                            }
                        })
                        .catch(function (err) {
                            output.className = 'container text-danger h3';
                            output.innerHTML += "<ul>"
                            for (var key in err.response.data.errors) {
                                for (var i = 0; i < err.response.data.errors[key].length; i++) {
                                    output.innerHTML += "<li>" + err.response.data.errors[key][i] + "</li>";
                                }
                            }
                            output.innerHTML += "</ul>"
                        });
                } else {
                    output.className = 'container text-danger h4';
                    output.innerHTML = 'Please select a file';
                }
            };
        })();
    </script>
@endsection
