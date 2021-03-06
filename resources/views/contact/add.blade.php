@extends('layouts.app')

@section('content')

    <div style="margin: 30px" class="col-md-5">
        <h1 style="text-align: right">فرم اضافه کردن مخاطب</h1>
        @include('layouts.errors')

        <form action="{{ route('contact.add') }}" method="post" enctype="multipart/form-data">

            {{csrf_field()}}
            <div style="text-align: right">

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Name">
                </div>
                <div class="form-group">
                    <label for="family">Family</label>
                    <input type="text" name="family" class="form-control" id="family" placeholder="Family">
                </div>
                <div class="form-check">
                    <input name="checkBox" id="checkbox" class="form-check-input" type="checkbox">
                    <label class="form-check-label" for="checkbox">
                        به اشتراک گذاشتن
                    </label>
                </div>

                <button type="submit" style="margin-top: 5px " class="btn btn-primary">ثبت
                    نهایی
                </button>

                <hr>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" name="phone" class="form-control" id="phone" placeholder="Phone Number">

                    <label for="type">نوع شماره:</label>
                    <select name="type" id="type">
                        <option value="mobile">موبایل</option>
                        <option value="phone">ثابت</option>
                    </select>
                    <button type="button" style="margin-top: 5px " id="phoneBtn" class="btn btn-danger"
                            onclick="addPhone()">ثبت
                        شماره
                    </button>
                </div>
                <div id="divPhone"></div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="text" name="email" class="form-control" id="email" placeholder="Email Address">
                    <button type="button" style="margin-top: 5px " id="emailBtn" class="btn btn-danger"
                            onclick="addEmail()">ثبت
                        ایمیل
                    </button>
                </div>
                <div id="divEmail"></div>

                <h3>اضافه کردن عکس پروفایل</h3>
                <input type="file" name="photo_name" id="photo_name">
                <br>


            </div>
        </form>
    </div>


@endsection

<script type="text/javascript">

    function addPhone() {

        let phoneNumber = document.getElementById("phone").value;


        let mobileFilter = /^(\+98|0098|98|0)?9\d{9}$/;
        let phoneFilter = /^(\+98|0098|98|0)[1-9]\d{9}$/;
        let filter = new RegExp("(" + mobileFilter.source + ")|(" + phoneFilter.source + ")");
        if (filter.test(phoneNumber)) {
            let inputElement = document.createElement("input");
            inputElement.setAttribute("name", "phones[]");
            inputElement.setAttribute("value", document.getElementById("phone").value);
            inputElement.innerHTML = document.getElementById("phone").value;

            let labelElement = document.createElement("input");
            labelElement.setAttribute("name", "types[]");
            labelElement.setAttribute("value", document.getElementById("type").value);
            labelElement.innerHTML = document.getElementById("type").value;
            labelElement.readOnly = true;


            document.getElementById("phone").value = "";
            document.getElementById("divPhone").appendChild(inputElement);
            document.getElementById("divPhone").appendChild(labelElement);
            document.getElementById("divPhone").appendChild(document.createElement("br"));
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

</script>
