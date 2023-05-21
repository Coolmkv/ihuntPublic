
function date_time(id)
{
    date = new Date;
    year = date.getFullYear();
    month = date.getMonth();
    months = new Array('January', 'February', 'March', 'April', 'May', 'June', 'Jully', 'August', 'September', 'October', 'November', 'December');
    d = date.getDate();
    day = date.getDay();
    days = new Array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
    h = date.getHours();
    if (h < 10)
    {
        h = "0" + h;
    }
    m = date.getMinutes();
    if (m < 10)
    {
        m = "0" + m;
    }
    s = date.getSeconds();
    if (s < 10)
    {
        s = "0" + s;
    }
    result = '' + days[day] + ' | ' + months[month] + ' ' + d + ', ' + year + ' | ' + h + ':' + m + ':' + s;
    document.getElementById(id).innerHTML = result;
    setTimeout('date_time("' + id + '");', '1000');
    return true;
}
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#image_size') // id of div that contains image
                .attr('src', e.target.result)
//                                .width(100)
//                                .height(100);
        };

        reader.readAsDataURL(input.files[0]);
    }
}
$(document).on("click",".fa-edit",function(){
    $('html, body').animate({
    'scrollTop' : $(".main-header").position().top
    });
    $('.loader').show();
    $('.loader').fadeOut(1500);
}); 
$('.loader').fadeOut('slow');
$(document).on("click",".editbtn ,.fa-pencil",function(){
    $('html, body').animate({
    'scrollTop' : $(".main-header").position().top
    });
    $('.loader').show();
    $('.loader').fadeOut(1500);
});  
//$( "form" ).submit(function() {
//    $('html, body').animate({
//    'scrollTop' : $(".main-header").position().top
//    });
//    $('.loader').show();
//    $('.loader').fadeOut(1500);
//});
function examMode(location, selval, urls) {
    examModearr=[];
        $.ajax({
            url: urls,
            type: 'POST',
            success: function (response) {
                if (response !== '""') {
                    var json = $.parseJSON(response);
                    var data = '<option value="">Select</option>';
                    for (var i = 0; i < json.length; i++) {
                        examModearr[json[i].exam_mode_id ]=json[i].title;
                        data = data + '<option value="' + json[i].exam_mode_id + '">' + json[i].title + '</option>';
                    }
                } else {
                    var data = '<option value="">Not Available</option>';
                }

                $('#' + location).html(data);
                $('#' + location).val(selval);
            },
            error: function (jqXHR, exception) {
                $.alert({
                    title: 'Error!', content: jqXHR["status"] + " " + exception, type: 'red',
                    typeAnimated: true,
                    buttons: {
                        Ok: function () {
                            window.location.reload();
                        }
                    }
                });
            }
        });
    }    
