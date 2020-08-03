<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <title>Add Contact</title>

    @include('layouts.bootstrap')

</head>
<body>
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

<button onclick="savePhonesAndEmails()" class="btn btn-primary">ثبت نهایی</button>

{{--</form>--}}
<hr>
{{--<button class="btn btn-primary" onclick="savePhonesAndEmails()">ثبت شماره و ایمیل</button>--}}

<div class="form-group">
    <label for="phone">Phone Number</label>
    <input type="tel" name="phone" class="form-control" id="phone" placeholder="Phone Number">
    <button id="phoneBtn" class="btn btn-danger" onclick="addPhone()">ثبت شماره</button>
</div>
<div id="divPhone"></div>
<div class="form-group">
    <label for="email">Email Address</label>
    <input type="text" name="email" class="form-control" id="email" placeholder="Email Address">
    <button id="emailBtn" class="btn btn-danger" onclick="addEmail()">ثبت ایمیل</button>
</div>
<div id="divEmail"></div>

</body>

<script type="text/javascript">
    e.preventDefault();

    function addPhone() {
        let para = document.createElement("input");
        para.setAttribute("name", "phones[]");
        para.setAttribute("value", document.getElementById("phone").value);
        para.innerHTML = document.getElementById("phone").value;
        document.getElementById("phone").value = "";
        document.getElementById("divPhone").appendChild(para);
    }

    function addEmail() {
        let para = document.createElement("input");
        para.setAttribute("name", "emails[]");
        para.setAttribute("value", document.getElementById("email").value);
        para.innerHTML = document.getElementById("email").value;
        document.getElementById("email").value = "";
        document.getElementById("divEmail").appendChild(para);
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

        let json = {
            name: name,
            family: family,
            phones: phones,
            emails: emails
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
            },
            error: function (data) {
                alert(data)
            }

        });

    }

</script>
