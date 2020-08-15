@extends('layouts.app')

@section('content')

    <div style="text-align: right">
        <a href="{{route('contact.add.form')}}" style="text-align: right">
            <button class="btn btn-danger" style="margin: 5px; text-align: right">اضافه کردن مخاطب</button>
        </a>
    </div>

    <hr>
    <div style="text-align: right">
        <table class="table table-striped">
            <tr>
                <th>مخاطب</th>
                <th>نوع</th>
                <th>عملیات</th>
            </tr>
            @foreach($contacts as $contact)
                <tr>
                    <td>

                        @php
                            $value = isset($contact->image) ? $contact->image->image : null;
                        @endphp
                        @isset($value)
                            <img id="profileImage"
                                 src="{{'/public/image/'. $value  }}"
                                 class=" z-depth-1-half avatar-pic"
                                 alt="">
                        @endif

                        <a
                            href={{route('contact.details',['contactSlug'=>$contact->slug])}}>{{$contact->name . ' ' .$contact->family}}</a>
                    </td>

                    @switch($contact->type)
                        @case('private')
                        <td>خصوصی</td>
                        @break

                        @case('public')
                        <td>عمومی</td>
                        @break

                        @case('shared')
                        <td>اشتراکی</td>
                        @break
                    @endswitch

                    <td>
                        <button id="del" onclick="deleteFunc({{$contact->id}})">حذف</button>
                    </td>
                </tr>
            @endforeach

            @foreach($publicContacts as $pContact)
                <tr>
                    <td><a
                            href={{route('contact.details',['contactSlug'=>$pContact->slug])}}>{{$pContact->name . ' ' .$pContact->family}}</a>
                    </td>

                    @switch($pContact->type)
                        @case('private')
                        <td>خصوصی</td>
                        @break

                        @case('public')
                        <td>عمومی</td>
                        @break

                        @case('shared')
                        <td>اشتراکی</td>
                        @break
                    @endswitch
                </tr>
            @endforeach

        </table>
    </div>
    {{--</body>--}}

    <script type="text/javascript">

        function deleteFunc(contactId) {

            let url = "/user/" + {{$userId}} +"/contact/delete/" + contactId;
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


    </script>

    </html>
@endsection
