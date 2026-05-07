@extends($activeTemplate . 'layouts.master')
@section('panel')
    <div class="row responsive-row justify-content-start">
        <div class="col-lg-8">
            <x-panel.ui.card>
                <x-panel.ui.card.header>
                    <h5 class="card-title">@lang('KYC Form')</h5>
                    <p class="mb-0">@lang('Complete your identity verification by filling out the secure KYC form below.')</p>
                </x-panel.ui.card.header>
                <x-panel.ui.card.body>
                    <form action="{{ route('user.kyc.submit') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <x-ovo-form identifier="act" identifierValue="kyc" />
                        <div class="form-group">
                            <x-panel.ui.btn.submit />
                        </div>
                    </form>
                </x-panel.ui.card.body>
            </x-panel.ui.card>
        </div>
    </div>
@endsection
