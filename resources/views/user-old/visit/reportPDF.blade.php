<!DOCTYPE html>
<html>
<head>
    <title>Generate PDF Example - ItSolutionStuff.com</title>

    <style>
        .page-break {
            page-break-after: always;
        }

        .visit-container {
            position: relative;
        }
        .checkmark {
            position: absolute;
            top: 5px;
            right: 20px;
            width: 100px;
        }

        .visit-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .visit-date {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .card-container {
            display: block;
            border: 1px solid #C8DCE0;
            padding: 10px;
            margin: 6px;
            font-family: Arial, sans-serif;
            font-size: 13px;
            vertical-align: top;
        }

        .card-header {
            width: 100%;
            margin-bottom: 5px;
            font-weight: bold;
            color: #0074bd;
            font-size: 16px;
        }

        .header-table {
            width: 100%;
        }

        .score-box {
            color: white;
            padding: 3px 9px;
            border-radius: 2px;
            font-size: 14px;
            text-align: right;
        }

        .question-score-box {
            color: white;
            padding: 5px 20px;
            border-radius: 2px;
            font-size: 17px;
            text-align: right;
            margin: 0;
        }

        .bar-container {
            background-color: #f1f5fa;
            padding: 18px 5px 10px 5px;
            position: relative;
            height: 30px;
        }

        .bar {
            display: table;
            width: 100%;
            table-layout: fixed;
            height: 25px;
        }

        .bar div {
            display: table-cell;
            text-align: center;
            font-size: 14px;
            color: white;
            line-height: 25px;
            padding-top: 4px;
            padding-bottom: 4px;
        }

        .red { background-color: #FC050F; }
        .orange { background-color: #F99B15; }
        .yellow { background-color: #FED116; }
        .lightgreen { background-color: #AAC1BB; }
        .green { background-color: #509F34; }
        .darkgreen { background-color: #1D8236; }

        .pointer {
            position: absolute;
            top: 8px;
            width: 0;
            height: 0;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-top: 8px solid black;
        }
        .w-100 {
            width: 100% !important;
        }
        .border {
            border: 1px solid #C8DCE0;
        }
        .card-background {
            background: #FBFBFB;
        }
        .card-border {
            border: 1px solid #C8DCE0;
            padding: 10px 15px;
            font-size: 14px;
            background: #FBFBFB;
        }
        .mt-10px {
            margin-top: 10px;
        }
        .mb-10px {
            margin-bottom: 10px;
        }

        .question-box {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .question-text {
            margin-right: 8px;
            flex-grow: 1;
        }

        .question-top-border {
            border-top: 1px solid #ccc;
            margin-top: 10px;
        }

        .label-box {
            font-weight: bold; /* fw-bold */
            white-space: nowrap;
            background: #000;
            color: #fff;
            padding: 6px 12px;
            font-size: 14px;
        }
    </style>
</head>
<body style="font-family: Arial,sans-serif;">
@php
    use Carbon\Carbon;

    // Set locale to Dutch
    Carbon::setLocale('nl');

    $startDate = Carbon::parse($visitData->started_date);
    $endDate   = Carbon::parse($visitData->completed_date);
@endphp
{{-- Start Page --}}
<div class="visit-container">
    <div>
{{--        <h1 class="visit-title">Mystery Visit {{$title}}</h1>--}}
        <h1 class="visit-title">Mystery Visit {{ $visitData->visit->branch->branch_name??'' }}</h1>
{{--        <h4 class="visit-date" style="font-weight: normal;">Date of visit: {{ date('l d F Y H:i', strtotime($visitData->started_date)) }} to {{ date('l d F Y H:i', strtotime($visitData->completed_date)) }}</h4>--}}
        <h4 class="visit-date" style="font-weight: normal;">Datum van visit: {{ $startDate->translatedFormat('l d F Y') }} van {{ $startDate->translatedFormat('H:i') }} tot {{ $endDate->translatedFormat('H:i') }}</h4>
    </div>
    <div>
        <img src="{{ $main_logo }}" class="checkmark">
    </div>
</div>



<div style="width: 100%; margin-top: 20px;">
    <table style="width: 100%;">
        <tr>
            <td style="width: 50%;">
{{--                <img src="{{ public_path('assets/logo/kompaan2.png') }}" style="width: 250px;">--}}
                <img src="{{ public_path(COMPANY_BRANCH_PROFILE_IMAGE_PATH.basename($visitData->visit->branch->image)) }}" style="width: 250px;">
            </td>
            <td style="width: 50%;">
                <div class="card-border">
                    <p style="font-size: 18px">{{ $visitData->visit->branch->branch_name??'' }}</p>
                    <p style="font-size: 18px">{{ $visitData->visit->branch->address_1??'' }}</p>
                    <p style="font-size: 18px">{{ $visitData->visit->branch->postal_code??'' }} {{ $visitData->visit->branch->locality??'' }}</p>
                </div>
            </td>
        </tr>
    </table>
</div>

<div style="width: 100%; font-size: 0;margin-top: 40px;">

    @if($response_data['category'])
        @foreach($response_data['category'] as $category_id => $category)
            @php
                $cate_score = $response_data['score_result'][$category_id]??0;
                $total_cate_score = $response_data['max_score_result'][$category_id]??0;
                $final_score = ($cate_score>0)? round(($cate_score / $total_cate_score)*100,2) :0;

                $bg_color = '#2e9d44';
                if($final_score >= 0 && $final_score <= 16.66){
                    $bg_color = 'red';
                }else if($final_score > 16.66 && $final_score <= 33.32){
                    $bg_color = 'orange';
                }else if($final_score > 33.32 && $final_score <= 49.98){
                    $bg_color = 'yellow';
                }else if($final_score > 49.98 && $final_score <= 66.64){
                    $bg_color = 'lightgreen';
                }else if($final_score > 66.64 && $final_score <= 83.3){
                    $bg_color = 'green';
                }else if($final_score > 83.3){
                    $bg_color = 'darkgreen';
                }
            @endphp
            <div style="display: inline-block; width: 49%; vertical-align: top; font-size: 13px;">
                <div class="card-container" style="margin-top: 10px;">
                    <table class="header-table">
                        <tr>
                            <td class="w-100"><div class="card-header">{{ $category ?? 'Unknown' }}</div></td>
                            <td align="right"><div class="score-box {{ $bg_color }}">{{ round($final_score) }}%</div></td>
{{--                            <td align="right"><div class="score-box" style="background-color: #f8aa2f;">{{ $visitData->total_score ? $visitData->total_score-2:0 }}%</div></td>--}}
                        </tr>
                    </table>
                    <div class="bar-container">
                        <div class="pointer" style="left: {{ $final_score>0? ($final_score==100? $final_score-3 : $final_score-2) :0 }}%;"></div>
{{--                        <div class="pointer" style="left: {{ $visitData->total_score ? $visitData->total_score-2:0 }}%;"></div>--}}
                        <div class="bar">
                            <div class="red"><img src="{{ $bar_logo }}" width="25" height="22" alt="icon"></div>
                            <div class="orange"><img src="{{ $bar_logo }}" width="25" height="22" alt="icon"></div>
                            <div class="yellow"><img src="{{ $bar_logo }}" width="25" height="22" alt="icon"></div>
                            <div class="lightgreen"><img src="{{ $bar_logo }}" width="25" height="22" alt="icon"></div>
                            <div class="green"><img src="{{ $bar_logo }}" width="25" height="22" alt="icon"></div>
                            <div class="darkgreen"><img src="{{ $bar_logo }}" width="25" height="22" alt="icon"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

{{--    <div style="display: inline-block; width: 49%; vertical-align: top; font-size: 13px;">--}}
{{--        <div class="card-container" style="margin-top: 10px;">--}}
{{--            <table class="header-table">--}}
{{--                <tr>--}}
{{--                    <td class="w-100"><div class="card-header">Reserveren</div></td>--}}
{{--                    <td align="right"><div class="score-box" style="background-color: #f8aa2f;">47%</div></td>--}}
{{--                </tr>--}}
{{--            </table>--}}
{{--            <div class="bar-container">--}}
{{--                <div class="pointer" style="left: 45%;"></div>--}}
{{--                <div class="bar">--}}
{{--                    <div class="red"><img src="{{ $bar_logo }}" width="25" height="22" alt="icon"></div>--}}
{{--                    <div class="orange"><img src="{{ $bar_logo }}" width="25" height="22" alt="icon"></div>--}}
{{--                    <div class="yellow"><img src="{{ $bar_logo }}" width="25" height="22" alt="icon"></div>--}}
{{--                    <div class="lightgreen"><img src="{{ $bar_logo }}" width="25" height="22" alt="icon"></div>--}}
{{--                    <div class="green"><img src="{{ $bar_logo }}" width="25" height="22" alt="icon"></div>--}}
{{--                    <div class="darkgreen"><img src="{{ $bar_logo }}" width="25" height="22" alt="icon"></div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

</div>

@if($response_data['category'])
    @foreach($response_data['category'] as $category_id => $category)
        @php
            $cate_score = $response_data['score_result'][$category_id]??0;
            $total_cate_score = $response_data['max_score_result'][$category_id]??0;
            $final_score = ($cate_score>0)? round(($cate_score / $total_cate_score)*100,2) :0;
        @endphp
{{--        @dd($response_data['category'][$category],$category);--}}
        <div class="page-break"></div> {{--Page break for DOMPDF--}}

        {{--Start Page--}}
        <div class="visit-container">
            <div>
                <h1 class="visit-title">{{ $visitData->visit->branch->branch_name??'' }}</h1>
            </div>
            <div>
                <img src="{{ $main_logo }}" class="checkmark">
            </div>
        </div>

        <div>
            <h3>{{ $category ?? 'Unknown' }} &nbsp;&nbsp; {{ $final_score>0? round($final_score).'%':'' }}</h3>

            @if($response_data['question'][$category_id])
                @foreach($response_data['question'][$category_id] as $qus)
                    @php
                        $qus = (array)$qus;
                    @endphp
{{--                @dd($qus)--}}
                    @if($qus['na']==0)
                        <div class="card-border mb-10px">
                            <table class="header-table">
                                <tr>
                                    <td class="w-100"><h3 style="margin: 0;">{{ $qus['title'] }}</h3></td>
                                    @php
                                        $qType = $qus['qType']??'TEXT';
                                        $qu_score = (!$qus['score']) ? 0 : $qus['score'];
                                        $qu_max_score = $qus['max_score']??0;
                                        $final_score = ($qu_max_score>0)? round(($qu_score / $qu_max_score)*100,2) :0;

                                        $bg_color = '#2e9d44';
                                        if($final_score == 0){
                                            $bg_color = '#FC0B15';
                                        }else if($final_score > 0 && $final_score <= 40){
                                            $bg_color = '#FFD113';
                                        }else if($final_score > 40 && $final_score <= 60){
                                            $bg_color = '#ABC2BB';
                                        }else if($final_score > 60 && $final_score <= 80){
                                            $bg_color = '#509F34';
                                        }else if($final_score == 100){
                                            $bg_color = '#1D8236';
                                        }
                                    @endphp
{{--                                    @if($qType == 'RADIO')--}}
{{--                                        <td align="center" width="30"><p>{{$qus['answer']}}</p></td>--}}
{{--                                    @endif--}}
                                    @if($qu_max_score>0)
                                        <td align="right"><h3 class="question-score-box" style="background-color: {{ $bg_color }};">{{ $qu_score }}/{{ $qu_max_score }}</h3></td>
                                    @endif
                                </tr>
                            </table>
                            @if($qus['answer'])
                                @php
                                $qBorder = true;
                                if($qType == 'SLIDER' || $qType == 'RADIO'){
                                    $qBorder = false;
                                }
                                if($qus['comment']){
                                    $qBorder = true;
                                }
                                if(count($qus['photo'])>0){
                                    $qBorder = true;
                                }
                                @endphp
                                <div class="{{ ($qBorder === true)?'question-top-border':'' }}">
                                    @if($qType != 'SLIDER' && $qType != 'RADIO')
                                        <p>
                                            {{ $qType == 'AMOUNT'?'€ '.number_format($qus['answer'], 2, ',', '.'):$qus['answer'] }}
                                        </p>
                                    @endif
                                    @if($qus['comment'])
                                        <p style="margin-top: 10px;">
                                            {{ $qus['comment'] }}
                                        </p>
                                    @endif
                                    @if(count($qus['photo'])>0)
                                        <div style="margin-top: 10px;">
                                            @foreach($qus['photo'] as $image)
                                                @if ($image && $image != null && $image != '')
                                                    @if (file_exists(public_path(SURVEY_QUESTIONNAIRE_IMAGES_PATH) . $image))
                                                        <img src="{{ public_path(SURVEY_QUESTIONNAIRE_IMAGES_PATH.$image) }}" width="200">
                                                        {{--                                                    {{ public_path(SURVEY_QUESTIONNAIRE_IMAGES_PATH.$image) }}--}}
                                                    @endif
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif
                @endforeach
            @endif

        </div>
    @endforeach
@endif

{{--@if($response_data['question'])--}}
{{--    @foreach($response_data['question'] as $category => $questions)--}}
{{--        @php--}}
{{--            $cate_score = $response_data['score_result'][$category]??0;--}}
{{--            $total_cate_score = $response_data['max_score_result'][$category]??0;--}}
{{--            $final_score = ($cate_score>0)? round(($cate_score / $total_cate_score)*100,2) :0;--}}
{{--        @endphp--}}
{{--        @dd($response_data['category'][$category],$category);--}}
{{--        <div class="page-break"></div> --}}{{--Page break for DOMPDF--}}

{{--        --}}{{--Start Page--}}
{{--        <div class="visit-container">--}}
{{--            <div>--}}
{{--                <h1 class="visit-title">{{$title}}</h1>--}}
{{--            </div>--}}
{{--            <div>--}}
{{--                <img src="{{ $main_logo }}" class="checkmark">--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div>--}}
{{--            <h3>{{ $response_data['category'][$category] ?? 'Unknown' }} &nbsp;&nbsp; {{ $final_score>0? round($final_score).'%':'' }}</h3>--}}

{{--            @if($questions)--}}
{{--                @foreach($questions as $qus)--}}
{{--                    @php--}}
{{--                        $qus = (array)$qus;--}}
{{--                    @endphp--}}
{{--                @dd($qus)--}}
{{--                    @if($qus['na']==0)--}}
{{--                        <div class="card-border mb-10px">--}}
{{--                            <table class="header-table">--}}
{{--                                <tr>--}}
{{--                                    <td class="w-100"><h3 style="margin: 0;">{{ $qus['title'] }}</h3></td>--}}
{{--                                    @php--}}
{{--                                        $qType = $qus['qType']??'TEXT';--}}
{{--                                        $qu_score = (!$qus['score']) ? 0 : $qus['score'];--}}
{{--                                        $qu_max_score = $qus['max_score']??0;--}}
{{--                                        $final_score = ($qu_max_score>0)? round(($qu_score / $qu_max_score)*100,2) :0;--}}

{{--                                        $bg_color = '#2e9d44';--}}
{{--                                        if($final_score == 0){--}}
{{--                                            $bg_color = '#FC0B15';--}}
{{--                                        }else if($final_score > 0 && $final_score <= 40){--}}
{{--                                            $bg_color = '#FFD113';--}}
{{--                                        }else if($final_score > 40 && $final_score <= 60){--}}
{{--                                            $bg_color = '#ABC2BB';--}}
{{--                                        }else if($final_score > 60 && $final_score <= 80){--}}
{{--                                            $bg_color = '#509F34';--}}
{{--                                        }else if($final_score == 100){--}}
{{--                                            $bg_color = '#1D8236';--}}
{{--                                        }--}}
{{--                                    @endphp--}}
{{--                                    @if($qu_max_score>0)--}}
{{--                                        <td align="right"><h3 class="question-score-box" style="background-color: {{ $bg_color }};">{{ $qu_score }}/{{ $qu_max_score }}</h3></td>--}}
{{--                                    @endif--}}
{{--                                </tr>--}}
{{--                            </table>--}}
{{--                            @if($qus['answer'])--}}
{{--                                <div style="{{ $qType != 'SLIDER'?'border-top: 1px solid #ccc;margin-top: 10px;':'' }}">--}}
{{--                                    @if($qType != 'SLIDER')--}}
{{--                                        <p>--}}
{{--                                            {{ $qType == 'AMOUNT'?'€':'' }} {{ $qus['answer'] }}--}}
{{--                                        </p>--}}
{{--                                    @endif--}}
{{--                                    @if($qus['comment'])--}}
{{--                                        <p style="margin-top: 10px;">--}}
{{--                                            {{ $qus['comment'] }}--}}
{{--                                        </p>--}}
{{--                                    @endif--}}
{{--                                    @if(count($qus['photo'])>0)--}}
{{--                                        <div style="margin-top: 10px;">--}}
{{--                                            @foreach($qus['photo'] as $image)--}}
{{--                                                @if ($image && $image != null && $image != '')--}}
{{--                                                    @if (file_exists(public_path(SURVEY_QUESTIONNAIRE_IMAGES_PATH) . $image))--}}
{{--                                                        <img src="{{ public_path(SURVEY_QUESTIONNAIRE_IMAGES_PATH.$image) }}" width="200">--}}
{{--                                                        --}}{{--                                                    {{ public_path(SURVEY_QUESTIONNAIRE_IMAGES_PATH.$image) }}--}}
{{--                                                    @endif--}}
{{--                                                @endif--}}
{{--                                            @endforeach--}}
{{--                                        </div>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                @endforeach--}}
{{--            @endif--}}

{{--        </div>--}}
{{--    @endforeach--}}
{{--@endif--}}


{{--<div class="page-break"></div> --}}{{-- Page break for DOMPDF --}}

{{-- Start Page --}}
{{--<div class="visit-container">--}}
{{--    <div>--}}
{{--        <h1 class="visit-title">{{$title}}</h1>--}}
{{--    </div>--}}
{{--    <div>--}}
{{--        <img src="{{ $main_logo }}" class="checkmark">--}}
{{--    </div>--}}
{{--</div>--}}

{{--<div>--}}
{{--    <h3>Reserveren &nbsp;&nbsp;&nbsp;47%</h3>--}}

{{--    <div class="card-border mb-10px">--}}
{{--        <table class="header-table">--}}
{{--            <tr>--}}
{{--                <td class="w-100"><h3 style="margin: 0;">Heb je de website van de zaak gevonden?</h3></td>--}}
{{--                <td align="right"><h3 class="question-score-box" style="background-color: #2e9d44;">2/2</h3></td>--}}
{{--            </tr>--}}
{{--        </table>--}}
{{--        <div style="border-top: 1px solid #ccc;margin-top: 10px;">--}}
{{--            <p>--}}
{{--                IN eerste instantie kwam bij de zoekopdracht de website van Thuishaven Amsterdam naar--}}
{{--                boven. Bij een meer specifieke zoekopdracht Thuishaven Den Haag kwam Cardia locatie De--}}
{{--                Thuishaven naar voren. Bij de 3e poging, zoekopdracht Kompaan Thuishaven Den Haag, vond ik--}}
{{--                de website. De website is aantrekkelijk en groovy. De optie tafel reserveren is--}}
{{--                gebruiksvriendelijk.--}}
{{--            </p>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="card-border mb-10px">--}}
{{--        <table class="header-table">--}}
{{--            <tr>--}}
{{--                <td class="w-100"><h3 style="margin: 0;">Heb je deze website als gebruiksvriendelijk ervaren?</h3></td>--}}
{{--                <td align="right"><h3 class="question-score-box" style="background-color: #bdd4cc;">3/5</h3></td>--}}
{{--            </tr>--}}
{{--        </table>--}}
{{--    </div>--}}

{{--    <div class="card-border mb-10px">--}}
{{--        <table class="header-table">--}}
{{--            <tr>--}}
{{--                <td class="w-100"><h3 style="margin: 0;">Hoe was jouw ervaring bij de reservering? Geef een waardering voor de--}}
{{--                        telefonische of online reservering: Beschrijf hoe deze reservering verliep (online:--}}
{{--                        eenvoud, overzichtelijkheid, telefonisch: vriendelijkheid, snelheid,--}}
{{--                        professionaliteit)--}}
{{--                    </h3></td>--}}
{{--                <td align="right"><h3 class="question-score-box" style="background-color: #ea2e2e;">0/5</h3></td>--}}
{{--            </tr>--}}
{{--        </table>--}}
{{--    </div>--}}
{{--</div>--}}

{{--<div class="page-break"></div> --}}{{-- Page break for DOMPDF --}}

{{--<div>--}}
{{--    <h3>Park & Entree  &nbsp;&nbsp;&nbsp;58%</h3>--}}

{{--    <div class="card-border mb-10px">--}}
{{--        <table class="header-table">--}}
{{--            <tr>--}}
{{--                <td class="w-100"><h3 style="margin: 0;">Er staat een uitnodigend bord buiten met een Call to Action</h3></td>--}}
{{--                <td align="right"><h3 class="question-score-box" style="background-color: #2e9d44;">2/2</h3></td>--}}
{{--            </tr>--}}
{{--        </table>--}}
{{--        <div style="border-top: 1px solid #ccc;margin-top: 10px;">--}}
{{--            <p>--}}
{{--                De gast vindt de borden buiten passend bij de zaak,. Er is duidelijk aandacht aan de borden--}}
{{--                besteed, het ziet er leuk uit.--}}
{{--            </p>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="card-border mb-10px">--}}
{{--        <table class="header-table">--}}
{{--            <tr>--}}
{{--                <td class="w-100"><h3 style="margin: 0;">Het bedrijf ziet er van buitenaf uitnodigend uit</h3></td>--}}
{{--                <td align="right"><h3 class="question-score-box" style="background-color: #bdd4cc;">3/5</h3></td>--}}
{{--            </tr>--}}
{{--        </table>--}}
{{--        <div style="border-top: 1px solid #ccc;margin-top: 10px;">--}}
{{--            <p>--}}
{{--                Op de weg naar de entree wordt de gast aangetrokken door de muziek. Het terras ziet er keurig--}}
{{--                uit. Vanwege de wind is het niet aantrekkelijk op het terras plaats te nemen. De gast heeft zin--}}
{{--                om naar binnen te gaan.--}}
{{--            </p>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="card-border mb-10px">--}}
{{--        <table class="header-table">--}}
{{--            <tr>--}}
{{--                <td class="w-100"><h3 style="margin: 0;">Buiten/terras is het opgeruimd en netjes</h3></td>--}}
{{--                <td align="right"><h3 class="question-score-box" style="background-color: #bdd4cc;">3/5</h3></td>--}}
{{--            </tr>--}}
{{--        </table>--}}
{{--    </div>--}}

{{--    <div class="card-border mb-10px">--}}
{{--        <table class="header-table">--}}
{{--            <tr>--}}
{{--                <td class="w-100"><h3 style="margin: 0;">Het is duidelijk waar de entree is</h3></td>--}}
{{--                <td align="right"><h3 class="question-score-box" style="background-color: #ea2e2e;">0/5</h3></td>--}}
{{--            </tr>--}}
{{--        </table>--}}
{{--    </div>--}}
{{--</div>--}}

{{-- Start Page --}}
<!--<div class="page-break"></div> {{-- Page break for DOMPDF --}}

<div class="visit-container">
    <div>
        <h1 class="visit-title">{{$title}}</h1>
    </div>
    <div>
        <img src="{{ $main_logo }}" class="checkmark">
    </div>
</div>

<div style="width: 100%; font-size: 0;margin-top: 40px;">

    <div style="display: inline-block; width: 49%; vertical-align: top; font-size: 13px;">
        <div class="card-container card-background mt-10px">
            <h3 class="" style="margin: 0;margin-bottom: 5px;text-align: center">Reserveren</h3>
            <p>Score (%)</p>
            <div>
                <img src="{{ public_path('assets/logo/reservern.png') }}" style="width: 100%;">
            </div>
        </div>
    </div>

    <div style="display: inline-block; width: 49%; vertical-align: top; font-size: 13px;">
        <div class="card-container card-background mt-10px">
            <h3 class="" style="margin: 0;margin-bottom: 5px;text-align: center">Park & Entree</h3>
            <p>Score (%)</p>
            <div>
                <img src="{{ public_path('assets/logo/park.png') }}" style="width: 100%;">
            </div>
        </div>
    </div>

</div>-->


</body>
</html>
