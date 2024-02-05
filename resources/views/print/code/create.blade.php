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
    <div class="container-fluid">
        <div class="row justify-content-md-center">
            <div class="col-md-9">
                <div class="card px-5 mt-3 shadow">
                    <h1 class="text-primary pt-4 text-center mb-4">Generate Barcode </h1>

                    <form action="/post" method="post">

                        @csrf
                        <label for="">Title :</label>
                        <input type="text" class="form-control mb-3" name="title" id="">

                        <label for="">Description:</label>
                        <textarea name="description" class="form-control mb-3" cols="30" rows="5"></textarea>

                        <button type="submit" class="btn btn-success col-md-3">Submit</button><br>

                    </form>
                </div>
            </div>
        </div>

    </div>
</body>
</html>
