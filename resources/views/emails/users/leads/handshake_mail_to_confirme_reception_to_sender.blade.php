@extends('emails.default')

@section('title', trans('users.leads.handshake_title', ['civility_name' => $civility_name]))

@section('content')
<tr>
	<td class="wrapper">
		<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="table-layout:fixed;">
			<tr>
				<td>
					<p>{{ $civility_name }}</p>
					<p>{!! trans('users.leads.handshake_body_header') !!}</p>
					<p>{!! $body !!}</p>
					<p>{!! trans('users.leads.handshake_body_footer', ['app_name' => config('app.name')]) !!}</p>
				</td>
			</tr>
		</table>
	</td>
</tr>
@endsection
