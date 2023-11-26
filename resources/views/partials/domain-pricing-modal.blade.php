<div class="modal fade" id="domain-pricing-modal" tabindex="-1" aria-labelledby="domain-pricing" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h1 class="modal-title text-primary fw-bold fs-4">Pricing by Domain</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-borderless">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Registration</th>
                                <th scope="col">Renewal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($total_costs['domains'] as $domain => $pricing)
                                <tr wire:key="domain-pricing-{{ Str::slug($domain) }}-{{ Str::random(10) }}">
                                    <td scope="row" style="width: 40%;">{{ $domain }}</td>
                                    <td style="width: 25%;">{{ $pricing['registration'] }}</td>
                                    <td style="width: 25%;">{{ $pricing['renewal'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
