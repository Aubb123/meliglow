<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>

    <body style="margin:0; padding:0; font-family:Arial, sans-serif; background-color:#f8f9fa;">

        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px; margin:0 auto;">
            <tr>
                <td bgcolor="#0098ff" style="padding: 30px 40px; text-align: center; color: #ffffffff;">
                    <h1 style="margin: 0; font-size: 24px;">{{config('app.name')}}</h1>
                </td>
            </tr>

            @yield('content')

            <!-- Réseaux sociaux -->
            <tr>
                <td bgcolor="#ffffff" style="padding: 20px 40px; text-align: center;">
                    <p style="margin: 0 0 10px; font-size: 14px; color: #333;">Suivez-nous :</p>
                    <a href="#" style="margin: 0 5px;">
                        <img src="https://cdn-icons-png.flaticon.com/24/733/733547.png" alt="Facebook" width="24" height="24" style="vertical-align: middle;" />
                    </a>
                    <a href="#" style="margin: 0 5px;">
                        <img src="https://cdn-icons-png.flaticon.com/24/3046/3046122.png" alt="TikTok" width="24" height="24" style="vertical-align: middle;" />
                    </a>
                </td>
            </tr>

            <tr>
                <td bgcolor="#0098ff" style="padding: 20px 40px; text-align: center; font-size: 12px; color: #ffffffff;">
                    © 2025 {{config('app.name')}}. Tous droits réservés.<br>
                    Cet email vous a été envoyé automatiquement, merci de ne pas y répondre.<br>
                </td>
            </tr>
        </table>

    </body>

</html>