@extends('email')

@section('title', trans('auth.password_reset_title'))

@section('content')
<tr>
    <td class="wrapper">
        <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="table-layout:fixed;">
            <tr>
                <td>
                    <p>{{ trans('auth.password_reset_title') }}</p>
                    <p>{!! trans('auth.password_reset_text') !!}</p>
                    <table role="presentation" align="center" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                        <tbody>
                        <tr>
                            <td align="left">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                    <tbody>
                                    <tr>
                                        <td><a href="{{ route('password.reset', ['token' => $token]) }}" target="_blank">{{ trans('auth.password_reset_title') }}</a></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="info">
                        <p>{!! trans('auth.password_reset_footer_link') !!}</p>
                        <p>{{ route('password.reset', ['token' => $token]) }}</p>
                    </div>
                </td>
            </tr>
        </table>
    </td>
</tr>
@endsection
