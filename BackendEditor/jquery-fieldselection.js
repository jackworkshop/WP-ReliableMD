function getCursor() {
    var cursor = 0; // 光标位置
    var range = document.selection.createRange();
    var srcele = range.parentElement();//获取到当前元素
    var copy = document.body.createTextRange();
    copy.moveToElementText(srcele);

    for (cursor = 0; copy.compareEndPoints("StartToStart", range) < 0; cursor++) {
        copy.moveStart("character", 1);//改变光标位置，实际上我们是在记录cursor的数量.
    }

}
function moveCursor(obj, start) {
        obj.focus();
        var r = document.selection.createRange();
        r.moveStart('character', start);
        r.collapse(true);
        r.select();
}
