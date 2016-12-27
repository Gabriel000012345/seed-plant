<?php
	define('PDF_CATALOG_TEMPLATE_CSS', '
		<style>
             
			h2 {
				font-size: 140%;
				font-weight: bold;
			}
			p{
				margin: 0;
			}
			table.pdf_table {
				width:100%;
			}
			td {
				text-align: left;
				padding: 3px
			}
			th{
				text-align: center !important;
			}
			td.pdf_category{
				font-size:20px;
				background-color:#EFEFEF;
				padding:20px;
			}

			/*ul.pdf_product_ul{
				list-style-type:none;
				margin:0px;
				margin:0px;
				padding:0px;
			}*/
			.index{
				text-align: center;
				width: 5%;
			}
			.prod{
				width: 60%;
			}
			.price{
				padding: 0px;
				width: 35%;
			}
			.page_break{
				page-break-before: always;
			}
		</style>
		
	');
	
	define('PDF_TOC_TITLE', '
		<h2>{::category_title}</h2><br>
	');
	
	define('PDF_TOC_CATEGORY', '
		<h2>{::category_name} ({::product_cnt})</h2><br>
	');
	
	define('PDF_CATALOG_TEMPLATE_CATEGORY', '
		<table class="pdf_table" cellpadding="0px" cellspacing="0" border="1">
		<tr>
			<td colspan="3" class="pdf_category">{::category_name}</td>
		</tr>
		<tr>
			<th class="index"><b>Nr. Crt.</b></th>
			<th class="prod"><b>Produs</b></th>
			<th class="price"><b>Preturi</b></th>
		</tr>
		{::products}
		</table>
	');
	
	define('PDF_CATALOG_TEMPLATE_PRODUCT', '
		<tr>
			<td class="index"><b>{::product_cnt}</b></td>
			<td class="prod">
				<table cellpadding="2px" cellspacing="0" border="0">
					<tr><td style="width: 34%;"><strong>{::txt_product_name}</strong></td><td style="width: 66%;">{::product_name}</td></tr>
					<tr><td style="width: 34%;"><strong>{::txt_product_subst}</strong></td><td style="width: 66%;">{::product_subst}</td></tr>
				</table>
			</td>
			<td class="price">
				{::product_options}
			</td>
		</tr>
	');
?>
