@include('layouts.bootstrap')

<h1>{{$contact->name . ' ' . $contact->family}}</h1>

<h2>PhoneNumbers</h2>
@foreach( $phoneNumbers as $phoneNumber)
    <li>{{$phoneNumber->phone_number}}</li>
@endforeach

<h2>Emails</h2>
@foreach( $emails as $email)
    <li>{{$email->email_address}}</li>
@endforeach

<a href="{{route('contact.edit.form',[$contact->id])}}">
    {{--<a href="{{route('user.login.form')}}">--}}
    <button class="btn btn-danger" style="margin: 5px">اصلاح مخاطب</button>
</a>
{{--<h1> {{ $contact->phone_number . ' ' . $contact->family }}</h1>--}}
