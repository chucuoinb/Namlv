require([
        'jquery',
        'jquery/ui',
        'jquery/validate',
        'mage/translate'
    ], function ($) {
        $(document).ready(function () {
            //change number in page
            $("#select_page").change(function () {
                // alert(123)
                var numberInPage = $("#select_page").val();
                $.ajax({
                    url : "http://localhost/magento/tutorial/api/session",
                    type : "post",
                    dataType:"text",
                    data : {
                        key : "numberInPage",
                        value: numberInPage
                    },
                    success : function (result){
                        if(parseInt(result) == 200){
                            window.location= 'http://localhost/magento/tutorial/post';
                        }
                        else
                            alert('error');
                    }
                });
            })

        });
    }
);
function view(id) {
    window.location = 'http://localhost/magento/tutorial/post/view/id/'+id;
}
function setCookie(cname, cvalue) {
    document.cookie = cname + "=" + cvalue + ";path=/";
}
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}