/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function() { 
    $( "#closecancel" ).click(function() {
    $(".resetVisibles").css("display", "none");
    return false;
});

$.addElements = function(id, arrayString) {
   //function body...
    $('<input>').attr({
        type: 'hidden',
        name: 'arrayString',
        value: arrayString
    }).appendTo(id);
};

$.callActionForm = function(id, arrayString, imgUrl) {
   //function body...
    $("#overlay-back").css("display", "inline");
    $(id).css("display", "inline");
    
    if (id === "#proofimageupload") {
    $.addElements('#proofform', arrayString);
    } else if (id === "#divviewproof") {
        $('#proofimgview').attr('src', imgUrl);
        $.addElements('#confirmform', arrayString);

//        $('<img>').attr({
//        name: 'arrayString',
//        src: arrayString
//    }).appendTo('#divviewproof');
//        alert("we here " + arrayString);
    }
};

$('#image-file').bind('change', function() {
    var size = this.files[0].size/1024/1024;
    if (size > 2){
        alert('Uploaded image is greater than 2MB. \n This file size is: ' + size + "MB");
    }
});



}) ;

//outside doc ready function