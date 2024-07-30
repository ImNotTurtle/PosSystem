@extends('layout.app')
@section('content')
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                text-align: center;
            }

            .upload-form {
                margin: 20px auto;
                max-width: 300px;
            }

            .upload-form input[type="file"] {
                display: none;
            }

            .upload-form label {
                display: block;
                background-color: #3498db;
                color: #fff;
                padding: 10px;
                cursor: pointer;
                border-radius: 5px;
                transition: background-color 0.3s ease;
            }

            .upload-form label:hover {
                background-color: #2980b9;
            }

            .upload-form input[type="submit"] {
                background-color: #2ecc71;
                color: #fff;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            .upload-form input[type="submit"]:hover {
                background-color: #27ae60;
            }
        </style>
    </head>

    <body>
        <div>
            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                Category Status Import</h1>
        </div>
        <div class="upload-form">
            <form action="{{ route('category_status_import') }}" method="post" enctype="multipart/form-data">
                @csrf
                <label for="fileInput">Chọn tệp:</label>
                <input type="file" id="fileInput" name="file_excel">
                <input type="submit" value="Tải lên">
            </form>
        </div>
    </body>
@endsection
