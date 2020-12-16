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
            <tr style="color: rgb(255, 255, 255); background: rgb(0, 151, 172);">
                <td><strong>Filtros</strong>{!! mb_convert_encoding($filter, "HTML-ENTITIES", "UTF-8") !!}</td>
            </tr>
            <tr>
                <td>
                    <table>
                        <tr style="font-weight: bold; color: rgb(255, 255, 255); background: rgb(126, 192, 219);">
                            <th>{!! mb_convert_encoding('Código',  "HTML-ENTITIES", "UTF-8") !!}</th>
                            <th>{!! mb_convert_encoding('Título',  "HTML-ENTITIES", "UTF-8") !!}</th>
                            <th>{!! mb_convert_encoding('Veículo', "HTML-ENTITIES", "UTF-8") !!}</th>
                            <th>{!! mb_convert_encoding('Origem', "HTML-ENTITIES", "UTF-8") !!}</th>
                            <th>{!! mb_convert_encoding('URL Original', "HTML-ENTITIES", "UTF-8") !!}</th>
                            <th>{!! mb_convert_encoding('URL na Mídia', "HTML-ENTITIES", "UTF-8") !!}</th>
                            <th>{!! mb_convert_encoding('URL FAPESP', "HTML-ENTITIES", "UTF-8") !!}</th>
                            <th>{!! mb_convert_encoding('Data',    "HTML-ENTITIES", "UTF-8") !!}</th>
                        </tr>
                        @foreach ($data as $item)
                            <tr>
                                <td>{!! mb_convert_encoding($item->id, "HTML-ENTITIES", "UTF-8") !!}</td>
                                <td>{!! mb_convert_encoding($item->title, "HTML-ENTITIES", "UTF-8") !!}</td>
                                <td>
                                    {!! mb_convert_encoding($item->vehicle->description, "HTML-ENTITIES", "UTF-8") !!} | {!! mb_convert_encoding($item->mediaType->description, "HTML-ENTITIES", "UTF-8") !!}
                                </td>
                                <td>{!! mb_convert_encoding($item->from, "HTML-ENTITIES", "UTF-8") !!}</td>
                                <td>{!! $item->url !!}</td>
                                <td>{!! route('detalhe', ['title' => str_slug($item->title), 'id' => $item->id]) !!}</td>
                                <td>{!! $item->url_fapesp !!}</td>
                                <td>{!! mb_convert_encoding($item->date, "HTML-ENTITIES", "UTF-8") !!}</td>
                            </tr>
                        @endforeach
                        <tr style="font-weight: bold; background: rgb(233, 226, 195);">
                            <td colspan="7">{!! mb_convert_encoding('Total de Notícias :: ', "HTML-ENTITIES", "UTF-8") . $total !!}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
