<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="author" content="colorlib.com">
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet" />
  <link href="{{ asset('css/index.css') }}" rel="stylesheet" />
  <link href="{{ asset('css/header.css') }}" rel="stylesheet" />
  <script src="{{ asset('js/jquery.min.js') }}">
  </script>

</head>

<body>
  @include('header')
  <div class="s007">
    <form action="/view" method="GET">
      <div class="inner-form">
        <div class="basic-search">
          <div class="input-field">
            <div class="icon-wrap">
              <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" viewBox="0 0 20 20">
                <path d="M18.869 19.162l-5.943-6.484c1.339-1.401 2.075-3.233 2.075-5.178 0-2.003-0.78-3.887-2.197-5.303s-3.3-2.197-5.303-2.197-3.887 0.78-5.303 2.197-2.197 3.3-2.197 5.303 0.78 3.887 2.197 5.303 3.3 2.197 5.303 2.197c1.726 0 3.362-0.579 4.688-1.645l5.943 6.483c0.099 0.108 0.233 0.162 0.369 0.162 0.121 0 0.242-0.043 0.338-0.131 0.204-0.187 0.217-0.503 0.031-0.706zM1 7.5c0-3.584 2.916-6.5 6.5-6.5s6.5 2.916 6.5 6.5-2.916 6.5-6.5 6.5-6.5-2.916-6.5-6.5z"></path>
              </svg>
            </div>
            <input name="search" type="text" placeholder="اكتب هنا..." />
          </div>
        </div>
        <div class="advance-search">
          <span class="desc">بحث متقدم</span>
          <div class="row">

            <div class="input-field">
              <div class="input-select">
                <input name="shelf" type="text" placeholder="الرف..." />
              </div>
            </div>
            <div class="input-field">
              <div class="input-select">
                <input name="section" type="text" placeholder="القسم..." />
              </div>
            </div>
            <div class="input-field">
              <div class="input-select">
                <input name="author" type="text" placeholder="المؤلف..." />
              </div>
            </div>
          </div>
          <br>
          <br>
          <div class="row third">
              <button class="btn-search2" type="button" id='update'>إمسح الكود</button>
              <button class="btn-search">البحث</button>
              <button class="btn-search3" type="button" onclick="window.location.assign('/borrow')">إظهار الإستعارة</button>
          </div>
        </div>
      </div>
    </form>
  </div>


  <dialog id="favDialog" style="border: none;">
    <form method="dialog">
      <p>
        <img src="img/1.gif" />
      </p>
      <menu>
        <button id="cancel" value="cancel">إغلاق</button>
      </menu>
    </form>
  </dialog>

  <script>
    var updateBtn = document.getElementById("update");
    var favDialog = document.getElementById("favDialog");
    var cancelBtn = document.getElementById("cancel");
    updateBtn.addEventListener("click", function onOpen() {
      favDialog.showModal();
      $.ajax({
        type: 'GET',
        url: '/getBar',
        data: '_token = <?php echo csrf_token() ?>',
        success: function(data) {
          window.location.assign("/view?qr=" + data);
        }
      });
    });

    cancelBtn.addEventListener("click", function onOpen() {
      $.ajax({
        type: 'GET',
        url: '/closeApp',
        data: '_token = <?php echo csrf_token() ?>',
        success: function() {}
      });
    });
  </script>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>