<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laravel Generate Barcode Examples</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>
    <div class="container">
        <div class="row justify-content-md-center">
            <h1 class="text-danger pt-4 text-center mb-4">List of product</h1>
            <hr>
            <div class="pb-2">
                <a href="/create" class="btn btn-success">new post</a>

                <div>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Title</th>
                                <th scope="col">QrCode</th>
                                <th scope="col">Description</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($codes as $code)
                            <tr>
                                <th>{{ $code->id }}</th>
                                <th>{{ $code->title }}</th>
                                <th>{!! DNS2D::getBarcodeHTML("$code->qr_code",'QRCODE') !!}  </th>
                                <th>{{ $code->description }}</th>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
