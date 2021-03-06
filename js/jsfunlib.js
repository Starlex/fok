function showDiv(chb1, div, chb2, form){
	var cke = $('.ckeditor').attr('name');
	if('checked' === $(chb1).attr('checked')){
		$(div).fadeIn();
		$('#btn_div').fadeIn();		
		$(chb2).attr('disabled', 'disable');
	}
	else{
		$(div).fadeOut();
		$('#btn_div').fadeOut();		
		$(chb2).removeAttr('disabled');
	}
}

// this function used in updating pages.
// It fills name of page and page content accourdingly to selected page.
$(document).ready(function(){
    $('#updPageId').change(function(){
        $.ajax({
            type: "POST",
            url: "/pages/ajax.php",
            data: "page_id="+$("#updPageId").val(),
            dataType: "json",
            success: function(data){
                if(false === data){
                	$("#pagedata").fadeOut();
                    $("#pName").val("");
                    CKEDITOR.instances.pContent.setData("");
                }
                else{
                	$("#pagedata").fadeIn();
                    $("#pName").val(data.name);
                    CKEDITOR.instances.pContent.setData(data.page_content);                        
                }
            }
        });
    return false;
    });
});

// this function used in updating subpages.
// It fills name of parrent page, subpage and subpage content accourdingly to selected page.
$(document).ready(function(){
	$('#updSubpageId').change(function(){
		$.ajax({
			type: "POST",
			url: "/pages/ajax.php",
			data: "subpage_id="+$("#updSubpageId").val(),
			dataType: "json",
			success: function(data){
				if(false === data){
					$("#subpagedata").fadeOut();
					$("#parrentId").val("");
	                $("#spName").val("");
	                CKEDITOR.instances.spContent.setData("");
				}
				else{
					$("#subpagedata").fadeIn();
					$("#parrentId").val(data.page_id);
	                $("#spName").val(data.name);
	                CKEDITOR.instances.spContent.setData(data.page_content);
				}
			}
		});
	return false;
	});
});
