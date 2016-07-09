<?php
class EmailTestingController extends BaseController {

  /**-------------------------------------------------------------------------
  * main(): 
  *                 
  * @return Response
  *-------------------------------------------------------------------------*/
  public function main() {

    $pdfBasePath = public_path('uplds/orderpdfs');

    $doShortContent = 0;
    $doLongContent = 1;

    if($doShortContent) {
      $shortcontent = "Really simple test.";
      $pdfInstance = new \Thujohn\Pdf\Pdf();
      $pdfContent = $pdfInstance->load($shortcontent, 'letter','portrait')
        ->output();
      $outputName = 'TestPDF-'.date('U');
      $pdfPathPO = $pdfBasePath.'/'.$outputName.'.pdf';
      File::put($pdfPathPO, $pdfContent);

    }

    if($doLongContent) {
      $image[0] = '<img src="'.public_path('images/cartel-logo.png').'" alt="" width="285">';
      $image[1] = '<img src="'.public_path('/images/letterhead_dot.gif').'" width="8" height="8" alt="">';
      $image[2] = '<img src="'.public_path('/images/letterhead_dot.gif').'" width="8" height="8" alt="">';
      $image[3] = '<img src="'.public_path('/images/letterhead_dot.gif').'" width="8" height="8" alt="">';
      $longcontent='
<html>
<head>
  <title></title>
</head>
<body>
  <table width="560" border="0">
    <tr>
      <td align="left" valign="top" width="285">
      '.$image[0].'
      </td>
      <td valign="top" align="right" width="275"><b>Date: 2014-11-16 17:14:53<br> <font size="4">ORIGINAL PURCHASE ORDER</font><br><font size="4">Order#: W14347</font></b></td>
    </tr>
  </table>
  
  <br><br>

  <table width="560" border="0">
    <tr>
      <td width="50%"><b>Purchased From:</b></td>
      <td width="50%"><b> Salesman:</b></td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <td width="50%">JEV Marketing</td>
      <td width="50%">Peter B</td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <td width="50%">2880 Temple Dr #200</td>
      <td width="50%">Phone: 519-555-1234</td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <td width="50%">Windsor ON N8W 5J5<br>Canada</td>
      <td width="50%">Email: pbechard@gmail.com</td>
    </tr>
  </table>

  <br>
    
  <table width="560" border="0">
    <tr>
      <td width="10%"><b>Qty</b></td>
      <td width="43%"><b> Product</b></td>
      <td width="15%" ALIGN=right><b>Price</b></td>
      <td width="15%" ALIGN=right><b>Tax</b></td>
      <td width="17%" ALIGN=right><b>Total</b></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC" align="center">168</td>
      <td bgcolor="#CCCCCC">Outdoor (field) - Cucumber</td>
      <td bgcolor="#CCCCCC" align="right">$35.00</td>
      <td bgcolor="#CCCCCC" align="right">13.00%</td>
      <td bgcolor="#CCCCCC" align="right">$5880</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Brokerage</td>
      <td>&nbsp;</td>
      <td align="right">13%</td>
      <td bgcolor="#CCCCCC" align="right"> $ TBD </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Total Taxes</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td bgcolor="#CCCCCC" align="right">$ TBD</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><b>TOTAL</b></td>
      <td bgcolor="#CCCCCC" align="right">$ TBD</td>
    </tr>
  </table>

  <br>

  <table width="560" border="0">
    <tr>
      <td colspan=2>
        <div align="left"><b>Product Details:</b></div>
      </td>
    </tr>
    <tr>
      <td width="20%">
        <div align="right"><b>Origin:</b></div>
      </td>
      <td width="80%" bgcolor="#CCCCCC">Canada</td>
    </tr>
    <tr>
      <td>
        <div align="right"><b>Colour:</b></div>
      </td>
      <td bgcolor="#CCCCCC"> Green</td>
    </tr>
    <tr>
      <td>
        <div align="right"><b>Availability:</b></div>
      </td>
      <td bgcolor="#CCCCCC"> Nov 15 2014 between 9:00 AM and 5:00 PM</td>
    </tr>
    <tr>
      <td>
        <div align="right"><b>Comments:</b></div>
      </td>
      <td bgcolor="#CCCCCC"></td>
    </tr>
    <tr>
      <td>
        <div align="right"><b>Customer PO:</b></div>
      </td>
      <td bgcolor="#CCCCCC"><br></td>
    </tr>
  </table>

  <br><br>

  <table width="560" cellpadding="0" cellspacing="0" border="0">
    <tr>
      <td width="100%" height="2" colspan="2">
        <p>I have accurately prepared the above product for shipment.<br><br><b>Qty Shipped:  ________________</b><br>&nbsp;</p>
      </td>
    </tr>
    <tr>
      <td width="50%"><b>Shipper\'s Signature:<br><br> _____________________________</b></td>
      <td width="50%"><b>Print Name:<br><br> _____________________________</b></td>
    </tr>
    <tr>
      <td width="100%" height="2" colspan="2">
      <br><p><b>Please attach a signed copy of this Purchase Order to your Bill of Lading.</b></p>
      </td>
    </tr>
  </table>

  <table width="560" border="0">
    <tr>
      <td height="2" valign="top" align="center">__________________________________________________________</td>
    </tr>
    <tr>
      <td height="2">
      <div align="center">
        <b>Phone: (519)325-0111</b>
      '.$image[1].'
        <b>Fax: (519) 973-6222</b>
        <br>
        <b>PO Box 207</b>
      '.$image[2].'
        <b>Leamington, Ontario</b>
      '.$image[3].'
        <b>N8H 3W2</b>
        <br>
        <a href="mailto:info@cartelmarketing.org">info@cartelmarketing.org</a>
      </div>
      </td>
    </tr>
  </table>
</body>
</html>
						';
            
			$pdfInstance = new \Thujohn\Pdf\Pdf();
			$pdfContent = $pdfInstance->load($longcontent, 'letter', 'portrait')
        ->output();
			$outputName = 'TestPDF-'.date('U');
			$pdfPathPO = $pdfBasePath.'/'.$outputName.'.pdf';
			File::put($pdfPathPO, $pdfContent);
    }


    ///* Can only use this call format when generating one PDF  per page */ 
    //$outputName='TestPDF-'.str_random();
    //$pdfPathPO=$pdfBasePath.'/'.$outputName.'.pdf';
    //File::put($pdfPathPO, PDF::load($longcontent, 'letter', 'portrait')->output());
		$msg = "PDF Testing";

		//$emailData = array();
		//$emailData['Headline']="Mail Testing";
		//Mail::send('emails.email-testing-body', $emailData, function($message) {
      //$message->from('peter.bechard@fourthrealm.com', 'Cartel Marketing');
      //$message->to('pbechard@gmail.com', 'Peter Bechard');
      //$message->subject('Welcome!');
			////$message->attach($pathToFile);
		//});

    /* If in "Pretend Mode" show the email in a view */
    if(Config::get('mail.pretend'))
      return View::make('emails.email-testing');
		return View::make('email-testing')
			->with('pageData', $this->pageData)
			->with('msg', $msg);
	} // main()
} // class
?>
