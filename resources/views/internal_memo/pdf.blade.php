<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        ol {
            display: block;
            margin-block-start: 0px;
            margin-block-end: 0px;
            margin-inline-start: 0px;
            margin-inline-end: 0px;
            padding-inline-start: 0px;
            margin-top: 0px !important;
            margin-bottom: 0px !important;
        }

        p {
            display: block;
            margin-block-start: 0px;
            margin-block-end: 0px;
            margin-inline-start: 0px;
            margin-inline-end: 0px;
            margin-top: 0px !important;
            margin-bottom: 0px !important;
        }

        .table table, .table td, .table th {
            border-collapse:  collapse;
            border: 0.5px solid #d4d4d8;
        }

    </style>
</head>

<body>
    <div style="width: 700px">
        <table style="width: 100%;">
            <tr>
                <th style="text-align: left;font-size: 18px;padding-bottom: 10px" colspan="3">
                    Internal Memo
                </th>
            </tr>
            <tr>
                <td style="width: 100px;padding-top:3px;padding-bottom:3px">To</td>
                <td style="width: 30px;padding-top:3px;padding-bottom:3px">:</td>
                <td style="">{{ $data['to'] }}</td>
            </tr>
            <tr>
                <td style="width: 100px;padding-top:3px;padding-bottom:3px">From</td>
                <td style="width: 30px;padding-top:3px;padding-bottom:3px">:</td>
                <td style="padding-top:3px;padding-bottom:3px">{{ $data['from'] }}</td>
            </tr>
            <tr>
                <td style="width: 100px;padding-top:3px;padding-bottom:3px">Date</td>
                <td style="width: 30pxpadding-top:3px;padding-bottom:3px;">:</td>
                <td style="padding-top:3px;padding-bottom:3px">{{ $data['date'] }}</td>
            </tr>
            <tr>
                <td style="width: 100px;padding-top:3px;padding-bottom:3px">Perihal</td>
                <td style="width: 30px;padding-top:3px;padding-bottom:3px">:</td>
                <td style="padding-top:3px;padding-bottom:3px">{!! $data['judul'] !!}
                </td>
            </tr>
            <tr>
                <td style="border-bottom:1px solid #000000;text-align:left;font-size:10px;color: #52525b"
                    colspan="3">
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    {!! $data['ass_proposal'] !!}
                </td>
            </tr>
        </table>
        <table style="width:100%;margin-top:20px;border-collapse:collapse">
            <tr>
                <td style="width:50px;text-align:left;padding-top:4px;padding-bottom:4px">Hormat Kami,</td>
                <td style="width:50px;text-align:center;padding-top:4px;padding-bottom:4px">Menyetujui</td>
            </tr>
            <tr>
                <td style="height: 100px;width:50px;font-size:12px"></td>
                <td style="height: 100px;width:50px;font-size:12px"></td>
            </tr>
            <tr>
                <td style="width:50px;text-align:left;padding-top:4px;padding-bottom:4px;text-decoration:underline;font-weight:700">{{ $data['from'] }}</td>
                <td style="width:50px;text-align:center;padding-top:4px;padding-bottom:4px;text-decoration:underline;font-weight:700">{{ $data['to'] }}</td>
            </tr>
            <tr>
                <td style="width:50px;text-align:left;padding-top:4px;padding-bottom:4px;">External Relation Division Head</td>
                <td style="width:50px;text-align:center;padding-top:4px;padding-bottom:4px;">Director</td>
            </tr>
        </table>
    </div>
</body>

</html>
