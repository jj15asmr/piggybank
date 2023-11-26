<?php

namespace App\Http\Livewire;

use App\Actions\CalculateTotalDomainCostsAction;
use App\Exceptions\InvalidDomainException;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class DomainCostsComponent extends Component
{
    public ?string $domains = null;
    public ?array $total_costs = null;
    public ?string $last_fetched_date = null;

    public function mount(): void
    {
        $last_fetched_date = Storage::get('last-fetched.txt');
        if (!is_null($last_fetched_date) && $last_fetched_date != '') {
            $this->last_fetched_date = $last_fetched_date;
        } else {
            $this->last_fetched_date = 'n/a';
        }
    }

    public function calculate(CalculateTotalDomainCostsAction $calculate): void
    {
        $this->validate(
            ['domains' => 'required'],
            ['domains.required' => 'Hold your hooves! Enter some domains first.'],
        );

        try {
            $this->total_costs = $calculate($this->domains);

        } catch (InvalidDomainException $ex) {
            $this->addError('domains', "\"{$ex->domain}\" doesn't seem to be a valid domain, please check :)");
        }
    }

    public function resetCalculation(bool $hard = false): void
    {
        !$hard ? $this->total_costs = null : $this->domains = $this->total_costs = null;
    }

    public function render(): mixed
    {
        return view('livewire.domain-costs-component')
            ->layout('components.layouts.app');
    }
}
