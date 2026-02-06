<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mystery Visit</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #fff;
            color: #000;
            font-family: Arial, sans-serif;
        }

        .question-box {
            display: flex; /* d-flex */
            justify-content: space-between; /* justify-content-between */
            align-items: flex-start; /* align-items-start */
            background: #dceaf6;
            border: 1px solid #000;
            padding: 10px;
            margin-bottom: 10px;
        }

        .visit-title {
            font-weight: bold;
        }

        .print-btn {
            position: fixed;
            bottom: 20px; /* distance from bottom */
            left: 50%; /* push to center */
            transform: translateX(-50%); /* perfectly center */
            padding: 10px 20px;
            background: #1e2a38; /* custom color */
            color: #fff;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            z-index: 1000; /* stays on top */
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
        }

        .question-box {
            background: #dceaf6;
            border: 1px solid #000;
            padding: 10px;
            margin-bottom: 10px;
        }

        .label-box {
            font-weight: bold; /* fw-bold */
            white-space: nowrap;
            background: #000;
            color: #fff;
            padding: 6px 12px;
            font-size: 14px;
        }

        @media print {
            .no-print {
                display: none !important; /* button hide thayi jase */
            }

            .print-section {
                display: block;
            }

            .row {
                display: flex !important;
                flex-wrap: nowrap !important;
            }

            .col-md-8, .col-md-4 {
                float: none !important;
                display: block !important;
            }

            .col-md-8 {
                width: 66.66% !important;
            }

            .col-md-4 {
                width: 33.33% !important;
                text-align: right !important;
            }

            .bg-black {
                background-color: black !important; /* light gray */
                color: #000 !important; /* black text */
                -webkit-print-color-adjust: exact; /* force color in WebKit browsers */
                print-color-adjust: exact;
            }
        }

        .bottom-10 {
            bottom: 10px;
        }
        .pl-2 {
            padding-left: 0.75rem;
        }
    </style>
