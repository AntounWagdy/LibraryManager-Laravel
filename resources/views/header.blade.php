<div class='header' id="myHeader">
    <h1>المكتبة العسكرية للواء 24 إنذار</h1>
    <a href='/'><img src="img/logo.png" style="height: 100px;"/></a>
</div>
<script>
    window.onscroll = function(){myFunction()};
    var header = document.getElementById("myHeader");
    var sticky = header.offsetTop;

    function myFunction(){
        if(window.pageYOffset > sticky){
            header.classList.add("sticky");
        } else {
            header.classList.remove("sticky");
        }
    }
</script>
