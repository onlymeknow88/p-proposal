<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        [size="A4"] {
            width: 21cm;
            height: 29.7cm;
        }

        @media print {

            body,
            [size="A4"] {
                background: white;
                margin: 0;
                box-shadow: 0;
            }
        }
    </style>
</head>

<body size="A4">
    <div style="width:700px">


        <table style="width:100%;">
            <tr>
                <th style="font-size: 24px;text-align:left;padding: 20px">PT Maruwai Coal</th>
                <th style="text-align:right;padding: 20px"><img style="width: 112px; height: 47px"
                        src="{{ asset('img/admr 1.png') }}" />
                </th>
            </tr>
        </table>

        <table style="width:100%;">
            <tr>
                <th style="font-size:20px">NON ORDER PAYMENT REQUEST</th>
            </tr>
            <tr>
                <th style="border-bottom:2px solid #000000;text-align:left;font-size:10px;color: #52525b">v.05 - July 22
                </th>
            </tr>
        </table>


        <table style="width:100%;font-size:14px;margin-top:16px; ">
            <tr style="vertical-align: top;">
                <td style="padding-top:4px;padding-bottom:4px;">
                    <table>
                        <tr>
                            <td style="width:100px; font-family: Inter;font-size:11px">Purpose of Payment</td>
                            <td style="width:15px">:</td>
                            <td
                                style="border:0.5px solid #000000;width: 200px;padding:6px;font-family: Inter;font-size:11px">
                                {{ $formNop->getPurpay['purpay_name'] }}
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="padding-top:4px;padding-bottom:4px;">
                    <table>
                        <tr>
                            <td style="width:100px; font-family: Inter;font-size:11px">Account Name</td>
                            <td style="width:15px">:</td>
                            <td
                                style="border:0.5px solid #000000;width: 200px;padding:6px;font-family: Inter;font-size:11px">
                                {{ $formNop->acc_name }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr style="vertical-align: top;">
                <td style="padding-top:4px;padding-bottom:4px;vertical-align: top;">
                    <table>
                        <tr>
                            <td style="width:100px; font-family: Inter;font-size:11px">Beneficiary / Provider</td>
                            <td style="width:15px">:</td>
                            <td style="border:0.5px solid #000000;width: 200px;padding:6px;height:50px;font-size:11px">
                                {{ $formNop->provider }}
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="padding-top:4px;padding-bottom:4px;">
                    <table>
                        <tr>
                            <td style="width:100px; font-family: Inter;font-size:11px">Bank Name</td>
                            <td style="width:15px">:</td>
                            <td style="border:0.5px solid #000000;width: 200px;padding:6px;height:50px;font-size:11px">
                                {{ $formNop->bank_name }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr style="vertical-align: top;">
                <td style="padding-top:4px;padding-bottom:4px;">
                    <table>
                        <tr>
                            <td style="width:100px; font-family: Inter;font-size:11px">Amount</td>
                            <td style="width:15px">:</td>
                            <td
                                style="border:0.5px solid #000000;width: 200px;padding:6px;font-family: Inter;font-size:11px">
                                {{ Helper::formatWithoutRupiah($formNop->amount) }}
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="padding-top:4px;padding-bottom:4px;">
                    <table>
                        <tr>
                            <td style="width:100px; font-family: Inter;font-size:11px">Account No</td>
                            <td style="width:15px">:</td>
                            <td
                                style="border:0.5px solid #000000;width: 200px;padding:6px;font-family: Inter;font-size:11px">
                                {{ $formNop->account_no }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr style="vertical-align: top;">
                <td style="padding-top:4px;padding-bottom:4px;">
                    <table>
                        <tr>
                            <td style="width:100px; font-family: Inter;font-size:11px">Due Date</td>
                            <td style="width:15px">:</td>
                            <td
                                style="border:0.5px solid #000000;width: 200px;padding:6px;font-family: Inter;font-size:11px;background: #FFFF9B;">
                                {{ $formNop->due_date }}
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="padding-top:4px;padding-bottom:4px;;">
                    <table>
                        <tr>
                            <td style="width:100px; font-family: Inter;font-size:11px">Email Address</td>
                            <td style="width:15px">:</td>
                            <td
                                style="border:0.5px solid #000000;width: 200px;padding:6px;font-family: Inter;font-size:11px;background: #FFFF9B;text-decoration: underline; color:#006FEE">
                                {{ $formNop->email }}
                            </td>
                        </tr>
                    </table>
                    <span
                        style="color: #71717A; font-size: 10px; font-family: Inter;font-size:11px font-style: italic; font-weight: 400; word-wrap: break-word;margin-top: 6px">(Please
                        input 1 email to receive payment notification)</span>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding-top:4px;padding-bottom:4px;">
                    <table>
                        <tr>
                            <td style="width:100px; font-family: Inter;font-size:11px">Other Info (if any)</td>
                            <td style="width:15px">:</td>
                            <td
                                style="border:0.5px solid #000000;width: 550px;padding:6px;height:14px;font-size: 10px;">
                                {{ $formNop->other_info }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table style="width:100%;border-collapse:collapse;">
            <thead style="font-size:11px; color: white">
                <tr>
                    <th style="padding:6px;background: black;">GL Account</th>
                    <th style="padding:6px;background: black;">Description</th>
                    <th style="padding:6px;background: black;">Amount</th>
                    <th style="padding:6px;background: black;">Cost Center or Project ID</th>
                </tr>
            </thead>
            <tbody style="font-size:13px;text-align:center;">
                <tr>
                    <td style="padding:12px;border: 0.5px solid #d4d4d8;">{{ $formNop->getamount['GLAccount'] }}
                    </td>
                    <td style="padding:12px;border: 0.5px solid #d4d4d8;;text-align:left">{{ $formNop->desc }}</td>
                    <td style="padding:12px;border: 0.5px solid #d4d4d8;">
                        {{ Helper::formatWithoutRupiah($formNop->amount) }}
                    </td>
                    <td style="padding:12px;border: 0.5px solid #d4d4d8;">
                        {{ $formNop->getamount->gl_acc['CostCenter'] }}</td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:10px;padding-bottom:10px;border: 0.5px solid #d4d4d8">
                        <table style="width:100%;text-align: left">
                            <tr>
                                <td style="font-family: Inter;font-size:14px;font-weight:700" colspan="4">
                                    Explanation/ justification :</td>

                            </tr>
                            <tr>
                                <td colspan="2" style="width:100%;padding:6px;height:50px;text-align:left">
                                    {{ $formNop->explanation }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="background: black;color:white;padding:10px;text-align:right">TOTAL</td>
                    <td style="background: black;color:white;padding:10px;text-align:right" colspan="2">
                        {{ Helper::formatRupiah($formNop->amount) }}</td>
                    <td style="background: black;color:white;padding:10px;text-align:right"></td>
                </tr>
            </tbody>
        </table>
        <table style="width:100%;margin-top:20px;border-collapse:collapse">
            <tr>
                <td style="border: 0.5px solid black;width:50px;font-size:12px;text-align:center;font-weight: 700;padding-top:4px;padding-bottom:4px">Prepared by</td>
                <td style="border: 0.5px solid black;width:50px;font-size:12px;text-align:center;font-weight: 700;padding-top:4px;padding-bottom:4px">Reviewed by</td>
                <td colspan="2" style="border: 0.5px solid black;width:50px;font-size:12px;text-align:center;font-weight: 700;padding-top:4px;padding-bottom:4px">Approved by</td>
            </tr>
            <tr>
                <td style="height: 100px;border: 0.5px solid black;width:50px;font-size:12px"></td>
                <td style="height: 100px;border: 0.5px solid black;width:50px;font-size:12px"></td>
                <td style="height: 100px;border: 0.5px solid black;width:50px;font-size:12px"></td>
                <td style="height: 100px;border: 0.5px solid black;width:50px;font-size:12px"></td>
            </tr>
            <tr>
                <td style="border: 0.5px solid black;width:50px;font-size:12px;;text-align:center;font-weight: 700;padding-top:4px;padding-bottom:4px;background: #FFFF9B;">Govrel Supervisor</td>
                <td style="border: 0.5px solid black;width:50px;font-size:12px;;text-align:center;font-weight: 700;padding-top:4px;padding-bottom:4px;background: #FFFF9B;">Comrel & Govrel Dept Head</td>
                <td style="border: 0.5px solid black;width:50px;font-size:12px;;text-align:center;font-weight: 700;padding-top:4px;padding-bottom:4px;background: #FFFF9B;">ER Divisions Head</td>
                <td style="border: 0.5px solid black;width:50px;font-size:12px;;text-align:center;font-weight: 700;padding-top:4px;padding-bottom:4px;background: #FFFF9B;">Director</td>
            </tr>
        </table>
    </div>

</body>

</html>
