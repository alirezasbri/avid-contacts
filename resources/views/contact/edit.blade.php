<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <title>Edit Contact</title>

    @include('layouts.bootstrap')
    {{--    <!-- Custom styles for this template -->--}}
    {{--    <link href = {{ asset("bootstrap/css/sticky-footer-navbar.css") }} rel="stylesheet" />--}}

    {{--    <!-- Optional theme -->--}}
    {{--    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap-theme.min.css') }}">--}}
</head>
<body>
<h1>Contact Edit Form</h1>
{{--<form action="{{ route('contact.edit',$idContact) }}" method="post">--}}
{{--    {!! csrf_field() !!}--}}
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

<button onclick="savePhonesAndEmails()" class="btn btn-primary">Submit</button>
{{--    <div class="form-group">--}}
{{--        <label for="phone">Phone Number</label>--}}
{{--        <input type="tel" name="phone" class="form-control" id="phone" placeholder="Phone Number"--}}
{{--               value="{{$phoneNumbers}}">--}}
{{--    </div>--}}

{{--    <div class="form-group">--}}
{{--        <label for="email">Email Address</label>--}}
{{--        <input type="text" name="email" class="form-control" id="email" placeholder="Email Address"--}}
{{--               value="{{$emails}}">--}}
{{--    </div>--}}

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


{{--</form>--}}


<table class="table table-striped">
    @foreach($phoneNumbers as $pn)
        <tr>
            <td>{{$pn->phone_number}}
            </td>

            <td>
                <button id="del" onclick="deleteFunc({{$pn->id}})">حذف</button>
            </td>
        </tr>
    @endforeach
</table>


<table class="table table-striped">
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

<script type="text/javascript">

    function deleteFunc(pnId) {
        let url = "/phonenumber/delete/" + pnId;
        $.ajax({
            url: url,
            type: 'GET',
            success: function (res) {
                location.reload();
                // console.log(res);
                // alert(res);
            },
            fail: function (xhr, textStatus, errorThrown) {
                // alert(contactId);
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
                // console.log(res);
                // alert(res);
            },
            fail: function (xhr, textStatus, errorThrown) {
                // alert(contactId);
            }
        });
    }

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

        let phones = '';
        let emails = '';
        phones = $("input[name='phones[]']")
            .map(function () {
                return $(this).val();
            }).get();

        emails = $("input[name='emails[]']")
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
        };


        let url = '/contact/edit/' + {{$contact->id}} +'';
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
                alert(url)
            }

        });

    }


</script>

</body>

