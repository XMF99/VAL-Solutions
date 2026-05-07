@extends($activeTemplate . 'layouts.master')
@section('panel')
    <div class="row responsive-row justify-content-start">
        <div class="col-lg-8">
            <x-panel.ui.card>
                <x-panel.ui.card.header>
                    <h4 class="card-title">@lang('KYC Information')</h4>
                    <p>@lang('Below are the details you provided during your KYC verification process.')</p>
                </x-panel.ui.card.header>
                <x-panel.ui.card.body>
                    @if ($user->kyc_data)
                        <ul class="list-group list-group-flush">
                            @foreach ($user->kyc_data as $val)
                                @continue(!$val->value)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ __($val->name) }}
                                    <span>
                                        @if ($val->type == 'checkbox')
                                            {{ implode(',', $val->value) }}
                                        @elseif($val->type == 'file')
                                            <a
                                                href="{{ route('user.download.attachment', encrypt(getFilePath('verify') . '/' . $val->value)) }}"><i
                                                    class="fa-regular fa-file"></i> @lang('Attachment') </a>
                                        @else
                                            <p>{{ __($val->value) }}</p>
                                        @endif
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <h5 class="text-center">@lang('KYC data not found')</h5>
                    @endif
                </x-panel.ui.card.body>
            </x-panel.ui.card>
        </div>
    </div>
@endsection
