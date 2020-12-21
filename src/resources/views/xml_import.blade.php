@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="py-5 text-center">
            <p class="lead">
                Page responsible for importing xml files in "shiporders" and "people" format</p>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.
                <ul>

                    @foreach ($errors as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row g-4">
            <div class="col-md-5 col-lg-5 order-md-last">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Performed or waiting import</span>
                </h4>
                @php
                    $sMessage = "Not file imported!";

                    $aImport = request()->get('aImport');

                    if (isset($aImport)) {
                        $sMessage = "File Imported: {$aImport['file_name']} - {$aImport['size']} bytes";
                    }
                @endphp

                <div class="list-group mb-3">
                    <div class="alert alert-info">
                        {{ $sMessage }}
                    </div>
                </div>

            </div>
            <div class="col-md-5 col-lg-7">
                <h4 class="mb-3">Set the file for import</h4>
                <form method="POST" id="aaa" name="form_send_file" enctype="multipart/form-data"
                      action="{{ route('xml_import') }}">
                    @csrf
                    <div class="my-3">
                        <div class="form-group col-sm-12">
                            <label for="firstName" class="form-label">File:</label>
                            <input type="file" name="file" placeholder="Choose file" id="file">
                            <div class="invalid-feedback">
                                File is required.
                            </div>
                        </div>
                    </div>
                    <div class="my-3">
                        <label for="firstName" class="form-label">
                            Import Way:</label>
                        <div class="form-check">
                            <input id="async" name="async" type="checkbox" class="form-check-input">
                            <label class="form-check-label" for="async">Asynchronous</label>
                        </div>
                    </div>
                    <hr class="my-4">
                    <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                </form>
            </div>
        </div>
        </main>
    </div>

@endsection
