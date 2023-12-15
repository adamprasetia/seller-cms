<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use Dompdf\Dompdf;
require 'vendor/autoload.php';

class Pdf_lib {

    function show($template = '', $filename = '')
    {
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml($template);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        #Esto es lo que imprime en el PDF el numero de paginas
        $canvas = $dompdf->get_canvas();
        $footer = $canvas->open_object();
        $w = $canvas->get_width();
        $h = $canvas->get_height();
        $canvas->page_text(35,$h-28,"print by simad page {PAGE_NUM}", 'helvetica',6);
        $canvas->page_text(35,10,"print by simad page {PAGE_NUM}", 'helvetica',6);

        // Output the generated PDF to Browser
        $dompdf->stream($filename.'.pdf', array("Attachment" => false));
    }
}