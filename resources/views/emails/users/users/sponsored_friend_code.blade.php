@extends('emails.default')

@section('title', trans('auth.password_reset_title'))

@section('content')
<tr>
    <td class="wrapper">
        <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="table-layout:fixed;">
            <tr>
                <td>
                    <p>{{ $friend_code }}</p>
                </td>
            </tr>
        </table>
    </td>
</tr>
@endsection