</head>
<body>
<div class="my-4 mx-4">

    <!-- Header -->
    <div class="row mb-4 print-section">
        <div class="col-md-8">
            <h3 class="visit-title">Mystery Visit {{ $visitData->visit->branch->branch_name??'' }}</h3>
            <p><strong>Mystery
                    Visit:</strong> {{ $visitData->visit->branch->branch_name??'' }} {{ $visitData->visit->branch->address_1??'' }}
            </p>
            <p><strong>Start Visit:</strong> {{ date('D d F Y H:i', strtotime($visitData->started_date)) }}</p>
            <p><strong>End Visit:</strong> {{ date('D d F Y H:i', strtotime($visitData->completed_date)) }}</p>
        </div>
        <div class="col-md-4 text-end">
            <img src="{{ $visitData->visit->branch->image??'' }}" alt="visit image" class="img-fluid rounded">
        </div>
    </div>

    <div class="ms-3 no-print">
        <button class="print-btn" onclick="window.print()">
            <i class="bi bi-printer"></i> Print
        </button>
    </div>

    <div class="row mb-4 print-section">
        <div class="col-md-4">
            <div class="break-inside-avoid-page">
                <div class="bg-black text-center text-white fw-bold p-1">Category 1</div>
                <div class="d-flex justify-content-center">
                    <div class="vue-gauge-item position-relative">
                        <div class="position-absolute text-center w-100 bottom-10 pl-2">50%</div>
                        <svg width="180" height="117">
                            <path d="M-63,-7.715274834628325e-15A63,63,0,0,1,-50.96807064562168,-37.03047089442582L-38.22605298421626,-27.77285317081936A47.25,47.25,0,0,0,-47.25,-5.786456125971244e-15Z"
                                  fill="rgb(255, 84, 84)" transform="translate(90, 76.5)" style="opacity: 1;"></path>
                            <path d="M-69.3,-8.486802318091157e-15A69.3,69.3,0,0,1,-56.06487771018385,-40.733517983868396L-50.96807064562168,-37.03047089442582A63,63,0,0,0,-63,-7.715274834628325e-15Z"
                                  fill="rgba(255, 84, 84, 0)" opacity="0.2" transform="translate(90, 76.5)"></path>
                            <path d="M-50.96807064562168,-37.03047089442582A63,63,0,0,1,-19.468070645621683,-59.91656052659468L-14.601052984216262,-44.93742039494601A47.25,47.25,0,0,0,-38.22605298421626,-27.77285317081936Z"
                                  fill="rgb(255, 84, 84)" transform="translate(90, 76.5)"></path>
                            <path d="M-56.06487771018385,-40.733517983868396A69.3,69.3,0,0,1,-21.41487771018385,-65.90821657925414L-19.468070645621683,-59.91656052659468A63,63,0,0,0,-50.96807064562168,-37.03047089442582Z"
                                  fill="transparent" opacity="0.2" transform="translate(90, 76.5)"></path>
                            <path d="M-19.468070645621683,-59.91656052659468A63,63,0,0,1,9.855371297534562,-62.224365457493676L7.391528473150922,-46.66827409312025A47.25,47.25,0,0,0,-14.601052984216262,-44.93742039494601Z"
                                  fill="rgb(239, 214, 19)" transform="translate(90, 76.5)" style="opacity: 1;"></path>
                            <path d="M-21.41487771018385,-65.90821657925414A69.3,69.3,0,0,1,10.840908427288017,-68.44680200324304L9.855371297534562,-62.224365457493676A63,63,0,0,0,-19.468070645621683,-59.91656052659468Z"
                                  fill="rgba(239, 214, 19, 0)" opacity="0.2" transform="translate(90, 76.5)"></path>
                            <path d="M9.855371297534562,-62.224365457493676A63,63,0,0,1,37.030470894425804,-50.96807064562169L27.77285317081935,-38.22605298421627A47.25,47.25,0,0,0,7.391528473150922,-46.66827409312025Z"
                                  fill="rgb(239, 214, 19)" transform="translate(90, 76.5)" style="opacity: 1;"></path>
                            <path d="M10.840908427288017,-68.44680200324304A69.3,69.3,0,0,1,40.73351798386838,-56.06487771018386L37.030470894425804,-50.96807064562169A63,63,0,0,0,9.855371297534562,-62.224365457493676Z"
                                  fill="rgba(239, 214, 19, 0)" opacity="0.2" transform="translate(90, 76.5)"></path>
                            <path d="M37.030470894425804,-50.96807064562169A63,63,0,0,1,50.96807064562169,-37.030470894425804L38.22605298421627,-27.77285317081935A47.25,47.25,0,0,0,27.77285317081935,-38.22605298421627Z"
                                  fill="rgb(61, 255, 91)" transform="translate(90, 76.5)" style="opacity: 1;"></path>
                            <path d="M40.73351798386838,-56.06487771018386A69.3,69.3,0,0,1,56.06487771018386,-40.73351798386838L50.96807064562169,-37.030470894425804A63,63,0,0,0,37.030470894425804,-50.96807064562169Z"
                                  fill="rgba(61, 255, 91, 0)" opacity="0.2" transform="translate(90, 76.5)"></path>
                            <path d="M50.96807064562169,-37.030470894425804A63,63,0,0,1,59.91656052659467,-19.468070645621687L44.937420394946,-14.601052984216265A47.25,47.25,0,0,0,38.22605298421627,-27.77285317081935Z"
                                  fill="rgb(61, 255, 91)" transform="translate(90, 76.5)" style="opacity: 1;"></path>
                            <path d="M56.06487771018386,-40.73351798386838A69.3,69.3,0,0,1,65.90821657925413,-21.414877710183852L59.91656052659467,-19.468070645621687A63,63,0,0,0,50.96807064562169,-37.030470894425804Z"
                                  fill="rgba(61, 255, 91, 0)" opacity="0.2" transform="translate(90, 76.5)"></path>
                            <path d="M59.91656052659467,-19.468070645621687A63,63,0,0,1,62.224365457493676,-9.855371297534559L46.66827409312025,-7.391528473150919A47.25,47.25,0,0,0,44.937420394946,-14.601052984216265Z"
                                  fill="rgb(61, 204, 91)" transform="translate(90, 76.5)"></path>
                            <path d="M65.90821657925413,-21.414877710183852A69.3,69.3,0,0,1,68.44680200324304,-10.840908427288014L62.224365457493676,-9.855371297534559A63,63,0,0,0,59.91656052659467,-19.468070645621687Z"
                                  fill="transparent" opacity="0.2" transform="translate(90, 76.5)"></path>
                            <path d="M62.224365457493676,-9.855371297534559A63,63,0,0,1,62.99968910771707,-0.1979200116103862L47.2497668307878,-0.14844000870778964A47.25,47.25,0,0,0,46.66827409312025,-7.391528473150919Z"
                                  fill="rgb(61, 204, 91)" transform="translate(90, 76.5)" style="opacity: 1;"></path>
                            <path d="M68.44680200324304,-10.840908427288014A69.3,69.3,0,0,1,69.29965801848877,-0.2177120127714248L62.99968910771707,-0.1979200116103862A63,63,0,0,0,62.224365457493676,-9.855371297534559Z"
                                  fill="rgba(61, 204, 91, 0)" opacity="0.2" transform="translate(90, 76.5)"></path>
                            <path d="M62.99968910771707,-0.1979200116103862A63,63,0,0,1,63,0L47.25,0A47.25,47.25,0,0,0,47.2497668307878,-0.14844000870778964Z"
                                  fill="#a6cee3" transform="translate(90, 76.5)"></path>
                            <path d="M69.29965801848877,-0.2177120127714248A69.3,69.3,0,0,1,69.3,0L63,0A63,63,0,0,0,62.99968910771707,-0.1979200116103862Z"
                                  fill="transparent" opacity="0.2" transform="translate(90, 76.5)"></path>
                            <text x="18.02978940918479" y="36.87739614296437" align="center" font-size="10px"
                                  font-family="Roboto,Helvetica Neue,sans-serif">Bad
                            </text>
                            <text x="79.73450510086198" y="9.919928960481755" align="center" font-size="10px"
                                  font-family="Roboto,Helvetica Neue,sans-serif">Moderate
                            </text>
                            <text x="138.8432574658152" y="36.877396142964386" align="center" font-size="10px"
                                  font-family="Roboto,Helvetica Neue,sans-serif">Good
                            </text>
                            <text x="155.04584252389327" y="65.95475271163802" align="center" font-size="10px"
                                  font-family="Roboto,Helvetica Neue,sans-serif">Super
                            </text>
                            <path d="M0,-45.832499999999996L-3.1500000000000004,0L0,3.1500000000000004L3.1500000000000004,0L0,-45.832499999999996"
                                  stroke="black" stroke-width="2" fill="black" transform="translate(90, 76.5)"></path>
                            <path d="M-6.300000000000001,-7.715274834628326e-16A6.300000000000001,6.300000000000001,0,1,1,6.300000000000001,7.715274834628326e-16A6.300000000000001,6.300000000000001,0,1,1,-6.300000000000001,-7.715274834628326e-16Z"
                                  fill="black" transform="translate(90, 76.5)" class="bar"></path>
                            <text x="31.575" y="89.7" font-size="11px" font-family="Roboto,Helvetica Neue,sans-serif">0</text>
                            <text x="135.225" y="89.7" font-size="11px" font-family="Roboto,Helvetica Neue,sans-serif">100
                            </text>
                            <text x="90" y="76.5" font-size="16.5px" font-family="Roboto,Helvetica Neue,sans-serif"></text>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="break-inside-avoid-page">
                <div class="bg-black text-center text-white fw-bold p-1">Category 2</div>
                <div class="d-flex justify-content-center">
                    <div class="vue-gauge-item position-relative">
                        <div class="position-absolute text-center w-100 bottom-10 pl-2">50%</div>
                        <svg width="180" height="117">
                            <path d="M-63,-7.715274834628325e-15A63,63,0,0,1,-50.96807064562168,-37.03047089442582L-38.22605298421626,-27.77285317081936A47.25,47.25,0,0,0,-47.25,-5.786456125971244e-15Z"
                                  fill="rgb(255, 84, 84)" transform="translate(90, 76.5)" style="opacity: 1;"></path>
                            <path d="M-69.3,-8.486802318091157e-15A69.3,69.3,0,0,1,-56.06487771018385,-40.733517983868396L-50.96807064562168,-37.03047089442582A63,63,0,0,0,-63,-7.715274834628325e-15Z"
                                  fill="rgba(255, 84, 84, 0)" opacity="0.2" transform="translate(90, 76.5)"></path>
                            <path d="M-50.96807064562168,-37.03047089442582A63,63,0,0,1,-19.468070645621683,-59.91656052659468L-14.601052984216262,-44.93742039494601A47.25,47.25,0,0,0,-38.22605298421626,-27.77285317081936Z"
                                  fill="rgb(255, 84, 84)" transform="translate(90, 76.5)"></path>
                            <path d="M-56.06487771018385,-40.733517983868396A69.3,69.3,0,0,1,-21.41487771018385,-65.90821657925414L-19.468070645621683,-59.91656052659468A63,63,0,0,0,-50.96807064562168,-37.03047089442582Z"
                                  fill="transparent" opacity="0.2" transform="translate(90, 76.5)"></path>
                            <path d="M-19.468070645621683,-59.91656052659468A63,63,0,0,1,9.855371297534562,-62.224365457493676L7.391528473150922,-46.66827409312025A47.25,47.25,0,0,0,-14.601052984216262,-44.93742039494601Z"
                                  fill="rgb(239, 214, 19)" transform="translate(90, 76.5)" style="opacity: 1;"></path>
                            <path d="M-21.41487771018385,-65.90821657925414A69.3,69.3,0,0,1,10.840908427288017,-68.44680200324304L9.855371297534562,-62.224365457493676A63,63,0,0,0,-19.468070645621683,-59.91656052659468Z"
                                  fill="rgba(239, 214, 19, 0)" opacity="0.2" transform="translate(90, 76.5)"></path>
                            <path d="M9.855371297534562,-62.224365457493676A63,63,0,0,1,37.030470894425804,-50.96807064562169L27.77285317081935,-38.22605298421627A47.25,47.25,0,0,0,7.391528473150922,-46.66827409312025Z"
                                  fill="rgb(239, 214, 19)" transform="translate(90, 76.5)" style="opacity: 1;"></path>
                            <path d="M10.840908427288017,-68.44680200324304A69.3,69.3,0,0,1,40.73351798386838,-56.06487771018386L37.030470894425804,-50.96807064562169A63,63,0,0,0,9.855371297534562,-62.224365457493676Z"
                                  fill="rgba(239, 214, 19, 0)" opacity="0.2" transform="translate(90, 76.5)"></path>
                            <path d="M37.030470894425804,-50.96807064562169A63,63,0,0,1,50.96807064562169,-37.030470894425804L38.22605298421627,-27.77285317081935A47.25,47.25,0,0,0,27.77285317081935,-38.22605298421627Z"
                                  fill="rgb(61, 255, 91)" transform="translate(90, 76.5)" style="opacity: 1;"></path>
                            <path d="M40.73351798386838,-56.06487771018386A69.3,69.3,0,0,1,56.06487771018386,-40.73351798386838L50.96807064562169,-37.030470894425804A63,63,0,0,0,37.030470894425804,-50.96807064562169Z"
                                  fill="rgba(61, 255, 91, 0)" opacity="0.2" transform="translate(90, 76.5)"></path>
                            <path d="M50.96807064562169,-37.030470894425804A63,63,0,0,1,59.91656052659467,-19.468070645621687L44.937420394946,-14.601052984216265A47.25,47.25,0,0,0,38.22605298421627,-27.77285317081935Z"
                                  fill="rgb(61, 255, 91)" transform="translate(90, 76.5)" style="opacity: 1;"></path>
                            <path d="M56.06487771018386,-40.73351798386838A69.3,69.3,0,0,1,65.90821657925413,-21.414877710183852L59.91656052659467,-19.468070645621687A63,63,0,0,0,50.96807064562169,-37.030470894425804Z"
                                  fill="rgba(61, 255, 91, 0)" opacity="0.2" transform="translate(90, 76.5)"></path>
                            <path d="M59.91656052659467,-19.468070645621687A63,63,0,0,1,62.224365457493676,-9.855371297534559L46.66827409312025,-7.391528473150919A47.25,47.25,0,0,0,44.937420394946,-14.601052984216265Z"
                                  fill="rgb(61, 204, 91)" transform="translate(90, 76.5)"></path>
                            <path d="M65.90821657925413,-21.414877710183852A69.3,69.3,0,0,1,68.44680200324304,-10.840908427288014L62.224365457493676,-9.855371297534559A63,63,0,0,0,59.91656052659467,-19.468070645621687Z"
                                  fill="transparent" opacity="0.2" transform="translate(90, 76.5)"></path>
                            <path d="M62.224365457493676,-9.855371297534559A63,63,0,0,1,62.99968910771707,-0.1979200116103862L47.2497668307878,-0.14844000870778964A47.25,47.25,0,0,0,46.66827409312025,-7.391528473150919Z"
                                  fill="rgb(61, 204, 91)" transform="translate(90, 76.5)" style="opacity: 1;"></path>
                            <path d="M68.44680200324304,-10.840908427288014A69.3,69.3,0,0,1,69.29965801848877,-0.2177120127714248L62.99968910771707,-0.1979200116103862A63,63,0,0,0,62.224365457493676,-9.855371297534559Z"
                                  fill="rgba(61, 204, 91, 0)" opacity="0.2" transform="translate(90, 76.5)"></path>
                            <path d="M62.99968910771707,-0.1979200116103862A63,63,0,0,1,63,0L47.25,0A47.25,47.25,0,0,0,47.2497668307878,-0.14844000870778964Z"
                                  fill="#a6cee3" transform="translate(90, 76.5)"></path>
                            <path d="M69.29965801848877,-0.2177120127714248A69.3,69.3,0,0,1,69.3,0L63,0A63,63,0,0,0,62.99968910771707,-0.1979200116103862Z"
                                  fill="transparent" opacity="0.2" transform="translate(90, 76.5)"></path>
                            <text x="18.02978940918479" y="36.87739614296437" align="center" font-size="10px"
                                  font-family="Roboto,Helvetica Neue,sans-serif">Bad
                            </text>
                            <text x="79.73450510086198" y="9.919928960481755" align="center" font-size="10px"
                                  font-family="Roboto,Helvetica Neue,sans-serif">Moderate
                            </text>
                            <text x="138.8432574658152" y="36.877396142964386" align="center" font-size="10px"
                                  font-family="Roboto,Helvetica Neue,sans-serif">Good
                            </text>
                            <text x="155.04584252389327" y="65.95475271163802" align="center" font-size="10px"
                                  font-family="Roboto,Helvetica Neue,sans-serif">Super
                            </text>

                            <!-- Rotated 50% Line -->
                            <path d="M0,-45.832499999999996L-3.1500000000000004,0L0,3.1500000000000004L3.1500000000000004,0L0,-45.832499999999996"
                                  stroke="black" stroke-width="2" fill="black" transform="translate(90, 76.5) rotate(-100)"></path>

                            <path d="M-6.300000000000001,-7.715274834628326e-16A6.300000000000001,6.300000000000001,0,1,1,6.300000000000001,7.715274834628326e-16A6.300000000000001,6.300000000000001,0,1,1,-6.300000000000001,-7.715274834628326e-16Z"
                                  fill="black" transform="translate(90, 76.5)" class="bar"></path>
                            <text x="31.575" y="89.7" font-size="11px" font-family="Roboto,Helvetica Neue,sans-serif">0</text>
                            <text x="135.225" y="89.7" font-size="11px" font-family="Roboto,Helvetica Neue,sans-serif">100</text>
                            <text x="90" y="76.5" font-size="16.5px" font-family="Roboto,Helvetica Neue,sans-serif"></text>
                        </svg>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @if($response_data->question)
        @php $ck = 1; @endphp
        @foreach($response_data->question as $category => $questions)
            <h4 class="fw-bold">{{ $response_data->category->$category ?? 'Unknown' }}</h4>
            @if($questions)
                @php $qk = 1; @endphp
                @foreach($questions as $qus)
                    <div class="question-box d-flex justify-content-between align-items-start">
                        <span class="me-2 flex-grow-1">{{ $qus->title }}</span>
                        <span class="label-box fw-bold">label {{ $ck }} {{ $qk }}</span>
                    </div>
                    <p>{{ $qus->answer }}</p>
                    @php $qk++; @endphp
                @endforeach
            @endif
            @php $ck++; @endphp
        @endforeach
    @endif

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</body>
</html>
