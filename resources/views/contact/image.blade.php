<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--    <title>Laravel Ajax Image Upload Using Intervention Package Example - Tutsmake.com</title>--}}
    {{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css"/>--}}
    {{--    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>--}}
    @include('layouts.bootstrap')
    <style>
        .avatar-pic {
            width: 300px;
        }
    </style>
</head>
<body>
<div class="container">
    <br>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form id="imageUploadForm" action="javascript:void(0)" enctype="multipart/form-data">
                <div class="file-field">
                    <div class="row">
                        <div class=" col-md-8 mb-4">
                            <img id="original" src="" class=" z-depth-1-half avatar-pic" alt="">
                            <div class="d-flex justify-content-center mt-3">
                                <div class="btn btn-mdb-color btn-rounded float-left">
                                    <input type="file" name="photo_name" id="photo_name" required=""> <br>
                                    <button type="submit" class="btn btn-secondary d-flex justify-content-center mt-3">
                                        ثبت عکس
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class=" col-md-4 mb-4">
                            <img id="thumbImg" src="" class=" z-depth-1-half thumb-pic"
                                 alt="">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

</body>

<script>

    $(document).ready(function (e) {

        $('#imageUploadForm').on('submit', (function (e) {

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });

            e.preventDefault();

            let formData = new FormData(this);


            $.ajax({

                type: 'POST',

                url: "{{ url('save')}}",

                data: formData,

                cache: false,

                contentType: false,

                processData: false,

                success: function (data) {

                    $('#original').attr('src', 'public/image/' + data.photo_name);

                    // $('#thumbImg').attr('src', 'public/thumbnail/' + data.photo_name);

                },

                error: function (data) {

                    console.log(data);

                }

            });

        }));

    });

</script>


</html>