function checkMinMaxValue(minValId, maxValId, changedId) {
        var minVal = $("#" + minValId).val();
        var maxVal = $("#" + maxValId).val();
        if (minVal === "") {
            return false;
        }
        if (maxVal === "") {
            return false;
        }
        if (parseInt(minVal) > parseInt(maxVal)) {
             
            $("#" + (maxValId===changedId?minValId:maxValId)).val('');
            $("#" + (maxValId===changedId?minValId:maxValId)).focus();
            $.alert({
                title: 'Error!', content: "Invalid value", type: 'red',
                typeAnimated: true,
                buttons: {
                    Ok: function () {

                    }
                }
            });
        } else {
            return true;
        }
    }
    function dateValidation(minDateid,maxDateId,changedId){         
        if (minDateid === changedId) {
            $("#"+maxDateId).prop("min",$("#"+changedId).val());
        }
        if (maxDateId === changedId) {
            $("#"+minDateid).prop("max",$("#"+changedId).val());
        }
        if(changedId==="closingDate"){
            $("#examDate").prop("min",$("#"+changedId).val());
            $("#resultDateId").prop("min",$("#"+changedId).val());
        }
    }
    function showHideDiv(id) {
        if ($("#button" + id).prop("checked") === true) {
            $("#" + id).removeClass("hidden");
            $("." + id).attr("data-validation", "required");
        } else {

            $("#" + id).addClass("hidden");
            $("." + id).attr("data-validation", "");
        }
    }
    function clearForm(id){
        document.getElementById(id).reset();
        resetProgressBar();
    }
    function resetProgressBar(){
        $(".imgprogress").css("display","none");
         var percentValue = '0%';
        $('.imgprogress-bar').width(percentValue);
        $('.imgpercent').html(percentValue);
    }
    function closeModal(id){
         
        $("#"+id).css('display','none');
         
    }
    function minQualFromArr(minQualificationset, location) {
        var options = "";
        var tableName = "";
        for (var key in minqlaificationsarr) {
            var keyarr = key.split(",");
            if (tableName === "") {
                options = options + '<optgroup label="' + keyarr[2] + '" data-max-options="1">';
                tableName = keyarr[1];
            } else {
                if (tableName === keyarr[1]) {
                    options = options + '<option value="' + keyarr[0] + ',' + keyarr[1] + '" ' + (minQualificationset === keyarr[0] + ',' + keyarr[1] ? 'selected' : '') + '>' + minqlaificationsarr[key] + '</option>';

                } else {
                    options = options + '</optgroup>';
                    options = options + '<optgroup label="' + keyarr[2] + '" data-max-options="1">';
                    tableName = keyarr[1];
                }
            }
            //options = options + '<option value="' + key + '" ' + (minQualificationset === key ? 'selected' : '') + '>' + minqlaificationsarr[key] + '</option>';
        }
        $("#" + location).html(options);
    }
    function markingTypearr(location,selval){
        var mType = '<option value="">Select</option>';
        for (var key in markingType) {
            mType = mType + '<option value="' + markingType[key] + '"  ' + (markingType[key] === selval ? "selected" : "not") + '>' + markingType[key] + '</option>';
        }
        $("#" + location).html(mType);
    }    
    function durationArr(location,selval){
        var mType = '<option value="">Select</option>';
        for (var key in durationarr) {
            mType = mType + '<option value="' + key + '"  ' + (key === selval ? "selected" : "not") + '>' + durationarr[key] + '</option>';
        }
        $("#" + location).html(mType);
    }
    function examModeArr(location,selval){
        var mType = '<option value="">Select</option>';
        for (var key in examModearr) {
            mType = mType + '<option value="' + key + '"  ' + (key === selval ? "selected" : "not") + '>' + examModearr[key] + '</option>';
        }
        $("#" + location).html(mType);
    }
    function feeCycleArr(location,selval){
        var mType = '<option value="">Select</option>';
        for (var key in feeCyclearr) {
            mType = mType + '<option value="' + key + '"  ' + (key === selval ? "selected" : "not") + '>' + feeCyclearr[key] + '</option>';
        }
        $("#" + location).html(mType);
    }
    function setCoursetype(location,selval){
        var mType = '<option value="">Select</option>';
        for (var key in courseType) {
            mType = mType + '<option value="' + key + '"  ' + (key === selval ? "selected" : "not") + '>' + courseType[key] + '</option>';
        }
        $("#" + location).html(mType);
    }
    function courseDurationTypeSet(location,selval){
        var mType = '<option value="">Select</option>';
        for (var key in courseDurationTypearr) {
            mType = mType + '<option value="' + key + '"  ' + (key === selval ? "selected" : "not") + '>' + courseDurationTypearr[key] + '</option>';
        }
        $("#" + location).html(mType);
    }
    function subjectNamesShow(location,selval){
        var mType = '<option value="">Select</option>';
        
        for (var key in subjectNames) {
            var arritems=subjectNames[key];
            var keyarr = arritems.split("^");
            mType = mType + '<option value="' + keyarr[0] + '"  ' + (keyarr[0] === selval ? "selected" : "not") + '>' + keyarr[1] + '</option>';
        }
        $("#" + location).html(mType);
    }