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
            <tr>
                <td>
                    <table>
                        <tr style="font-weight: bold; color: rgb(255, 255, 255); background: rgb(126, 192, 219);">
                            <th>{!! mb_convert_encoding('URL',  "HTML-ENTITIES", "UTF-8") !!}</th>
                            <th>{!! mb_convert_encoding('Pendência',  "HTML-ENTITIES", "UTF-8") !!}</th>
                            <th>{!! mb_convert_encoding('Status', "HTML-ENTITIES", "UTF-8") !!}</th>
                            <th>{!! mb_convert_encoding('Data', "HTML-ENTITIES", "UTF-8") !!}</th>
                        </tr>
                        @foreach ($data as $item)
                            <tr>
                                <td>{!! mb_convert_encoding($item->url, "HTML-ENTITIES", "UTF-8") !!}</td>
                                <td>{!! mb_convert_encoding($item->type->description, "HTML-ENTITIES", "UTF-8") !!}</td>
                                <td>{!! mb_convert_encoding($item->register ? 'Inserido' : 'Pendente', "HTML-ENTITIES", "UTF-8") !!}</td>
                                <td>{!! mb_convert_encoding($item->created_at->format('d/m/Y H:i'), "HTML-ENTITIES", "UTF-8") !!}</td>
                            </tr>
                        @endforeach
                        <tr style="font-weight: bold; background: rgb(233, 226, 195);">
                            <td colspan="4">{!! mb_convert_encoding('Total :: ', "HTML-ENTITIES", "UTF-8") . $total !!}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
