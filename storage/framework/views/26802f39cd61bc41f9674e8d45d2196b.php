<table class=Tablaconcuadrcula border=1 cellspacing=0 cellpadding=0 width="100%" style='width:100.0%;border-collapse:collapse;border:none;mso-border-alt:solid windowtext .5pt; mso-yfti-tbllook:1184;mso-padding-alt:0cm 5.4pt 0cm 5.4pt'>
    <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes;height:7.1pt'>
        <td width="23%" rowspan=6 style='width:23.64%;border:none;border-right:solid windowtext 1.0pt;mso-border-right-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:7.1pt'>
            <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;line-height:normal'>
                <span lang=ES style='font-size:6.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES'>
                    PURCHASE ORDER
                </span>
            </p>
            <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;line-height:normal'>
                <span lang=ES style='font-size:6.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES'>
                    ORDEN DE COMPRA<o:p></o:p>
                </span>
            </p>
            <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;line-height:normal'>
                <span style='font-size:6.0pt;font-family:"Arial",sans-serif;mso-ligatures:none;mso-no-proof:yes'>
                    <img width=156 height=81
                        id="_x0000_i1025"
                        src="https://ii.ct-stc.com/2/logos/empresas/2017/04/25/y-tec-keylex-mexico-sa-de-cv-9460030D8482506E170225thumbnail.jpeg"
                        alt="Y-TEC KEYLEX MEXICO México">
                </span>
                <span style='font-size:6.0pt;font-family:"Arial",sans-serif'></span>
            </p>
        </td>
        <td width="25%" valign=top style='width:25.6%;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:7.1pt'>
            <p class=MsoNormal align=right style='margin-bottom:0cm;text-align:right;line-height:normal'>
                <span class=SpellE>
                    <span lang=ES style='font-size:6.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES'>
                        Kind of Order
                    </span>
                    <span style='font-size:6.0pt;font-family:"Arial",sans-serif'></span>
                </span>
            </p>
        </td>
        <td width="25%" valign=top style='width:25.6%;border:solid windowtext 1.0pt;border-left:none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:7.1pt'>
            <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;line-height:normal'>
                <span lang=ES style='font-size:6.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES'>
                    CLOSE PURCHASE ORDER
                </span>
                <span style='font-size:6.0pt;font-family:"Arial",sans-serif'></span>
            </p>
        </td>
        <td width="25%" rowspan=6 style='width:25.16%;border:solid windowtext 1.0pt;border-left:none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:7.1pt'>
        <?php
            $PROVEEDOR = App\Models\AVM::where('VENDOR',$PO->PVEND)->first();
        ?>
        <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;line-height:normal'>
            <span lang=EN-US style='font-size:6.0pt;font-family:"Arial",sans-serif;mso-ansi-language:EN-US'>
                <?php echo e($PO->PVEND); ?>

            </span>
        </p>
        
        <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;line-height:normal'>
            <span lang=EN-US style='font-size:6.0pt;font-family:"Arial",sans-serif;mso-ansi-language:EN-US'>
                <?php echo e($PROVEEDOR->VNDNAM); ?>

            </span>
        </p>
        <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
        line-height:normal'><span lang=EN-US style='font-size:6.0pt;font-family:"Arial",sans-serif;
        mso-ansi-language:EN-US'></span></p>
        </td>
    </tr>
    <tr style='mso-yfti-irow:1;height:7.1pt'>
        <td width="25%" valign=top style='width:25.6%;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:7.1pt'>
            <p class=MsoNormal align=right style='margin-bottom:0cm;text-align:right;line-height:normal'>
                <span class=SpellE>
                    <span lang=ES style='font-size:6.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES'>
                        Purchase Order # 
                    </span>
                    <span style='font-size:6.0pt;font-family:"Arial",sans-serif'></span>
                </span>
            </p>
        </td>
        <td width="25%" valign=top style='width:25.6%;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:7.1pt'>
            <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;line-height:normal'>
                <span lang=ES style='font-size:6.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES'>
                <?php echo e($PO->PORD); ?>

                </span>
                <span style='font-size:6.0pt;font-family:"Arial",sans-serif'></span>
            </p>
        </td>
    </tr>
    <tr style='mso-yfti-irow:2;height:7.1pt'>
        <td width="25%" valign=top style='width:25.6%;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:7.1pt'>
            <p class=MsoNormal align=right style='margin-bottom:0cm;text-align:right;line-height:normal'>
                <span class=SpellE>
                    <span lang=ES style='font-size:6.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES'>
                        REQ #
                    </span>
                    <span style='font-size:6.0pt;font-family:"Arial",sans-serif'></span>
                </span>
            </p>
        </td>
        <td width="25%" valign=top style='width:25.6%;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:7.1pt'>
            <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;line-height:normal'>
                <span lang=ES style='font-size:6.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES'>
                    
                    <?php echo e($UniqueLines[0]->POSRCE); ?>

                </span>
                <span style='font-size:6.0pt;font-family:"Arial",sans-serif'></span>
            </p>
        </td>
    </tr>
    <tr style='mso-yfti-irow:3;height:7.1pt'>
        <td width="25%" valign=top style='width:25.6%;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:7.1pt'>
            <p class=MsoNormal align=right style='margin-bottom:0cm;text-align:right;line-height:normal'>
                <span class=SpellE>
                    <span lang=ES style='font-size:6.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES'>
                        Currency
                    </span>
                    <span style='font-size:6.0pt;font-family:"Arial",sans-serif'></span>
                </span>
            </p>
        </td>
        <td width="25%" valign=top style='width:25.6%;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:7.1pt'>
            <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;line-height:normal'>
                <span lang=ES style='font-size:6.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES'>
                    <?php echo e($PO->POCUR); ?>

                </span><span style='font-size:6.0pt;font-family:"Arial",sans-serif'></span>
            </p>
        </td>
    </tr>
    <tr style='mso-yfti-irow:1;height:7.1pt'>
        <td width="25%" valign=top style='width:25.6%;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:7.1pt'>
            <p class=MsoNormal align=right style='margin-bottom:0cm;text-align:right;line-height:normal'>
                <span class=SpellE>
                    <span lang=ES style='font-size:6.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES'>
                        Date
                    </span>
                    <span style='font-size:6.0pt;font-family:"Arial",sans-serif'></span>
                </span>
            </p>
        </td>
        <td width="25%" valign=top style='width:25.6%;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:7.1pt'>
            <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;line-height:normal'>
                <span lang=ES style='font-size:6.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES'>
                    <?php echo e(Carbon\Carbon::today()->format('d/m/Y')); ?>

                </span>
                <span style='font-size:6.0pt;font-family:"Arial",sans-serif'></span>
            </p>
        </td>
    </tr>
    <tr style='mso-yfti-irow:5;mso-yfti-lastrow:yes'>
        <td width="51%" colspan=2 valign=top style='width:51.2%;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt; mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt; mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
            <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;line-height:90%'>
                <span class=SpellE>
                    <span lang=ES style='font-size:6.0pt;line-height:90%;font-family:"Arial",sans-serif;mso-ansi-language:ES'>
                        Invoice information
                    </span>
                </span>
                <span style='font-size:6.0pt;line-height:90%;font-family:"Arial",sans-serif'></span>
            </p>
            <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;line-height:90%'>
                <span lang=ES style='font-size:6.0pt;line-height:90%;font-family:"Arial",sans-serif;mso-ansi-language:ES'>
                    Y-Tec Keylex Mexico, S.A. de C.V GTK111107f89
                </span>
                <span style='font-size:6.0pt;line-height:90%;font-family:"Arial",sans-serif'></span>
            </p>
            <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;line-height:90%'>
                <span lang=ES style='font-size:6.0pt;line-height:90%;font-family:"Arial",sans-serif;mso-ansi-language:ES'>
                    Av. HIROSHIMA No. 1000, INT.5 COMPLEJO INDUSTRIAL
                </span>
                <span style='font-size:6.0pt;line-height:90%;font-family:"Arial",sans-serif'></span>
            </p>
            <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;line-height:normal'>
                <span lang=ES style='font-size:6.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES'>
                    SALAMANCA, Salamanca Guanajuato, Mexico C.P.36875
                </span>
                <span style='font-size:6.0pt;font-family:"Arial",sans-serif'></span>
            </p>
        </td>
    </tr>
</table><?php /**PATH C:\xampp\htdocs\PO-MSY\resources\views/partials/encabezado.blade.php ENDPATH**/ ?>