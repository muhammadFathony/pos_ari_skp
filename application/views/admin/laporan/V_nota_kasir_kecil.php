<?php
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Muhammad Fathony');
$pdf->SetTitle('Laporan Permintaan Barang');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' ', PDF_HEADER_STRING);

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT-6, PDF_MARGIN_TOP-4, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 6);
// set page format (read source code documentation for further information)
// MediaBox - width = urx - llx 210 (mm), height = ury - lly = 297 (mm) this is A4
$page_format = array(
    'MediaBox' => array ('llx' => 0, 'lly' => 0, 'urx' => 75, 'ury' => 297),
    //'CropBox' => array ('llx' => 0, 'lly' => 0, 'urx' => 210, 'ury' => 297),
    //'BleedBox' => array ('llx' => 5, 'lly' => 5, 'urx' => 205, 'ury' => 292),
    //'TrimBox' => array ('llx' => 10, 'lly' => 10, 'urx' => 200, 'ury' => 287),
    //'ArtBox' => array ('llx' => 15, 'lly' => 15, 'urx' => 195, 'ury' => 282),
    'Dur' => 3,
    'trans' => array(
        'D' => 1.5,
        'S' => 'Split',
        'Dm' => 'V',
        'M' => 'O'
    ),
    'Rotate' => 0,
    'PZ' => 1,
);

// Check the example n. 29 for viewer preferences

// add first page ---
// add a page
$pdf->AddPage('P', $page_format, false, false);


//
$pdf->Ln(3);

$content	=
'<style type="text/css">
	.tabel {border-collapse:collapse;
		border: 1px solid black;
		font-family: Arial, Helvetica, sans-serif;
	}
	.tabel th {padding:2px 2px;}
	.tabel td {padding:2px 2px;}
