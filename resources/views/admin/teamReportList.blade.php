<html xmlns:x="urn:schemas-microsoft-com:office:excel">
    <head>
        <!--[if gte mso 9]>
        <xml>
            <x:ExcelWorkbook>
                <x:ExcelWorksheets>
                    <x:ExcelWorksheet>
                        <x:Name>Sheet 1</x:Name>
                        <x:WorksheetOptions>
                            <x:Print>
                                <x:ValidPrinterInfo/>
                            </x:Print>
                        </x:WorksheetOptions>
                    </x:ExcelWorksheet>
                </x:ExcelWorksheets>
            </x:ExcelWorkbook>
        </xml>
        <![endif]-->
    </head>
    <body>
        <table border="1">
            @switch($report)
                @case(1)
                    <tr>
                        <th  style="font-weight: bold; color: rgb(255, 255, 255); background: rgb(126, 192, 219);">{!! mb_convert_encoding('Data',  "HTML-ENTITIES", "UTF-8") !!}</th>
                        <th  style="font-weight: bold; color: rgb(255, 255, 255); background: rgb(126, 192, 219);">{!! mb_convert_encoding('Jussara',  "HTML-ENTITIES", "UTF-8") !!}</th>
                        <th  style="font-weight: bold; color: rgb(255, 255, 255); background: rgb(126, 192, 219);">{!! mb_convert_encoding('Mônica Luri', "HTML-ENTITIES", "UTF-8") !!}</th>
                        <th  style="font-weight: bold; color: rgb(255, 255, 255); background: rgb(126, 192, 219);">{!! mb_convert_encoding('Mônica Lopes', "HTML-ENTITIES", "UTF-8") !!}</th>
                        <th  style="font-weight: bold; color: rgb(255, 255, 255); background: rgb(126, 192, 219);">{!! mb_convert_encoding('Sistema', "HTML-ENTITIES", "UTF-8") !!}</th>
                        <th  style="font-weight: bold; color: rgb(255, 255, 255); background: rgb(126, 192, 219);">{!! mb_convert_encoding('Total', "HTML-ENTITIES", "UTF-8") !!}</th>
                    </tr>
                    @break
                @case(2)
                    <tr>
                        <th  style="font-weight: bold; color: rgb(255, 255, 255); background: rgb(126, 192, 219);">{!! mb_convert_encoding('Data',  "HTML-ENTITIES", "UTF-8") !!}</th>
                        <th  style="font-weight: bold; color: rgb(255, 255, 255); background: rgb(126, 192, 219);">{!! mb_convert_encoding('Total Clipadora',  "HTML-ENTITIES", "UTF-8") !!}</th>
                        <th  style="font-weight: bold; color: rgb(255, 255, 255); background: rgb(126, 192, 219);">{!! mb_convert_encoding('Total Manual', "HTML-ENTITIES", "UTF-8") !!}</th>
                        <th  style="font-weight: bold; color: rgb(255, 255, 255); background: rgb(126, 192, 219);">{!! mb_convert_encoding('Classificadas', "HTML-ENTITIES", "UTF-8") !!}</th>
                        <th  style="font-weight: bold; color: rgb(255, 255, 255); background: rgb(126, 192, 219);">{!! mb_convert_encoding('Não Classificadas', "HTML-ENTITIES", "UTF-8") !!}</th>
                        <th  style="font-weight: bold; color: rgb(255, 255, 255); background: rgb(126, 192, 219);">{!! mb_convert_encoding('URL\'s Total', "HTML-ENTITIES", "UTF-8") !!}</th>
                        <th  style="font-weight: bold; color: rgb(255, 255, 255); background: rgb(126, 192, 219);">{!! mb_convert_encoding('URL\'s Inseridas', "HTML-ENTITIES", "UTF-8") !!}</th>
                        <th  style="font-weight: bold; color: rgb(255, 255, 255); background: rgb(126, 192, 219);">{!! mb_convert_encoding('URL\'s Não Inseridas', "HTML-ENTITIES", "UTF-8") !!}</th>
                        <th  style="font-weight: bold; color: rgb(255, 255, 255); background: rgb(126, 192, 219);">{!! mb_convert_encoding('Total Pedentes', "HTML-ENTITIES", "UTF-8") !!}</th>
                    </tr>
                    @break
                @case(3)
                    <tr>
                        <th  style="font-weight: bold; color: rgb(255, 255, 255); background: rgb(126, 192, 219);">{!! mb_convert_encoding('Data',  "HTML-ENTITIES", "UTF-8") !!}</th>
                        <th  style="font-weight: bold; color: rgb(255, 255, 255); background: rgb(126, 192, 219);">{!! mb_convert_encoding('Total',  "HTML-ENTITIES", "UTF-8") !!}</th>
                        <th  style="font-weight: bold; color: rgb(255, 255, 255); background: rgb(126, 192, 219);">{!! mb_convert_encoding('Total Verificado', "HTML-ENTITIES", "UTF-8") !!}</th>
                        <th  style="font-weight: bold; color: rgb(255, 255, 255); background: rgb(126, 192, 219);">{!! mb_convert_encoding('Jussara', "HTML-ENTITIES", "UTF-8") !!}</th>
                        <th  style="font-weight: bold; color: rgb(255, 255, 255); background: rgb(126, 192, 219);">{!! mb_convert_encoding('Mônica Luri', "HTML-ENTITIES", "UTF-8") !!}</th>
                        <th  style="font-weight: bold; color: rgb(255, 255, 255); background: rgb(126, 192, 219);">{!! mb_convert_encoding('Mônica Lopes', "HTML-ENTITIES", "UTF-8") !!}</th>
                        <th  style="font-weight: bold; color: rgb(255, 255, 255); background: rgb(126, 192, 219);">{!! mb_convert_encoding('Sheyla', "HTML-ENTITIES", "UTF-8") !!}</th>
                        <th  style="font-weight: bold; color: rgb(255, 255, 255); background: rgb(126, 192, 219);">{!! mb_convert_encoding('Sistema',    "HTML-ENTITIES", "UTF-8") !!}</th>
                    </tr>
                    @break
            @endswitch

            @foreach ($rs as $item)
                @switch($report)
                    @case(1)
                            <tr>
                            <td>{!! mb_convert_encoding($item->date, "HTML-ENTITIES", "UTF-8") !!}</td>
                            <td>{!! mb_convert_encoding($item->jussara, "HTML-ENTITIES", "UTF-8") !!}</td>
                            <td>{!! mb_convert_encoding($item->monica_luri, "HTML-ENTITIES", "UTF-8") !!}</td>
                            <td>{!! mb_convert_encoding($item->monica_lopes, "HTML-ENTITIES", "UTF-8") !!}</td>
                            <td>{!! mb_convert_encoding($item->system, "HTML-ENTITIES", "UTF-8") !!}</td>
                            <td>{!! mb_convert_encoding($item->total, "HTML-ENTITIES", "UTF-8") !!}</td>
                        </tr>
                        @break
                    @case(2)
                            <tr>
                            <td>{!! mb_convert_encoding($item->date, "HTML-ENTITIES", "UTF-8") !!}</td>
                            <td>{!! mb_convert_encoding($item->total_clipping, "HTML-ENTITIES", "UTF-8") !!}</td>
                            <td>{!! mb_convert_encoding($item->total_manual, "HTML-ENTITIES", "UTF-8") !!}</td>
                            <td>{!! mb_convert_encoding($item->indexed, "HTML-ENTITIES", "UTF-8") !!}</td>
                            <td>{!! mb_convert_encoding($item->no_indexed, "HTML-ENTITIES", "UTF-8") !!}</td>
                            <td>{!! mb_convert_encoding($item->url_total, "HTML-ENTITIES", "UTF-8") !!}</td>
                            <td>{!! mb_convert_encoding($item->url_indexed, "HTML-ENTITIES", "UTF-8") !!}</td>
                            <td>{!! mb_convert_encoding($item->url_total - $item->url_indexed, "HTML-ENTITIES", "UTF-8") !!}</td>
                            <td>{!! mb_convert_encoding($item->url_total - $item->url_indexed + $item->no_indexed, "HTML-ENTITIES", "UTF-8") !!}</td>
                        </tr>
                        @break
                    @case(3)
                        <tr>
                            <td>{!! mb_convert_encoding($item->date, "HTML-ENTITIES", "UTF-8") !!}</td>
                            <td>{!! mb_convert_encoding($item->total, "HTML-ENTITIES", "UTF-8") !!}</td>
                            <td>{!! mb_convert_encoding($item->total_indexed, "HTML-ENTITIES", "UTF-8") !!}</td>
                            <td>{!! mb_convert_encoding($item->jussara, "HTML-ENTITIES", "UTF-8") !!}</td>
                            <td>{!! mb_convert_encoding($item->monica_luri, "HTML-ENTITIES", "UTF-8") !!}</td>
                            <td>{!! mb_convert_encoding($item->monica_lopes, "HTML-ENTITIES", "UTF-8") !!}</td>
                            <td>{!! mb_convert_encoding($item->sheyla, "HTML-ENTITIES", "UTF-8") !!}</td>
                            <td>{!! mb_convert_encoding($item->system, "HTML-ENTITIES", "UTF-8") !!}</td>
                        </tr>
                        @break
                @endswitch
            @endforeach
        </table>
    </body>
