<div>
    {{-- Enter Domains & Calculate --}}
    <div id="calculate" @class(['animate__animated animate__fadeOut' => !is_null($total_costs)])>
        <h3 class="text-center fw-light mb-4 animate__animated animate__pulse">Copy & paste your <a href="https://porkbun.com/account/domainList" target="_blank">simple list</a> of Porkbun domains below</h3>

        <div class="row justify-content-center">
            <div class="col-xl-10">
                {{-- Error Alert --}}
                @error('domains')
                    <div wire:loading.class.remove="animate__fadeIn" wire:loading.class="animate__fadeOut" class="alert alert-warning animate__animated animate__fadeIn" role="alert">
                        {{ $message }}
                    </div>
                @enderror

                <textarea wire:model="domains" class="form-control" rows="5"></textarea>

                <button wire:click="calculate" wire:loading.attr="disabled" class="btn btn-secondary d-block mx-auto mt-4" type="button">
                    <span wire:loading.class="d-none"><i class="fa-solid fa-coins me-1"></i> Calculate</span>
                    <span wire:loading><i class="fa-solid fa-coins fa-spin me-1"></i> Calculating...</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Calculation Results --}}
    @if (!is_null($total_costs))
        <div id="calculation" style="display: none;">
            <h3 class="text-center fw-light mb-4">Alrighty, here's your calculated costs!</h3>

            <div class="row justify-content-center text-center">
                {{-- Total Domains --}}
                <div class="col-md-3 align-self-center mb-4 mb-md-0">
                    <h4 class="text-primary fw-bold mb-3">Total Domains</h4>
                    <h3 class="fw-light mb-0">{{ $total_costs['total_domains'] }}</h3>
                </div>

                {{-- Registration Costs --}}
                <div class="col-md-3 align-self-center mb-4 mb-md-0">
                    <h4 class="text-primary fw-bold mb-3">Registration <sup class="text-muted" title="The price you pay to register the domain for the first time"><i class="fa-solid fa-circle-question fa-xs"></i></sup></h4>
                    <h3 class="fw-light mb-0">{{ $total_costs['total_registration']->format() }}</h3>
                </div>

                {{-- Renewal Costs --}}
                <div class="col-md-3 align-self-center">
                    <h4 class="text-primary fw-bold mb-3">Renewal <sup class="text-muted" title="The price you pay to keep your domain active after the initial registration period"><i class="fa-solid fa-circle-question fa-xs"></i></sup></h4>
                    <h3 class="fw-light mb-0">{{ $total_costs['total_renewal']->format() }}</h3>
                </div>
            </div>
            <small class="text-muted text-center d-block mt-3">Prices last fetched from the Porkbun API on {{ $last_fetched_date }}</small>

            <button class="btn btn-primary btn-sm d-block mx-auto mt-4 mb-3" type="button" data-bs-toggle="modal" data-bs-target="#domain-pricing-modal"><i class="fa-solid fa-list me-1"></i> View Pricing by Domain</button>

            <div class="text-center">
                <div class="btn-group" role="group" aria-label="Edit or reset domains">
                    <button wire:click="resetCalculation" class="btn btn-secondary" type="button"><i class="fa-solid fa-pen-to-square me-1"></i> Edit</button>
                    <button wire:click="resetCalculation(true)" class="btn btn-secondary" type="button"><i class="fa-solid fa-arrow-rotate-right me-1"></i> Reset</button>
                </div>
            </div>
        </div>

        {{-- Domain Pricing Modal --}}
        @includeWhen(!is_null($total_costs), 'partials.domain-pricing-modal')
    @endif
</div>