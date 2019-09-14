@extends('layouts.emails')

@section('title', trans('auth.password_reset_title'))

@section('content')
    <table bgcolor="#cdcdc8" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center">
                <table class="table600" width="600" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ffffff">
                    <tr>
                        <td height="40"></td>
                    </tr>
                    <tr>
                        <td align="center">
                            <table width="520" border="0" align="center" cellpadding="0" cellspacing="0" class="table-inner">
                                <tr>
                                    <td align="left" style="font-family: 'Open Sans', Arial, sans-serif; font-size:18px; color:#34495e; font-weight:bold;">{{ trans('auth.password_reset_title') }}</td>
                                </tr>
                                <tr>
                                    <td height="15" align="center" style="border-bottom:1px dotted #bdc3c7;"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table bgcolor="#cdcdc8" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center">
                <table class="table600" width="600" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ffffff">
                    <tr>
                        <td height="40"></td>
                    </tr>
                    <tr>
                        <td align="center">
                            <table width="520" border="0" align="center" cellpadding="0" cellspacing="0" class="table-inner">
                                <tr>
                                    <td  align="left"  style="font-family: 'Open Sans', Arial, sans-serif; font-size:13px; color:#999999; line-height:20px;">
                                        {!! trans('auth.password_reset_text') !!}
                                        <br />
                                        <br />
                                        <table class="textbutton" style="border-left: 3px solid #3498db;" border="0" align="left" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td height="30" bgcolor="#ecf0f1" align="center" style="font-family: 'Open Sans', Arial, sans-serif; font-size:13px; color:#7f8c8d;padding-left: 15px;padding-right: 15px;">
                                                    <a href="{{ route('password.reset', ['token' => $token]) }}">{{ trans('auth.password_reset_title') }}</a>
                                                </td>
                                            </tr>
                                            <tr></tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="30" align="center"></td>
                                </tr>
                                <tr>
                                    <td align="center" style="line-height: 0px;">
                                        <img style="display:block; line-height:0px; font-size:0px; border:0px;" class="pattern" src="{{ asset('images/pattern-line.png') }}" width="519" height="9" />
                                    </td>
                                </tr>
                                <tr>
                                    <td height="30" align="center"></td>
                                </tr>
                                <tr>
                                    <td align="left"  style="font-family: 'Open Sans', Arial, sans-serif; font-size:10px; color:#999999; line-height:18px;">
                                        {!! trans('auth.password_reset_footer_link') !!}
                                        <br/>
                                        <span style="font-size: 10px;">{{ route('password.reset', ['token' => $token]) }}</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection
