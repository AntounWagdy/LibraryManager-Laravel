<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="colorlib.com">
    <link href="{{ asset('css/header.css') }}" rel="stylesheet" />
    <link href="css/viewer.css" rel="stylesheet" />
    <script src="{{ asset('js/jquery.min.js') }}"></script>
</head>

<body>
    @include('header')
    <div class="s007">
        <form>
            <div class="inner-form">
                <div class="basic-search">
                    <div class="input-field">
                        <div class="icon-wrap">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" viewBox="0 0 20 20">
                                <path
                                    d="M18.869 19.162l-5.943-6.484c1.339-1.401 2.075-3.233 2.075-5.178 0-2.003-0.78-3.887-2.197-5.303s-3.3-2.197-5.303-2.197-3.887 0.78-5.303 2.197-2.197 3.3-2.197 5.303 0.78 3.887 2.197 5.303 3.3 2.197 5.303 2.197c1.726 0 3.362-0.579 4.688-1.645l5.943 6.483c0.099 0.108 0.233 0.162 0.369 0.162 0.121 0 0.242-0.043 0.338-0.131 0.204-0.187 0.217-0.503 0.031-0.706zM1 7.5c0-3.584 2.916-6.5 6.5-6.5s6.5 2.916 6.5 6.5-2.916 6.5-6.5 6.5-6.5-2.916-6.5-6.5z">
                                </path>
                            </svg>
                        </div>
                        <input name="search" type="text" placeholder="اكتب هنا..." />
                    </div>
                </div>
        </form>

        @foreach ($data as $item)
            <div class="advance-search">
                <span class="desc">{{ $item['NAME'] }}</span>
                <div class="row">
                    <button type="button" data-id="{{ $item['ID'] }}" onclick="showBorrows(this)" class="btn-search">عرض
                        الإستعارات</button>
                    <p class="author" type="text" style="visibility: hidden;">داتا</p>
                    <p class="author" type="text" style="visibility: hidden;">عدد النسخ</p>
                    <p class="data" id="num_copies" type="text">{{ $item['COPIES'] }}</p>
                    <p class="type" type="text">عدد النسخ</p>
                    <p class="data" id="author" type="text">{{ $item['AUTHOR'] == '' ? '---' : $item['AUTHOR'] }}</p>
                    <p class="type" type="text">المؤلف</p>
                </div>

                <div class="row">
                    <button type="button" data-id="{{ $item['ID'] }}" onclick="borrow(this)"
                        class="btn-search">إستعر</button>
                    <p class="author" type="text" style="visibility: hidden;">داتا</p>
                    <p class="author" type="text" style="visibility: hidden;">عدد النسخ</p>
                    <p class="data" id="num_copies" type="text" style="visibility: hidden;">ASD</p>
                    <p class="type" type="text" style="visibility: hidden;">عدد الصفحات</p>
                    <p class="data" id="author" type="text">
                        قسم {{ $item['SECTION'] }}،
                        رف {{ $item['SHELF'] }}،
                        كتاب رقم {{ $item['STACK'] }}
                    </p>
                    <p class="type" type="text">المكان</p>
                </div>
            </div>
            <br>
        @endforeach



    </div>
    </div>
    <dialog id="favDialog" style="border-color: black; background-color: #5c4740;">
        <form method="dialog">
            <p>
                <input autofocus placeholder="الأسم" type="text" id="name" />
                <select id="class" name="class">
                    <option value="volvo">ملازم</option>
                    <option value="saab">ملازم أول</option>
                    <option value="mercedes">نقيب</option>
                    <option value="audi">رائد</option>
                    <option value="audi">مقدم</option>
                    <option value="audi">عقيد</option>
                    <option value="audi">عميد</option>
                    <option value="audi">لواء</option>
                    <option value="audi">فريق</option>
                </select>
            </p>
            <menu>
                <button id="confirm" value="confirm">تأكيد</button>
                <button id="cancel" value="cancel">إلغاء</button>
            </menu>
        </form>

    </dialog>

    <script>
        function showBorrows(ele) {
            var dataid = $(ele).attr('data-id');
            window.location.assign("/borrow?book_id=" + dataid);
        }

        function borrow(ele) {
            var dataid = $(ele).attr('data-id');

            // Start from here 
            var favDialog = document.getElementById("favDialog");
            var confirmBtn = document.getElementById("confirm");
            var nameinput = document.getElementById("name");
            var classinput = document.getElementById("class");

            favDialog.showModal();

            confirmBtn.addEventListener("click", function onOpen() {
                // send php request
                window.location.assign("/borrow?id=" + dataid + "&class=" + classinput.options[classinput
                        .selectedIndex].text +
                    "&name=" + nameinput.value);
            });


        }

    </script>
    @if ($errors->any())
        <script>
            window.onload = function() {
                alert("لا نسخ متاحة حاليا فى المكتبة");
            }
        </script>
    @endif
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
