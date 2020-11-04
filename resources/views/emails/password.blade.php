@extends('emails.layout')

{{-- Styles Base --}}
@php($styleWebkit = "-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;")
@php($styleFont   = "font-family:Arial, Helvetica, sans-serif;")
@php($styleLink   = "text-decoration:none;" . $styleFont . $styleWebkit)
@php($styleP      = $styleFont . $styleWebkit . "display:block;margin:0;font-size:13px;line-height:20px;color:#333333;")
@php($styleBtn    = $styleLink . "display:inline-block;color:#ffffff;font-size:13px;line-height:40px;text-align:center;")

{{-- Colors --}}
@php($colorGreen  = "#89A43E")
@php($colorRed    = "#A43E3E")
@php($colorBlue   = "#3E75A4")

@section('body')
    <p style="{{ $styleP }}">
        {{ $greeting }}
    </p>

    <p style="margin:0;display:block;height:15px;font-size:15px;line-height:15px;">&nbsp;</p>

    {{-- Intro Lines --}}
    @if(is_array($introLines))
        <p style="{{ $styleP }}">
            @php($i = 0)
            @foreach ($introLines as $line)
                {!! ($i>0 ? '<br>' : '') . $line !!}
                @php($i++)
            @endforeach
        </p>
    @endif

    {{-- Action Button --}}
    @isset($actionText)
        <?php switch ($level) {
            case 'success':
                $colorBtn = $colorGreen;
                break;
            case 'error':
                $colorBtn = $colorRed;
                break;
            default:
                $colorBtn = $colorBlue;
        } ?>

        <p style="{{ $styleP }}text-align:center;margin:30px 0;">
            <!--[if mso]>
                <v:rect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{ $actionUrl }}" style="height:40px;v-text-anchor:middle;width:150px;padding:0 20px;" stroke="f" fillcolor="{{ $colorBtn }}">
                <w:anchorlock/>
                <center>
            <![endif]-->
                <a href="{{ $actionUrl }}" style="{{ $styleBtn }}padding:0 20px;width:150px;font-weight:bold;background-color:{{ $colorBtn }};">
                    {{ $actionText }}
                </a>
            <!--[if mso]>
                </center>
                </v:rect>
            <![endif]-->
        </p>
    @endisset

    {{-- Outro Lines --}}
    @if(is_array($outroLines))
        <p style="{{ $styleP }}">
            @php($z = 0)
            @foreach ($outroLines as $line)
                {!! ($z>0 ? '<br>' : '') . $line !!}
                @php($z++)
            @endforeach
        </p>
    @endif
@endsection