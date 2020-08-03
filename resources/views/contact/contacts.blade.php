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
<body>
<a href="{{route('contact.add.form',$userId)}}">
    <button class="btn btn-danger" style="margin: 5px">اضافه کردن مخاطب</button>
</a>
<a href="{{route('user.logout')}}">
    <button class="btn btn-light" style="margin: 5px">خروج</button>
</a>

<hr>
<h2 align="right">خصوصی</h2><br>
<div align="right">
    <table class="table table-striped">
        <tr>
            <th>مخاطب</th>
            <th>عملیات</th>
        </tr>
        @foreach($contacts as $contact)
            <tr>
                <td><a
                        href={{route('contact.details',['id'=>$contact->user_id,'idContact'=>$contact->id])}}>{{$contact->name . ' ' .$contact->family}}</a>
                </td>

                <td>
                    <button id="del" onclick="deleteFunc({{$contact->id}})">حذف</button>
                </td>
            </tr>
        @endforeach
    </table>
</div>

<h2 align="right">عمومی</h2>
<div align="right">
    <table class="table table-striped">
        @foreach($publicContacts as $pContact)
            <tr>
                <td><a
                        href={{route('contact.details',['id'=>$userId,'idContact'=>$pContact->id])}}>{{$pContact->name . ' ' .$pContact->family}}</a>
                </td>

                {{--                <td><a href="{{route('contact.delete',$contact->id)}}">حذف</a>--}}
                {{--                </td>--}}
            </tr>
        @endforeach
    </table>
</div>
</body>

<script type="text/javascript">

    function deleteFunc(contactId) {

        let url = "/user/" + {{$userId}} +"/contact/delete/" + contactId;
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


</script>

</html>
