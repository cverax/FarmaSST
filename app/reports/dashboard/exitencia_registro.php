<?php
require('../../helpers/report.php');
require('../../models/productos.php');
 // Se instancia el módelo Categorias para procesar los datos.
 $Vendedor = new Productos;

 // Se verifica si el parámetro es un valor correcto, de lo contrario se direcciona a la página web de origen.
 if ($Vendedor->setId($_GET['id'])) {
     // Se verifica si la categoría del parametro existe, de lo contrario se direcciona a la página web de origen.
     if ($rowVendedor = $Vendedor->readOne()) {
         // Se instancia la clase para crear el reporte.
         $pdf = new Report;
         // Se inicia el reporte con el encabezado del documento.
         $pdf->startReport('Nombre del producto: '.$rowVendedor['nombreproducto']);
         // Se verifica si existen registros (productos) para mostrar, de lo contrario se imprime un mensaje.
         if ($dataProductos = $Vendedor->nosepa()) {
             // Se establece un color de relleno para los encabezados.
             $pdf->SetFillColor(225);
             // Se establece la fuente para los encabezados.
             $pdf->SetFont('Times', 'B', 11);
             // Se imprimen las celdas con los encabezados.
             $pdf->Cell(50, 10, utf8_decode('VTA'), 1, 0, 'C', 1);
             $pdf->Cell(65, 10, utf8_decode('Documento'), 1, 0, 'C', 1);
             $pdf->Cell(45, 10, utf8_decode('Lote'), 1, 0, 'C', 1);
             $pdf->Cell(26, 10, utf8_decode('Cantidad'), 1, 1, 'C', 1);
             // Se establece la fuente para los datos de los productos.
             $pdf->SetFont('Times', '', 11);
             // Se recorren los registros ($dataProductos) fila por fila ($rowProducto).
             foreach ($dataProductos as $rowProducto) {
                $pdf->Cell(50, 10, utf8_decode($rowProducto['vta']), 1, 0);
                $pdf->Cell(65, 10, $rowProducto['documentos'], 1, 0);
                $pdf->Cell(45, 10, $rowProducto['lote'], 1, 0);
                $pdf->Cell(26, 10, $rowProducto['cantidad'], 1, 1);
             }
         } else {
             $pdf->Cell(0, 10, utf8_decode('No hay productos para esta categoría'), 1, 1);
         }
         // Se envía el documento al navegador y se llama al método Footer()
         $pdf->Output();
     } else {
        $pdf->Cell(0, 10, utf8_decode('error en al buscar'), 1, 1);
     }
 } else {
    header('location: ../../../views/vendedor.php');
 }

?>