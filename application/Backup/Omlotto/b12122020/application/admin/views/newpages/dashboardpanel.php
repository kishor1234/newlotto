
<div id="app-msg"></div>

<div id="app-container">
    <!-- Content Wrapper. Contains page content -->

    <!-- /.content-wrapper -->
</div>

<script>
    $(function () {
        var display = "#app-container";
        onLoading(display, 1);
        function getSearchParams(k) {
            var p = {};
            location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (s, k, v) {
                p[k] = v
            })
            return k ? p[k] : p;
        }
        $.urlParam = function (name) {
            var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
            if (results === null) {
                return null;
            }
            return decodeURI(results[1]) || 0;
        };
        var request = getSearchParams();
        var url = "/?";
        var url2 = "/?r=link";
        $.each(request, function (index, value) {
            if (index === "r")
            {
                url += "" + index + "=" + value;
            } else {
                url2 += "&" + index + "=" + value;
                url += "&" + index + "=" + value;
            }
        });
        //console.log(u);
        //console.log(u2);
        //var url = "/?r=" + $.urlParam('r') + "&v=" + $.urlParam('v') + "&id=" + $.urlParam('id');
        //var url2 = "/?r=link" + "&v=" + $.urlParam('v') + "&id=" + $.urlParam('id');
        $.post(url2, {condition: false}, function (data)
        {
            //console.log(data);
            offLoading(display);
            $(display).html(data);
            $("#app-msg").show();
            printMessage('/?r=CPrintMessage', "#app-msg");
            if (typeof (history.pushState) != "undefined") {
                var obj = {Title: "Title", Url: url};
                history.pushState(obj, obj.Title, obj.Url);
                //$.session.set("historyurl", "" + "?r=" + file + "1");
            } else {
                alert("Browser does not support HTML5.");
            }
        });
        return false;
    });
</script>
<?php
//die;
?>