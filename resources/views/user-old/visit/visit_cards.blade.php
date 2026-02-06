<div class="row">
    @foreach($results as $rowData)
        @php
            \Carbon\Carbon::setLocale('nl');
            $startDate = \Carbon\Carbon::parse($rowData->start_datetime);
            $endDate   = \Carbon\Carbon::parse($rowData->end_datetime);
        @endphp
        <div class="col-md-6 col-lg-4 col-div">
            <div class="card border-2 border-d4dedc rounded-4">
                <div class="card-body px-2 py-3">
                    <div class="align-items-center d-flex mb-1">
                        <div style="width: 60px;">
                            <img src="{{ $rowData->branch->image }}" class="w-100" style="clip-path: circle(33%);">
                        </div>
                        <div>
                            {{ $startDate->format('d/m/Y (D)') }} - {{ $endDate->format('d/m/Y (D)') }}
                        </div>
                    </div>
                    <div>
                        <h5>{{ $rowData->questionnaire->name }}</h5>
                        <div class="rounded-5 p-2 mb-2" style="background: #f9f9f9;">
                            {{ $rowData->branch->address_1??'' }} {{ $rowData->branch->postal_code??'' }} {{ $rowData->branch->locality??'' }}
                        </div>
                        <div class="rounded-3 p-2 mb-2 align-items-center d-flex justify-content-between visitNote h-55px" style="background: #faf7fe;" data-note="{{ $rowData->description }}">
                            <span class="short_desc">{{ $rowData->description }}</span>
                            <i class='bx bx-expand-alt ml-1'></i>
                        </div>
                        <div class="pt-2 pb-2">
                            <span class="rounded-5 p-2 bg-ebf5ff border-d4dedc fw-medium border-2">
                                <span class="text-2c6e88">Fee €</span>{{ $rowData->price }}
                            </span>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="rounded-5 p-2 bg-ebf5ff border-d4dedc text-2c6e88 h-100 fw-medium border-2">
                                Expense Estimate €<span class="text-black">{{ $rowData->price }}</span> - €<span class="text-black">{{ $rowData->price }}</span>
                            </span>
                            <button type="button" class="btn bx bx-heart fs-1 text-2c6e88" onclick="requestVisit({{ $rowData->id }},this)"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
