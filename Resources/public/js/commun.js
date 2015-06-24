function updateCoords(c)
{
    $('#x').val(c.x);
    $('#y').val(c.y);
    $('#w').val(c.w);
    $('#h').val(c.h);
}
;
function checkCoords()
{
    if (parseInt($('#w').val()))
        return true;
    alert('Please select a crop region then press submit.');
    return false;
}
var jcrop_api;
$(function () {
    $('#cropbox').Jcrop({
        aspectRatio: 1,
        setSelect: [0, 0, 250, 250],
        minSize: [250, 250],
        maxSize: [250, 250],
        onSelect: updateCoords,
        onChange: updateCoords}, function () {
        jcrop_api = this;
    });
});
function destroyJCrop() {
    if (!jcrop_api) {
        return false;
    }
    jcrop_api.destroy();
}
function initJCrop(img) {
    if (jcrop_api) {
        jcrop_api.destroy();
    }
    $('#cropbox').remove();
    $('#jcrop-holder').html('<img src="' + img + '" id="cropbox" />');
    $('#cropbox').Jcrop({
        aspectRatio: 1,
        setSelect: [0, 0, 250, 250],
        minSize: [250, 250],
        maxSize: [250, 250],
        onSelect: updateCoords,
        onChange: updateCoords}, function () {
        jcrop_api = this;
    });
    ;
}




