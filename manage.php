<html>
<head>
    <title>Recruitment Management</title>

</head>
<body>

<div></div>

<script>
    var header = document.getElementById("nav");
    var btns = header.getElementsByClassName("menu-item");
    for (var i = 0; i < btns.length; i++) {
        btns[i].addEventListener("click", function() {
            var current = document.getElementsByClassName("active");
            current[0].className = current[0].className.replace(" active", "");
            this.className += " active";
        });
    }
</script>
</body>
</html>