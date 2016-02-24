//show loading animation when we request ajax $.get request. This can used in .always and in $.get function
//check animation div has "is-active" class to activate loading animation or not
function loadingAnimation($element) {
    if ($element.hasClass("is-active") == false) {
        $element.addClass("is-active");
        console.log("showing loading animation");
    }
    else {
        console.log("removed loading animation");
        $element.removeClass("is-active");
    }
}