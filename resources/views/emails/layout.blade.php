{{-- Styles Base --}}
@php($styleWebkit = "-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;")
@php($styleMso    = "mso-table-lspace:0pt;mso-table-rspace:0pt;")
@php($styleFont   = "font-family:Arial, Helvetica, sans-serif;")
@php($styleImg    = "border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;")

@php($styleBody   = "margin:0 !important;padding:0 !important;width:100% !important;background-color:#FFFFFF;" . $styleWebkit)
@php($styleTable  = "border-collapse:collapse !important;" . $styleMso . $styleWebkit)
@php($styleTd     = $styleFont . $styleMso . $styleWebkit)
@php($styleTexts  = "font-size:13px;line-height:20px;color:#333333;")
@php($styleLink   = "text-decoration:none;" . $styleFont . $styleWebkit)

@php($textFooter  = "margin:5px 0 0;font-size:11px;line-height:14px;text-align:center;color:#FFFFFF;")

{{-- Definitions Base --}}
@php($width       = 640)

@php($colorBase   = "#FFFFFF")
@php($colorLink   = "#FFFFFF")
@php($colorMenu   = "#1D78BA")
@php($color       = "#0A558B")
@php($color2      = "#032F50")

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Informativo {{ config('app.site') }}</title>

        <style type="text/css">
            /* iOS BLUE LINKS */
            a[x-apple-data-detectors] {
                color: inherit !important;
                text-decoration: none !important;
                font-size: inherit !important;
                font-family: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important;
            }

            /* ANDROID CENTER FIX */
            div[style*="margin: 16px 0;"] {
                margin: 0 !important;
            }
        </style>
    </head>

    <body style="{{ $styleBody }}">
        <center>
            <div class="main" style="margin:auto;padding:25px 10px;max-width:{{ $width }}px;background-color:{{ $colorBase }};">
                <!--[if mso]>
                <table role="presentation" width="{{ $width }}" cellspacing="0" cellpadding="0" border="0" align="center">
                <tr>
                <td>
                <![endif]-->

                {{-- Header --}}
                <table width="{{ $width }}" cellspacing="0" cellpadding="0" border="0" align="center" style="{{ $styleTable }}max-width:{{ $width }}px; width:100%;" bgcolor="{{ $colorBase }}">
                    <tr>
                        <td align="center" valign="center" style="{{ $styleTd }}padding:25px 30px;background-color:{{ $color }};">
                            <a style="text-decoration:none; border:none;" href="{{ route('home') }}" title="{{ config('app.name') }}">
                                <img src="http://fapesp.br/.design/ciencia-aberta/assets/img/logo.png" alt="{{ config('app.name') }}" width="220" style="{{ $styleImg }}min-width:120px; max-width: 220px; width: 100%;">
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td height="3" style="{{ $styleTd }}font-size:3px; line-height:3px;background-color:{{ $colorMenu }};">&nbsp;</td>
                    </tr>

                    <tr><td height="20" style="font-size:20px; line-height:20px;">&nbsp;</td></tr>
                </table>

                {{-- Content --}}
                <table width="{{ $width }}" cellspacing="0" cellpadding="0" border="0" align="center" style="max-width:{{ $width }}px;width:100%;" bgcolor="{{ $colorBase }}">
                    <tr>
                        <td style="{{ $styleTd . $styleTexts }}">
                            @yield('body')
                        </td>
                    </tr>
                </table>

                {{-- Salutation --}}
                <table width="{{ $width }}" cellspacing="0" cellpadding="0" border="0" style="max-width:{{ $width }}px;width:100%;">
                    <tr><td height="15" style="font-size:15px; line-height:15px;">&nbsp;</td></tr>

                    <tr>
                        <td style="{{ $styleTd . $styleTexts }}">
                            {{-- Salutation --}}
                            @if (!empty($salutation))
                                {{ $salutation }}
                            @else
                                Atenciosamente,<br>
                            @endif
                            Equipe {{ config('app.site') }}
                        </td>
                    </tr>
                </table>

                {{-- Subcopy --}}
                @isset($actionText)
                    <table width="{{ $width }}" cellspacing="0" cellpadding="0" border="0" style="max-width:{{ $width }}px;width:100%;">
                        <tr><td height="20" style="font-size:20px; line-height:20px;">&nbsp;</td></tr>
                        <tr><td height="1" style="font-size:1px; line-height:1px;background-color:#A0A0A0;">&nbsp;</td></tr>
                        <tr><td height="20" style="font-size:20px; line-height:20px;">&nbsp;</td></tr>

                        <tr>
                            <td style="{{ $styleTd }}font-size:11px;color:#999999;">
                                Se você tiver dificuldade para clicar no botão "<i>{{ $actionText }}</i>", copie e cole a URL a seguir no seu navegador: <b>{{ $actionUrl }}</b>
                            </td>
                        </tr>
                    </table>
                @endisset

                {{-- Footer --}}
                <table width="{{ $width }}" cellspacing="0" cellpadding="0" border="0" align="center" style="{{ $styleTable }}max-width:{{ $width }}px; width:100%;">
                    <tr><td height="20" style="font-size:20px; line-height:20px;">&nbsp;</td></tr>

                    <tr>
                        <td style="{{ $styleTd }}padding:15px 20px;background-color:{{ $color2 }};">
                            <p style="{{ $textFooter }}">Rua Pio XI, 1500 - Alto da Lapa - São Paulo - SP | CEP 05468-901 | Brasil</p>
                            <p style="{{ $textFooter }}">Tel: +55 (11) 3838.4000 | <a href="mailto:cienciaaberta@fapesp.br" style="{{ $styleLink }}font-weight:bold;color:{{ $colorLink }};">cienciaaberta@fapesp.br</a></p>
                        </td>
                    </tr>
                </table>

                <!--[if mso]>
                </td>
                </tr>
                </table>
                <![endif]-->
            </div>
        </center>
    </body>
</html>
{{-- {{ dd('Final') }} --}}