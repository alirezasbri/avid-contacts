<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Contacts</title>
@include('layouts.bootstrap')
<!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

</head>
<body style="margin: 20px">
<h1 align="right">{{$contact->name . ' ' . $contact->family}}</h1>

<div align="right">
    <h2>شماره تماس‌ها</h2>
    <table class="table table-striped">
        @foreach( $phoneNumbers as $phoneNumber)
            <tr>
                <td>{{$phoneNumber->phone_number}}</td>

                @switch($phoneNumber->type)
                    @case('mobile')
                    <td>موبایل</td>
                    @break

                    @case('phone')
                    <td>ثابت</td>
                    @break
                @endswitch
            </tr>

        @endforeach
    </table>


    <h2>ایمیل‌ها</h2>
    <table class="table">
        @foreach( $emails as $email)
            <tr>
                <td>{{$email->email_address}}</td>
            </tr>
        @endforeach
    </table>

    @if($editable)
        <a href="{{route('contact.edit.form',[$contact->slug])}}">
            <button class="btn btn-danger" style="margin: 5px">اصلاح مخاطب</button>
        </a>
    @endif


</div>
</body>
