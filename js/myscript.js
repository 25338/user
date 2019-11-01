//авто исчезновение сообщение
$("#message").delay(3000).fadeOut(300);

//таб бар модулей
$( "#tabs" ).tabs();

//drag drop
$("#delete").draggable({
	handle: ".modal-header"
});

$("#browser").draggable({
	handle: ".modal-header"
});

$("#edit").draggable({
	handle: ".modal-header"
});