</style>';


	$content 	.= '<page style="font-size: 13px" orientation="paysage" format="140x210">
						<label style="font-size:17px;"><b>Graha Shop</b></label>
						<br>
						<label style="font-size:12px;">Desa Mekar Sari<br>Kec. Toili Barat - Sulawesi Tengah<br>
						Telp. (082) 290006989<label> <br><div></div>';

	$content 	.= '<table style="font-size:8px;">
						<tr>
							<td style="width: 58%;vertical-align: top;">
								<table style="font-size:13px; width:100%;">
									<tr style="padding:2px">
										<td style="width:85px;"><b>Nota</b></td>
										<td style="width:20px;">:</td>
										<td style="width:150px;">'.$data_jual->jual_nofak.'</td>
									</tr>
									<tr style="padding:2px">
										<td><b>Tanggal</b></td>
										<td>:</td>
										<td>'.$data_jual->tanggal.'</td>
									</tr>
									<tr style="padding:2px">
										<td><b>Kasir</b></td>
										<td>:</td>
										<td>'.$data_jual->user_nama.'</td>
									</tr>';
		$content .=		'</table>
							</td>
							
						</tr>
					</table>';
	$content	.= 
				'<div></div>
				<table style="width:100%; font-size:14px;">';

		$content	.= 
					'<tr>';
		$total_global = 0;
		$diskon_global = 0;
		$grantotal = 0;
		foreach ($data_jual_detail as $data_jual_detail ) {
		$total = $data_jual_detail->d_jual_qty*$data_jual_detail->d_jual_barang_harjul;
		$total_global += $total;
		$diskon_perbarang = $data_jual_detail->d_jual_qty * ($data_jual_detail->d_jual_barang_harjul * $data_jual_detail->d_jual_diskon / 100);
		$diskon_global += $diskon_perbarang;
		$grantotal += $total_global - $diskon_global;
			$content .= '<td style="text-align: left; width:105px;"><label style="text-transform: uppercase;">'.$data_jual_detail->d_jual_barang_id.'</label></td>';
		
			$content	.=	'<td style="text-align: left; width:90px;"></td>
					</tr>
					<tr>
						
						<td style="text-align:left; width:200px;"><label style="">'.$data_jual_detail->d_jual_barang_nama.'</label></td>
					</tr>
					<tr>
						<td style="text-align: left; width:70px;">'.number_format($data_jual_detail->d_jual_barang_harjul).'<br></td>
						<td style="text-align: left; width:15px;">x</td>
						<td style="text-align: left; width:35px;">'.$data_jual_detail->d_jual_qty.'</td>
						<td style="text-align: left; width:95px;"> = &nbsp; '.number_format($total).'</td>
						
					</tr>';
		}
	$content	.= '</table>';
	$content	.= 			'<table style="width: 100%; font-size:13px;">
								<tr>';

		// $content	.= 				'<td style="width: 60%;vertical-align: top;" rowspan="8">
		// 								<b>Keterangan : </b><br>' 
		// 								. $data->keterangan_jual .  '<br>
		// 								<table style="width:100%">
		// 							 		<tr>
		// 							 			<td style="width:25%;text-align: center;">Bag.Gudang</td>
		// 							 			<td style="width:25%;text-align: center;">Supir</td>
		// 							 			<td style="width:25%;text-align: center;">Penerima</td>
		// 							 			<td style="width:25%;text-align: center;">Hormat Kami</td>
		// 							 		</tr>
		// 							 		<tr>
		// 							 			<td style="width:25%;text-align: center; height:20px;"></td>
		// 							 			<td style="width:25%;text-align: center; height:20px;"></td>
		// 							 			<td style="width:25%;text-align: center; height:20px;"></td>
		// 							 			<td style="width:25%;text-align: center; height:20px;"></td>
		// 							 		</tr>
		// 							 		<tr>
		// 							 			<td style="width:25%;text-align: center;">.........</td>
		// 							 			<td style="width:25%;text-align: center;">.........</td>
		// 							 			<td style="width:25%;text-align: center;">.........</td>
		// 							 			<td style="width:25%;text-align: center;">.........</td>
		// 							 		</tr>
		// 							 	</table>
		// 				 			</td>';

	
		$content	.= 				'<td style="width: 100%;vertical-align: top; font-size:12px;" rowspan="7">
										<b>Keterangan : </b> </td>';

	$content 		.=				'<b style="display:none;">
									<td style="width: 20%;">Total</td>
									<td style="width: 5%;text-align: left;"">:</td>
									<td style="width: 15%;text-align: left;">fdghdh</td>
									</b>
								</tr>
								<b>
						 		<tr style="display:none;">
									<td style="width: 20%;">Ongkir</td>
									<td style="width: 5%;text-align: left;"">:</td>
									<td style="width: 15%;text-align: left;">cdfhdfgh</td>
								</tr>
								<div></div>
						 		<tr>
						 			<td style="width: 35%;"><p style="font-weight:bold;">Total</p></td>
						 			<td style="width: 2%;text-align: right;">:</td>
						 			<td style="width: 37%;text-align: right;">'.number_format($total_global).'</td>
						 		</tr>
						 		
						 		<tr>
						 			<td style="width: 35%;">Ongkir</td>
						 			<td style="width: 2%;text-align: right;">:</td>
						 			<td style="width: 37%;text-align: right;">0</td>
						 		</tr>
						 		<tr>
						 			<td style="width: 35%;">Diskon</td>
						 			<td style="width: 2%;text-align: right;">:</td>
						 			<td style="width: 37%;text-align: right;">'.number_format($diskon_global).' </td>
						 		</tr>
						 		
						 		<tr>
						 			<td style="width: 35%;">Grand Total</td>
						 			<td style="width: 2%;text-align: right;">:</td>
						 			<td style="width: 37%;text-align: right;">'.number_format($total_global - $diskon_global) .'</td>
						 		</tr>';
	
		$content		.=		'<tr>
						 			<td style="width: 35%;">Bayar Tunai</td>
						 			<td style="width: 2%;text-align: right;">:</td>
						 			<td style="width: 37%;text-align: right;">'.number_format($data_jual->jual_jml_uang).'</td>
								 </tr>';
		$content		.=		'<tr>
						 			<td style="width: 35%;">Kembali</td>
						 			<td style="width: 2%;text-align: right;">:</td>
						 			<td style="width: 37%;text-align: right;">'.number_format($data_jual->jual_jml_uang - ($total_global - $diskon_global)).'</td>
						 		</tr>';


		

		$content.=			'</b>
		<tr><br>
				 	<label style="font-size:12px;">Note :</label><br>
				 	<label style="font-size:12px;">Barang yang sudah di beli tidak dapat</label><br>
				 	<label style="font-size:12px;">dikembalikan atau di tukar</label></tr>
				 			</table>
				 	';

$content 		.= '</page>';

$pdf->writeHTMLCell(0, 0, '', '', $content, 0, 1, 0, true, '', true);
//Close and output PDF document
ob_clean();
$pdf->Output('Nota_jual'.time().'.pdf', 'I');

?>
