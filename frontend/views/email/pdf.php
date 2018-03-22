 <?php
 
 use frontend\controllers\EmailController;
 
    require('phpToPDF.php');
	
	
    //Your HTML in a variable
	
    //Your HTML in a variable
   /* $my_html="<html lang=\"en\">
  <head>
    <meta charset=\"UTF-8\">
    <title>Sample Invoice</title>
  </head>
  
  <body>
    <div class=\"container\">
      <div class=\"row\">
        <div class=\"col-xs-6\">
        </div>
        <div class=\"col-xs-6 text-right\">
          <h1>INVOICE</h1>
          <h1><small>Invoice #001</small></h1>
        </div>
      </div>
      <div class=\"row\">
        <div class=\"col-xs-5\">
          <div class=\"panel panel-default\">
            <div class=\"panel-heading\">
              <h4>From: Your Name</h4>
            </div>
            <div class=\"panel-body\">
              <p>
                Address <br>
                details <br>
                more <br>
              </p>
            </div>
          </div>
        </div>
        <div class=\"col-xs-5 col-xs-offset-2 text-right\">
          <div class=\"panel panel-default\">
            <div class=\"panel-heading\">
              <h4>To : Client Name</h4>
            </div>
            <div class=\"panel-body\">
              <p>
                Address <br>
                details <br>
                more <br>
              </p>
            </div>
          </div>
        </div>
      </div>
      <!-- / end client details section -->
      <table class=\"table table-bordered\">
        <thead>
          <tr>
            <th>
              <h4>Service</h4>
            </th>
            <th>
              <h4>Description</h4>
            </th>
            <th>
              <h4>Hrs/Qty</h4>
            </th>
            <th>
              <h4>Rate/Price</h4>
            </th>
            <th>
              <h4>Sub Total</h4>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Article</td>
            <td>Title of your article here</td>
            <td class=\"text-right\">-</td>
            <td class=\"text-right\">$200.00</td>
            <td class=\"text-right\">$200.00</td>
          </tr>
          <tr>
            <td>Template Design</td>
            <td>Details of project here</td>
            <td class=\"text-right\">10</td>
            <td class=\"text-right\">75.00</td>
            <td class=\"text-right\">$750.00</td>
          </tr>
          <tr>
            <td>Development</td>
            <td>WordPress Blogging theme</td>
            <td class=\"text-right\">5</td>
            <td class=\"text-right\">50.00</td>
            <td class=\"text-right\">$250.00</td>
          </tr>
        </tbody>
      </table>
      <div class=\"row text-right\">
        <div class=\"col-xs-2 col-xs-offset-8\">
          <p>
            <strong>
            Sub Total : <br>
            TAX : <br>
            Total : <br>
            </strong>
          </p>
        </div>
        <div class=\"col-xs-2\">
          <strong>
          $1200.00 <br>
          N/A <br>
          $1200.00 <br>
          </strong>
        </div>
      </div>
      <div class=\"row\">
        <div class=\"col-xs-5\">
          <div class=\"panel panel-info\">
            <div class=\"panel-heading\">
              <h4>Bank details</h4>
            </div>
            <div class=\"panel-body\">
              <p>Your Name</p>
              <p>Bank Name</p>
              <p>SWIFT : --------</p>
              <p>Account Number : --------</p>
              <p>IBAN : --------</p>
            </div>
          </div>
        </div>
        <div class=\"col-xs-7\">
          <div class=\"span7\">
            <div class=\"panel panel-info\">
              <div class=\"panel-heading\">
                <h4>Contact Details</h4>
              </div>
              <div class=\"panel-body\">
                <p>
                  Email : you@example.com <br><br>
                  Mobile : -------- <br><br><br>
                </p>
                <h4>Payment should be made by Bank Transfer</h4>
              </div>
            </div>
          </div>
        </div>
      </div>
      <br><br>
      This is a sample invoice.<br><br>
      In this example the css style is pulled from phptopdf.com/bootstrap.css
      You could also put all CSS in the header wrapped in <xmp> < style > </xmp> tags
    </div>
  </body>
</html>";*/

	    
		//$my_html=$model->content;
		$my_html= "<html>
		<body>
			<div style='border:1px solid;width:100%;'>
				<div style='width:49%;border:1px solid;float:left;color:red;'>id</div>
				<div style='width:49%;border:1px solid;float:right;'>".$model->id."</div>
			</div><br>
			<div style='border:1px solid;width:100%;'>
				<div style='width:49%;border:1px solid;float:left;'>email</div>
				<div style='width:49%;border:1px solid;float:right;'>".$model->email."</div>
			</div><br>
			

		</body>
		</html>";
	
    //Set Your Options -- we are saving the PDF as 'my_filename.pdf' to a 'my_pdfs' folder
    $pdf_options = array(
      "source_type" => 'html',
      "source" => $my_html,
      "action" => 'save',
      "save_directory" => '../pdfexport',
      "file_name" => 'my_filename18.pdf');

    //Code to generate PDF file from options above
    phptopdf($pdf_options);
	
	$path= '../pdfexport/my_filename18.pdf';
		$messsage = Yii::$app->mailer->compose('email', ['model' => $model])
				->setFrom('rupali.growfitter@gmail.com')
				->setTo($model->email)
				->setSubject('email')	
				->attach($path)
				->send();				
			


?> 