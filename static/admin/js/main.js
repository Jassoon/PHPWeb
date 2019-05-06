"use strict";
(function () {
    var hour = (new Date()).getHours(),
        hello = '您好';

    if (hour < 4) {
        hello = "夜深了";
    } else if (hour < 7) {
        hello = "早安";
    } else if (hour < 9) {
        hello = "早上好";
    } else if (hour < 12) {
        hello = "上午好";
    } else if (hour < 14) {
        hello = "中午好";
    } else if (hour < 17) {
        hello = "下午好";
    } else if (hour < 19) {
        hello = "您好";
    } else if (hour < 22) {
        hello = "晚上好";
    } else {
        hello = "夜深了";
    }

    document.getElementById('greet').innerHTML = hello;
})();