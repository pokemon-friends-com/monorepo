<table bgcolor="#cdcdc8" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center">
            <table class="table600" width="600" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center">
                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                            <tr>
                                <td height="25"></td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <table align="center" class="table-inner" width="520" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td align="center" style="line-height: 0px;">
                                                <img style="display:block; line-height:0px; font-size:0px; border:0px;" class="pattern" src="{{ asset('img/pattern-line.png') }}" width="519" height="9" />
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td height="25"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td  align="center" style="line-height: 0px;">
                        <img style="display:block; line-height:0px; font-size:0px; border:0px;" class="img1" src="{{ asset('img/footer-top.png') }}" width="600" height="81" />
                    </td>
                </tr>
                <tr>
                    <td align="center" bgcolor="#ffffff">
                        <table class="table-inner" width="520" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td valign="top">
                                    <!--Preference-->
                                    <table class="footer-column" align="left" width="224" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td height="15"></td>
                                        </tr>
                                        <tr valign="top">
                                            <td style="font-family: 'Open Sans', Arial, sans-serif; font-size:18px; color:#34495e; font-weight:bold;">Quelques liens</td>
                                        </tr>
                                        <tr>
                                            <td height="10"></td>
                                        </tr>
                                        <tr valign="top">
                                            <td class="textbutton" style="line-height:28px; font-family: 'Open Sans', Arial, sans-serif; font-size:13px; color:#bdc3c7;">
                                                <a href="{{ route('frontend.home') }}">Accueil</a>
                                            </td>
                                        </tr>
                                    </table>
                                    <!--End Preference-->
                                    {{--<!--Space-->--}}
                                    {{--<table width="1" height="25" border="0" cellpadding="0" cellspacing="0" align="left">--}}
                                        {{--<tr>--}}
                                            {{--<td style="font-size: 0;line-height: 0;border-collapse: collapse;">--}}
                                                {{--<p style="padding-left: 24px;">&nbsp;</p>--}}
                                            {{--</td>--}}
                                        {{--</tr>--}}
                                    {{--</table>--}}
                                    {{--<!--End Space-->--}}
                                    {{--<!--Link-->--}}
                                    {{--<table class="footer-column" align="left" width="112" border="0" cellspacing="0" cellpadding="0">--}}
                                        {{--<tr>--}}
                                            {{--<td height="15"></td>--}}
                                        {{--</tr>--}}
                                    {{--</table>--}}
                                    <!--End Link-->
                                    <!--Space-->
                                    <table width="1" height="25" border="0" cellpadding="0" cellspacing="0" align="left">
                                        <tr>
                                            <td style="font-size: 0;line-height: 0;border-collapse: collapse;">
                                                <p style="padding-left: 23px;">&nbsp;</p>
                                            </td>
                                        </tr>
                                    </table>
                                    <!--End Space-->
                                    <!--Footer note-->
                                    <table bgcolor="#f8f8f8" class="table-full" width="247" border="0" align="right" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td>
                                                <table class="footer-note" width="200" border="0" align="center" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td height="15"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-family: 'Open Sans', Arial, sans-serif; font-size:18px; color:#34495e; font-weight:bold;">{{ trans('leads.contacts') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td height="15"></td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="top" style="font-family: 'Open Sans', Arial, sans-serif; font-size:13px; color:#999999; line-height:20px;">
                                                            <p>
                                                                {{ trans('global.baseline') }}
                                                            </p>
                                                            <p>
                                                                <a href="{{ route('frontend.contact.index') }}">{{ trans('leads.contact_form') }}</a>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td height="15"></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <!--End Footer Note-->
                                </td>
                            </tr>
                            <tr>
                                <td height="30"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="center" style="line-height: 0px;">
                        <img style="display:block; line-height:0px; font-size:0px; border:0px;" class="img1" src="{{ asset('img/footer-bottom.png') }}" width="600" height="41" />
                    </td>
                </tr>
                <tr>
                    <td height="30" align="center" valign="bottom" style="font-family: 'Open Sans', Arial, sans-serif; font-size:13px; color:#7f8c8d;">
                        {!! trans('global.copyright', ['date' => date('Y'), 'route' => route('frontend.home'), 'name' => config('app.name')]) !!}
                    </td>
                </tr>
                <tr>
                    <td height="40"></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
