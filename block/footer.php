<script type="text/javascript">
    $(document).ready(function(){
        $('#updPageId').change(function(){
            $.ajax({
                type: "POST",
                url: "/pages/updpage.php",
                data: "page_id="+$("#updPageId").val(),
                dataType: "json",
                success: function(data){
                	$('#updPageId').attr('disabled', 'disable');
                    $("#pName").val(data.name);
                    CKEDITOR.instances.pContent.setData(data.page_content);
                }
            });
        return false;
        });
    });
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#parrentId').change(function(){
			$('#')
			});
		});
	});
</script>
</body>
</html>