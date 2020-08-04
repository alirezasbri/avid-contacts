<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <title>Add Contact</title>

    @include('layouts.bootstrap')
    <style>
        .avatar-pic {
            width: 300px;
        }
    </style>

</head>
<body style="margin: 30px" class="col-md-5">
<h1>Contact Add Form</h1>
{{--<form action="{{ route('contact.add',$userId) }}" method="post">--}}
{{--{!! csrf_field() !!}--}}
<div class="form-group">
    <label for="name">Name</label>
    <input type="text" name="name" class="form-control" id="name" placeholder="Name">
</div>
<div class="form-group">
    <label for="family">Family</label>
    <input type="text" name="family" class="form-control" id="family" placeholder="Family">
</div>
<div class="form-check">
    <input id="checkbox" class="form-check-input" type="checkbox" value="">
    <label class="form-check-label" for="defaultCheck1">
        به اشتراک گذاشتن
    </label>
</div>

<button style="margin-top: 5px " onclick="savePhonesAndEmails()" class="btn btn-primary">ثبت نهایی</button>

{{--</form>--}}
<hr>
{{--<button class="btn btn-primary" onclick="savePhonesAndEmails()">ثبت شماره و ایمیل</button>--}}

<div class="form-group">
    <label for="phone">Phone Number</label>
    <input type="tel" name="phone" class="form-control" id="phone" placeholder="Phone Number">
    <button style="margin-top: 5px " id="phoneBtn" class="btn btn-danger" onclick="addPhone()">ثبت شماره</button>
</div>
<div id="divPhone"></div>
<div class="form-group">
    <label for="email">Email Address</label>
    <input type="text" name="email" class="form-control" id="email" placeholder="Email Address">
    <button style="margin-top: 5px " id="emailBtn" class="btn btn-danger" onclick="addEmail()">ثبت ایمیل</button>
</div>
<div id="divEmail"></div>

<h3>اضافه کردن عکس پروفایل</h3>
<br>
<div class="row justify-content-center">
    <div class="col-md-8">
        <form id="imageUploadForm" action="javascript:void(0)" enctype="multipart/form-data">
            <div class="file-field">
                <div class="row">
                    <div class=" col-md-8 mb-4">
                        <img id="original" src="" class="z-depth-1-half avatar-pic" alt="">
                        <div class="d-flex justify-content-center mt-3">
                            <div class="btn btn-mdb-color btn-rounded float-left">
                                <input type="file" name="photo_name" id="photo_name" required=""> <br>
                                <button type="submit" class="btn btn-danger d-flex justify-content-center mt-3">
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

</body>

<script type="text/javascript">
    // e.preventDefault();

    function addPhone() {

        let phoneNumber = document.getElementById("phone").value;
        let filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
        if (filter.test(phoneNumber)) {
            let para = document.createElement("input");
            para.setAttribute("name", "phones[]");
            para.setAttribute("value", document.getElementById("phone").value);
            para.innerHTML = document.getElementById("phone").value;
            document.getElementById("phone").value = "";
            document.getElementById("divPhone").appendChild(para);
        } else {
            alert('phone number is invalid!');
        }


    }

    function addEmail() {

        let email = document.getElementById("email").value;
        let filter = /^\S+@\S+\.\S+$/;
        if (filter.test(email)) {
            let para = document.createElement("input");
            para.setAttribute("name", "emails[]");
            para.setAttribute("value", document.getElementById("email").value);
            para.innerHTML = document.getElementById("email").value;
            document.getElementById("email").value = "";
            document.getElementById("divEmail").appendChild(para);
        } else {
            alert('email is invalid!');
        }


    }

    function savePhonesAndEmails() {
        let phones = $("input[name='phones[]']")
            .map(function () {
                return $(this).val();
            }).get();

        let emails = $("input[name='emails[]']")
            .map(function () {
                return $(this).val();
            }).get();

        let name = document.getElementById("name").value;
        let family = document.getElementById("family").value;
        let imageName = document.getElementById("original").alt;
        let checkBox = document.querySelector("#checkbox").checked;

        // alert(imageName);

        let json = {
            name: name,
            family: family,
            phones: phones,
            emails: emails,
            checkBox: checkBox,
            image: imageName
            // _token: $('meta[name="csrf-token"]').attr('content')
        };


        let url = '/user/' + {{$userId}}+'/contact/add';
        // alert({name: name, family: family});

        $.ajaxSetup({

            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }

        });

        $.ajax({
            url: url,
            type: 'POST',
            // data: {name: name, family: family},
            data: json,
            dataType: 'JSON',
            // contentType: 'application/json',
            success: function (data) {
                window.location.href = data.url;
                // alert(data.url.toString())
            },
            error: function (data) {
                alert('error')
            }

        });

    }

    //Upload Image Ajax
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
                url: "{{ route('image.save')}}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    $('#original').attr('src', '/public/image/' + data.photo_name);
                    $('#original').attr('alt', data.photo_name);
                    // $('#thumbImg').attr('src', 'public/thumbnail/' + data.photo_name);
                },

                error: function (data) {
                    console.log(data);
                }

            });


        }));

    });

</script>
