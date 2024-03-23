<table class="body-wrap" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: transparent; margin: 0">
    <tbody>
        <tr style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
            <td style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
            <td class="container" width="600" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
                <div class="content" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                    <table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" itemscope="" itemtype="http://schema.org/ConfirmAction" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; margin: 0; border: none;box-shadow: 0px 0px 5px #568ed38c;border-radius: 5px;border:1px solid #568ed38c">
                        <tbody><tr style="font-family: 'Roboto', sans-serif; font-size: 14px; margin: 0;">
                            <td class="content-wrap" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; color: #495057; font-size: 14px; vertical-align: top; margin: 0;padding: 30px; box-shadow: 0 3px 15px rgba(30,32,37,.06); ;border-radius: 7px; background-color: #fff;" valign="top">
                                <meta itemprop="name" content="Confirm Email" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                <table width="100%" cellpadding="0" cellspacing="0" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <tbody>
                                    <tr style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                        <td class="content-block" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                            <div style="text-align: center;margin-bottom: 15px;">
                                                <img src="{{asset('assets/images/logo-marvel-blue.png')}}" alt="" width="200">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 15px; margin: 0; border-top: 1px solid #e9ebec;">
                                        <td class="content-block" style="line-height: 2;color: #878a99; text-align: start;font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 15px; vertical-align: top; margin: 0; padding: 0; padding-top: 15px" valign="top">
                                            Cher(e) {{$exam->business->legal_name}}, <br><br>

                                            Nous vous informons qu'une nouvelle réservation d'examen a été effectuée dans notre système. Veuillez trouver ci-dessous les détails de la réservation : <br><br>
                                            
                                            Nom de l'examen : {{$exam->type_exam->name}}<br>
                                            Nom du patient : {{$exam->customer->first_name}} {{$exam->customer->last_name}} <br>
                                            Adresse e-mail du patient : {{$exam->customer->email}} <br>
                                            Numéro de téléphone du patient : {{$exam->customer->phone}}  <br><br>
                                            Nous vous demandons de prendre les mesures nécessaires pour assurer que tout soit prêt pour accueillir ce patient le jour de l'examen. <br><br>
                                            
                                            Cordialement,
                                        </td>
                                    </tr>
                                    
                                </tbody></table>
                            </td>
                        </tr>
                    </tbody></table>
                </div>
            </td>
        </tr>
    </tbody>
</table>