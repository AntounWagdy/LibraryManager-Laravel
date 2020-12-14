<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="colorlib.com">
    <link href="{{ asset('css/header.css') }}" rel="stylesheet" />
    <link href="css/borrows.css" rel="stylesheet" />
    <script src="{{ asset('js/jquery.min.js') }}"></script>
</head>

<body>
    @include('header')
    @if ($data == null)
        <h2> لا إستعارات حالية</h2>

    @else
        <h2 style="font-size: 28px;">الإستعارات حالية</h2>
        <div class="s007">
            <form>
                <div class="inner-form">

                    @foreach ($data as $key => $item)

                        <div class="advance-search">
                            <span class="desc">{{ $key }}</span>
                            @foreach ($item as $bookname)
                                <div class="row">
                                    <button type="button" data-name="{{ $key }}" data-book_id="{{ $bookname[1] }}"
                                        onclick="return_book(this)" class="btn-search">إسترجاع</button>
                                    <p class="author" type="text" style="visibility: hidden;">داتا</p>
                                    <p class="author" type="text" style="visibility: hidden;">عدد النسخ</p>
                                    <p class="data" id="num_copies" style="visibility: hidden;" type="text">داتا</p>
                                    <p class="type" style="visibility: hidden;" type="text">عدد النسخ</p>
                                    <p class="data" id="author" type="text">{{ $bookname[0] }}</p>
                                    <p class="type" type="text">إسم الكتاب: </p>
                                </div>
                            @endforeach

                        </div>
                        <br>
                    @endforeach
    @endif

    </div>
    </div>
    <script>
        function return_book(ele) {
            var name = $(ele).attr('data-name');
            var bookname = $(ele).attr('data-book_id');
            window.location.assign("/return?name=" + name + "&book_id=" + bookname);
        }

    </script>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
