@props(['url', 'color' => 'primary', 'align' => 'center'])

<table class="action" align="{{ $align }}" width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td align="{{ $align }}">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                    <td align="{{ $align }}">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                <td>
                                    <a href="{{ $url }}"
                                        class="text-lg font-bold text-white py-2 px-8 bg-orange-ddteasy hover:bg-orange-ddteasy/90 "
                                        target="_blank" style="text-decoration: none" rel="noopener">{{$slot}}</a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
