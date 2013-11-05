<?php
$pageData = array(
				'link' => getPageNameAndLink($db)['link'],
				'tbl_name' => getPageNameAndLink($db)['tbl_name']
			);
echo getPageContent($db, $pageData);
?>