                
// jquery hint

$('input[title!=""]').hint();

// jquery-ui button

if ($.trim($("#options").html())) { $("#options").button() };
if ($.trim($("#delete-button").html())) { $("#delete-button").button() };

// empty followingme-list

var followingme = $.trim($('#fm-followers').html());  
if (!followingme || (followingme == 0)) { $('#fm-followers').html('<div id="empty">[ empty ]</div>'); };

// timeout responses

var takeout = function() {
    if (($.trim($('#friendship-response').text()))) {
	$('#friendship-response').fadeOut('fast');
    }
    else if (($.trim($('#addfollowers-response').text()))) {     
	$('#addfollowers-response').fadeOut('fast');
    }
    else if (($.trim($('#bad-email').text()))) {
	$('#bad-email').fadeOut('fast');
    }
    else if (($.trim($('#email-update').text()))) {
	$('#email-update').fadeOut('fast');
    }
    $.get('takeout.php');
};
setTimeout(takeout, 2000);

// insert buttons on last-five & followingme-list

$("<div class='button ui-widget ui-helper-clearfix icons'><li class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-plus'></span></li></div>").insertAfter('.fm-names.add');

$("<div class='button ui-widget ui-helper-clearfix icons'><li class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-minus'></span></li></div>").insertAfter('.fm-names.remove');

// hover icons

$('.icons li').hover(
    function() { $(this).addClass('ui-state-hover'); },
    function() { $(this).removeClass('ui-state-hover'); }
);

// add & remove followingme-list

$('.button').click(function() {
    var screen_name = $.trim($(this).siblings().text());
    if ($(this).siblings().hasClass('add')) {
	var options = $.trim($('#options').html());
	if (!options) {
	    $.post('addemail.php', { addemail: screen_name });
	    function email() { window.location.replace('register.php') };
	    $('#fm-followers').ajaxSuccess(email);
	}
	else {
	    $(this).siblings().fadeOut('slow');
	    $(this).fadeOut('slow');
	    if (!$.browser.msie) { $(this).siblings().html('added').css('color', 'green'); }
	    $.post('add.php', { add: screen_name });
	    function reload() { window.location.reload() };
	    $('#fm-followers').ajaxSuccess(reload);
	}
    }
    else {
	$(this).siblings().effect("puff", 550);
	$(this).effect("puff", 550);
	$.post('remove.php', { remove: screen_name });
    }
});