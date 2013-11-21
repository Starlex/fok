function showDiv(chbID1, divID, chbID2){
	var chb1 = document.getElementById(chbID1).checked;
	var chb2 = document.getElementById(chbID2);
	var div = document.getElementById(divID).style;
	var btn = document.getElementById('btn_div').style;
	if(true === chb1){
		div.display = "block";
		chb2.disabled = true;
		btn.display = "block";
	}
	else{
		div.display = "none";
		chb2.disabled = false;
		btn.display = "none";
	}
}

// this function used in updating pages.
// If fills name of page and page content accourdingly to selected page.
$(document).ready(function(){
    $('#updPageId').change(function(){
        $.ajax({
            type: "POST",
            url: "/pages/updpage.php",
            data: "page_id="+$("#updPageId").val(),
            dataType: "json",
            success: function(data){
                if(false === data){
                	$("#pagedata").css("display", "none");
                    $("#pName").val("");
                    CKEDITOR.instances.pContent.setData("");
                }
                else{
                	$("#pagedata").css("display", "block");
                    $("#pName").val(data.name);
                    CKEDITOR.instances.pContent.setData(data.page_content);                        
                }
            }
        });
    return false;
    });
});

// this function used in updating subpages.
// If fills name of subpage and subpage content accourdingly to selected page.
$(document).ready(function(){
	$('#updSubpageId').change(function(){
		$.ajax({
			type: "POST",
			url: "/pages/updpage.php",
			data: "subpage_id="+$("#updSubpageId").val(),
			dataType: "json",
			success: function(data){
				if(false === data){
					$("#subpagedata").css("display", "none");
	                $("#spName").val("");
	                CKEDITOR.instances.spContent.setData("");
				}
				else{
					$("#subpagedata").css("display", "block");
	                $("#spName").val(data.name);
	                CKEDITOR.instances.spContent.setData(data.page_content);
				}
			}
		});
	return false;
	});
});
