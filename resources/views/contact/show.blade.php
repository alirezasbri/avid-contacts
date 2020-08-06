@include('layouts.bootstrap')


<body style="margin: 20px">
<h1>{{$contact->name . ' ' . $contact->family}}</h1>

<h2>PhoneNumbers</h2>
<table class="table">
    @foreach( $phoneNumbers as $phoneNumber)
        <tr>
            <td>{{$phoneNumber->phone_number}}</td>
            <td>{{$phoneNumber->type}}</td>
        </tr>

    @endforeach
</table>


<h2>Emails</h2>
<table class="table">
    @foreach( $emails as $email)
        <tr>
            <td>{{$email->email_address}}</td>
        </tr>
    @endforeach
</table>

@if($editable)
    <a href="{{route('contact.edit.form',[$contact->id])}}">
        {{--<a href="{{route('user.login.form')}}">--}}
        <button class="btn btn-danger" style="margin: 5px">اصلاح مخاطب</button>
    </a>
@endif
{{--<h1> {{ $contact->phone_number . ' ' . $contact->family }}</h1>--}}
</body>
