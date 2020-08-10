<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <title>Edit Contact</title>

    @include('layouts.bootstrap')

    <style>
        .avatar-pic {
            width: 300px;
        }
    </style>
</head>
<body style="margin: 30px" class="col-md-5">

<h1>Contact Edit Form</h1>

<div id="div" class="alert alert-danger" style="display: none">

</div>

<div class="form-group">
    <label for="name">Name</label>
    <input type="text" name="name" class="form-control" id="name" placeholder="Name"
           value="{{$contact->name}}">
</div>
<div class="form-group">
    <label for="family">Family</label>
    <input type="text" name="family" class="form-control" id="family" placeholder="Family"
           value="{{$contact->family}}">
</div>

<div class="form-check">
    @if($contact->type == 'shared')
        <input id="checkbox" class="form-check-input" type="checkbox" value="" checked>
    @else
        <input id="checkbox" class="form-check-input" type="checkbox" value="">
    @endif
    <label class="form-check-label" for="checkbox">
        به اشتراک گذاشتن
    </label>
</div>

<button onclick="savePhonesAndEmails()" class="btn btn-primary">Submit</button>
<div class="form-group">
    <label for="phone">Phone Number</label>
    <input type="tel" name="phone" class="form-control" id="phone" placeholder="Phone Number">

    <label for="types">نوع شماره:</label>
    <select name="types" id="types">
        <option value="mobile">موبایل</option>
        <option value="phone">ثابت</option>
    </select>

    <button id="phoneBtn" class="btn btn-danger" onclick="addPhone()">ثبت شماره</button>
</div>
<div id="divPhone"></div>
<div class="form-group">
    <label for="email">Email Address</label>
    <input type="text" name="email" class="form-control" id="email" placeholder="Email Address">
    <button id="emailBtn" class="btn btn-danger" onclick="addEmail()">ثبت ایمیل</button>
</div>
<div id="divEmail"></div>


<table class="table">
    @foreach($phoneNumbers as $pn)
        <tr>
            <td>{{$pn->phone_number}}
            </td>
            <td> {{$pn->type}}</td>
            <td>
                <button id="del" onclick="deleteFunc({{$pn->id}})">حذف</button>
            </td>
        </tr>
    @endforeach
</table>

<table class="table">
    @foreach($emails as $email)
        <tr>
            <td>{{$email->email_address}}
            </td>

            <td>
                <button id="del" onclick="deleteFuncEmail({{$email->id}})">حذف</button>
            </td>
        </tr>
    @endforeach
</table>

<h3>عکس پروفایل</h3>
<br>
<div class="row justify-content-center">
    <div class="col-md-8">
        <form id="imageUploadForm" action="javascript:void(0)" enctype="multipart/form-data">
            <div class="file-field">
                <div class="row">
                    <div class=" col-md-8 mb-4">
                        @php
                            $value = isset($contact->image) ? $contact->image->image : null;
                        @endphp
                        @isset($value)

                            <img id="original" src="{{'/public/image/'. $value  }}" class="z-depth-1-half avatar-pic"
                                 alt="{{$value}}">
                            <button id="delImage" onclick="deleteImage()">حذف</button>

                        @else
                            <img id="original" src="" class="z-depth-1-half avatar-pic" alt="">
                        @endif
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

<script type="text/javascript">

    function deleteFunc(pnId) {
        let url = "/phonenumber/delete/" + pnId;
        $.ajax({
            url: url,
            type: 'GET',
            success: function (res) {
                location.reload();
            },
            fail: function (xhr, textStatus, errorThrown) {
            }
        });
    }

    function deleteFuncEmail(eId) {
        let url = "/email/delete/" + eId;
        $.ajax({
            url: url,
            type: 'GET',
            success: function (res) {
                location.reload();
            },
            fail: function (xhr, textStatus, errorThrown) {
            }
        });
    }

    function deleteImage() {
        document.getElementById("original").src = "";
        document.getElementById("delImage").style.display = "none";
    }


    function addPhone() {

        let phoneNumber = document.getElementById("phone").value;
        let filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
        if (filter.test(phoneNumber)) {
            let para = document.createElement("input");
            para.setAttribute("name", "phones[]");
            para.setAttribute("value", document.getElementById("phone").value);
            para.setAttribute("alt", document.getElementById("types").value);
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
        let phones = '';
        let emails = '';
        let types = [];

        phones = $("input[name='phones[]']")
            .map(function () {
                return $(this).val();
            }).get();

        emails = $("input[name='emails[]']")
            .map(function () {
                return $(this).val();
            }).get();

        let els = document.querySelectorAll('input');

        for (let i = 0; i < els.length; i++) {
            if (els[i].name.indexOf("phones") > -1) {
                types.push(els[i].alt);
            }
        }

        let name = document.getElementById("name").value;
        let family = document.getElementById("family").value;
        let imageName = document.getElementById("original").alt;
        let checkBox = document.querySelector("#checkbox").checked;

        let json = {
            name: name,
            family: family,
            phones: phones,
            types: types,
            emails: emails,
            checkBox: checkBox,
            image: imageName
        };


        let url = '/contact/edit/' + {{$contact->id}} +'';

        $.ajaxSetup({

            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }

        });

        $.ajax({
            url: url,
            type: 'POST',
            data: json,
            dataType: 'JSON',
            success: function (data) {
                window.location.href = data.url;
            },
            error: function (data) {

                let response = JSON.parse(data.responseText);
                let errorString = '<ul>';
                $.each(response.errors, function (key, value) {
                    errorString += '<li>' + value + '</li>';
                });
                errorString += '</ul>';

                $('#div').html(errorString);
                $('#div').show();
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
                },

                error: function (data) {
                    console.log(data);
                }

            });


        }));

    });

</script>

</body>

