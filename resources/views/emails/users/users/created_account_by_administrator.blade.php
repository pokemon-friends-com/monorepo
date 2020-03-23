@extends('emails.default')

@section('title', trans('users.created_account_by_administrator_subject'))

@section('content')
<tr>
	<td class="wrapper">
		<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="table-layout:fixed;">
			<tr>
				<td>
					<p>{{ $civility_name }}</p>
					<p>{!! trans('users.created_account_by_administrator_text_reset_password') !!}</p>
					<table role="presentation" align="center" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
						<tbody>
						<tr>
							<td align="left">
								<table role="presentation" border="0" cellpadding="0" cellspacing="0">
									<tbody>
									<tr>
										<td><a href="{{ route('password.request') }}" target="_blank">{{ trans('auth.password_reset_title') }}</a></td>
									</tr>
									</tbody>
								</table>
							</td>
						</tr>
						</tbody>
					</table>
					<p>{!! trans('users.created_account_by_administrator_text_login') !!}</p>
					<table role="presentation" align="center" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
						<tbody>
						<tr>
							<td align="left">
								<table role="presentation" border="0" cellpadding="0" cellspacing="0">
									<tbody>
									<tr>
										<td><a href="{{ route('login') }}" target="_blank">{{ trans('auth.login') }}</a></td>
									</tr>
									</tbody>
								</table>
							</td>
						</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</table>
	</td>
</tr>
@endsection
