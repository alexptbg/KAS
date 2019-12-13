$('document').ready(function() {
    $('#side-menu').metisMenu();
    $(function() {
        $(window).bind("load", function() {
            console.log($(this).width())
            if ($(this).width() < 753) {
                $('div.sidebar-collapse').addClass('collapse')
            } else {
                $('div.sidebar-collapse').removeClass('collapse')
            }
        })
    })
    $(function() {
        $(window).bind("resize", function() {
            console.log($(this).width())
            if (this.innerWidth < 768) {
                $('div.sidebar-collapse').addClass('collapse')
            } else {
                $('div.sidebar-collapse').removeClass('collapse')
            }
        })
    });
    var allchecked = false;
    $(".btn-chk").click(function() {
        if (allchecked) {
            allchecked = false;
            $('input:checkbox').prop('checked', 0);
        } else {
            allchecked = true;
            $('input:checkbox').prop('checked', 1);
        }
    });
    $('.tooltipx').tooltip({
        selector: "[data-toggle=tooltip]"
    });
});
function infoModal(title,content,color) {
	//usage = infoModal("titlex","this is a contentex","header-color");
	//green=#5CB85C red=#d9534f primary=#428bca info=#5bc0de warning=#ffb70a
	$("#infoModal").on("show.bs.modal", function(e) {
		$(this).find(".modal-header").css({ "background-color":color });
		$(this).find("h4.modal-title").text(title);
		$(this).find(".modal-body").html(content);
		$(this).find(".modal-footer").html('<button type="button" class="btn btn-themed" data-dismiss="modal">OK</button>');
	});
	$('#infoModal').modal('show');
	return false;
}