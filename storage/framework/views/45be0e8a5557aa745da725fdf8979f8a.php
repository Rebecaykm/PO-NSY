<tr style='mso-yfti-irow:1;height:7.1pt'>
    <td width="3%" valign=top style='width:3.36%;border:solid windowtext 1.0pt; border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt; padding:0cm 5.4pt 0cm 5.4pt;height:7.1pt'>
        <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'>
            <span style='font-size:6.0pt;font-family:"Arial",sans-serif'>
                
                <?php echo e($i+1); ?>

            </span>
        </p>
    </td>
    <td width="13%" valign=top style='width:13.34%;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:7.1pt'>
        <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'>
            <span style='font-size:6.0pt;font-family:"Arial",sans-serif'>
                <?php echo e($UniqueLines[$i]->PPROD); ?>

            </span>
        </p>
    </td>
    <td width="28%" valign=top style='width:28.58%;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:7.1pt'>
        <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'>
            <span style='font-size:6.0pt;font-family:"Arial",sans-serif'>
                <?php echo e($UniqueLines[$i]->PODESC); ?>

            </span>
        </p>
    </td>
    <td width="3%" valign=top style='width:3.94%;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:7.1pt'>
        <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;line-height:normal'>
            <span style='font-size:6.0pt;font-family:"Arial",sans-serif'>
                <?php echo e($UniqueLines[$i]->PUM); ?>

            </span>
        </p>
    </td>
    <?php
        // Para cada producto único en UniqueLines
        $PDDTE = $TotalLines->filter(function ($line) use ($UniqueLines, $i) {
            // Filtrar donde el campo PPROD coincida con el producto actual en UniqueLines
            return $line->PPROD == $UniqueLines[$i]->PPROD;
        })->max('PDDTE'); // Obtener la fecha más grande

        // Convertir la fecha a formato d/m/Y
        $formattedDate = \Carbon\Carbon::createFromFormat('Ymd', $PDDTE)->format('d/m/Y');
    ?>
    <td width="6%" valign=top style='width:6.9%;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:7.1pt'>
        <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;line-height:normal'>
            <span style='font-size:6.0pt;font-family:"Arial",sans-serif'>
                <?php echo e($formattedDate); ?>

            </span>
        </p>
    </td>
    <?php
        // Para cada producto único en UniqueLines
        $PQORD = $TotalLines->filter(function ($line) use ($UniqueLines, $i) {
            // Filtrar donde el campo PPROD coincida con el producto actual en UniqueLines
            return $line->PPROD == $UniqueLines[$i]->PPROD;
        })->sum('PQORD'); // Sumar el campo PQORD de las líneas filtradas
    ?>
    <td width="7%" valign=top style='width:7.88%;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:7.1pt'>
        <p class=MsoNormal align=right style='margin-bottom:0cm;text-align:right;line-height:normal'>
            <span style='font-size:6.0pt;font-family:"Arial",sans-serif'>
                <?php echo e(number_format($PQORD)); ?>

            </span></span>
        </p>
    </td>
    <td width="10%" valign=top style='width:10.68%;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:7.1pt'>
        <p class=MsoNormal align=right style='margin-bottom:0cm;text-align:right;line-height:normal'>
            <span style='font-size:6.0pt;font-family:"Arial",sans-serif'>
                <?php echo e(number_format($UniqueLines[$i]->PECST,2)); ?>

            </span>
        </p>
    </td>
    <td width="10%" valign=top style='width:10.6%;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:7.1pt'>
        <p class=MsoNormal align=right style='margin-bottom:0cm;text-align:right;line-height:normal'>
            <span style='font-size:6.0pt;font-family:"Arial",sans-serif'>
                <?php echo e(number_format($UniqueLines[$i]->PQORD * $UniqueLines[$i]->PECST,2)); ?>

            </span>
        </p>
    </td>
    <td width="14%" valign=top style='width:14.72%;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:7.1pt'>
        <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'>
            <span style='font-size:6.0pt;font-family:"Arial",sans-serif'></span>
        </p>
    </td>
</tr><?php /**PATH C:\xampp\htdocs\PO-MSY\resources\views/partials/lineas.blade.php ENDPATH**/ ?>