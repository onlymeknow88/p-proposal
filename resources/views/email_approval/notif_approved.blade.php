<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=us-ascii" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
    </style>
</head>

<body>


    <table cellpadding="0" cellspacing="0" style="width:100%">
        <tr>
            <td colspan="2" style="font-family:'Assistant',Helvetica,Arial,sans-serif;font-size:14px;">Dear Bapak/Ibu,
                {{ $data['emp_name'] }}</td>
        </tr>
        <tr>
            <td colspan="2" style="height: 20px"></td>
        </tr>
        <tr>
            @if ($sts_approval == 'Approved')
                <td colspan="2" style="font-family:'Assistant',Helvetica,Arial,sans-serif;font-size:14px;">Your
                    Please be notified the approval process of your Proposal Request (PROPOSAL NO: <a
                        href="#">{{ $data['prop_no'] }}</a>) has been completed with
                    details:</td>
            @elseif ($sts_approval == 'rejected')
                <td colspan="2" style="font-family:'Assistant',Helvetica,Arial,sans-serif;font-size:14px;">Your
                    Please be notified the approval process of your Proposal Request (PROPOSAL NO: <a
                        href="#">{{ $data['prop_no'] }}</a>) has been rejected with
                    details:</td>
            @elseif ($sts_approval == 'Return')
                <td colspan="2" style="font-family:'Assistant',Helvetica,Arial,sans-serif;font-size:14px;">Your
                    Please be notified the approval process of your Proposal Request (PROPOSAL NO: <a
                        href="#">{{ $data['prop_no'] }}</a>) has been return with
                    details:</td>
            @else
                <td colspan="2" style="font-family:'Assistant',Helvetica,Arial,sans-serif;font-size:14px;">We need
                    your
                    approval for Proposal Request (PROPOSAL NO: <a href="#">{{ $data['prop_no'] }}</a>) for with
                    following
                    details:</td>
            @endif
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr style="background-color: #84cc16">
            <td style="width: 100%;text-align: left;font-family:'Assistant',Helvetica,Arial,sans-serif;font-size:15px;font-weight: bold;height: 25px;padding-left: 2px;"
                colspan="2">
                PROPOSAL INFORMATION
            </td>
        </tr>
        <tr>
            <td
                style="font-family:'Assistant',Helvetica,Arial,sans-serif; padding-left: 5px;text-align: left;font-size: 14px;color: #525252;font-weight: bold;width: 150px;vertical-align: middle;padding: 2px;width: 180px;">
                <strong>Judul Proposal</strong>
            </td>
            <td
                style="font-size: 14px;font-family:'Assistant',Helvetica,Arial,sans-serif;vertical-align: middle;padding: 2px;width: 500px;">
                <table width="100%">
                    <tr>
                        <td
                            style="font-family:'Assistant',Helvetica,Arial,sans-serif; font-size: 14px;font-family:'Assistant',Helvetica,Arial,sans-serif; color: #000000; background-color: #ffffff;border: 1px solid #c1c1c1; padding: 2px;">
                            {{ $data['judul'] }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        {{-- <tr>
            <td
                style="font-family:'Assistant',Helvetica,Arial,sans-serif; padding-left: 5px;text-align: left;font-size: 14px;color: #525252;font-weight: bold;width: 150px;vertical-align: middle;padding: 2px;width: 180px;">
                <strong>Tanggal Pengajuan</strong>
            </td>
            <td
                style="font-size: 14px;font-family:'Assistant',Helvetica,Arial,sans-serif;vertical-align: middle;padding: 2px;width: 500px;">
                <table width="100%">
                    <tr>
                        <td
                            style="font-family:'Assistant',Helvetica,Arial,sans-serif; font-size: 14px;font-family:'Assistant',Helvetica,Arial,sans-serif; color: #000000; background-color: #ffffff;border: 1px solid #c1c1c1; padding: 2px;">
                            {{ $data['tgl_pengajuan'] }}</td>
                    </tr>
                </table>
            </td>
        </tr> --}}
        <tr>
            <td
                style="font-family:'Assistant',Helvetica,Arial,sans-serif; padding-left: 5px;text-align: left;font-size: 14px;color: #525252;font-weight: bold;width: 150px;vertical-align: middle;padding: 2px;width: 180px;">
                <strong>Skala Prioritas</strong>
            </td>
            <td
                style="font-size: 14px;font-family:'Assistant',Helvetica,Arial,sans-serif;vertical-align: middle;padding: 2px;width: 500px;">
                <table width="100%">
                    <tr>
                        <td
                            style="font-family:'Assistant',Helvetica,Arial,sans-serif; font-size: 14px;font-family:'Assistant',Helvetica,Arial,sans-serif; color: #000000; background-color: #ffffff;border: 1px solid #c1c1c1; padding: 2px;">
                            {{ $data['skala_prioritas'] }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td
                style="font-family:'Assistant',Helvetica,Arial,sans-serif; padding-left: 5px;text-align: left;font-size: 14px;color: #525252;font-weight: bold;width: 150px;vertical-align: middle;padding: 2px;width: 180px;">
                <strong>Budget Program</strong>
            </td>
            <td
                style="font-size: 14px;font-family:'Assistant',Helvetica,Arial,sans-serif;vertical-align: middle;padding: 2px;width: 500px;">
                <table width="100%">
                    <tr>
                        <td
                            style="font-family:'Assistant',Helvetica,Arial,sans-serif; font-size: 14px;font-family:'Assistant',Helvetica,Arial,sans-serif; color: #000000; background-color: #ffffff;border: 1px solid #c1c1c1; padding: 2px;">
                            {{ $data['BudgetName'] }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td
                style="font-family:'Assistant',Helvetica,Arial,sans-serif; padding-left: 5px;text-align: left;font-size: 14px;color: #525252;font-weight: bold;width: 150px;vertical-align: middle;padding: 2px;width: 180px;">
                <strong>Budget Diberikan Total</strong>
            </td>
            <td
                style="font-size: 14px;font-family:'Assistant',Helvetica,Arial,sans-serif;vertical-align: middle;padding: 2px;width: 500px;">
                <table width="100%">
                    <tr>
                        <td
                            style="font-family:'Assistant',Helvetica,Arial,sans-serif; font-size: 14px;font-family:'Assistant',Helvetica,Arial,sans-serif; color: #000000; background-color: #ffffff;border: 1px solid #c1c1c1; padding: 2px;">
                            IDR {{ Helper::formatWithoutRupiah($data['jumlah_bantuan']) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        {{-- <tr>
            <td
                style="font-family:'Assistant',Helvetica,Arial,sans-serif; padding-left: 5px;text-align: left;font-size: 14px;color: #525252;font-weight: bold;width: 150px;vertical-align: middle;padding: 2px;width: 180px;">
                <strong>Pemohon Bantuan</strong>
            </td>
            <td
                style="font-size: 14px;font-family:'Assistant',Helvetica,Arial,sans-serif;vertical-align: middle;padding: 2px;width: 500px;">
                <table width="100%">
                    <tr>
                        <td stlye="font-size:12px;font-weight:bold">Propinsi</td>
                        <td stlye="font-size:12px;font-weight:bold">Kabupaten</td>
                        <td stlye="font-size:12px;font-weight:bold">Kecamatan</td>
                        <td stlye="font-size:12px;font-weight:bold">Kelurahan</td>
                    </tr>
                    <tr>
                        @php
                            $propinsi = DB::table('propinsis')
                                ->where('id', $data['propinsi_id'])
                                ->where('hidden', 1)
                                ->first();
                            $kabupaten = DB::table('kabupatens')
                                ->where('id', $data['kabupaten_id'])
                                ->where('hidden', 1)
                                ->first();
                            $kecamatan = DB::table('kecamatans')
                                ->where('id', $data['kecamatan_id'])
                                ->where('hidden', 1)
                                ->first();
                            $kelurahan = DB::table('kelurahans')
                                ->where('id', $data['kelurahan_id'])
                                ->where('hidden', 1)
                                ->first();
                        @endphp
                        <td
                            style="font-family:'Assistant',Helvetica,Arial,sans-serif; font-size: 14px;font-family:'Assistant',Helvetica,Arial,sans-serif; color: #000000; background-color: #ffffff;border: 1px solid #c1c1c1; padding: 2px;">
                            {{ $propinsi->name }}</td>
                        <td
                            style="font-family:'Assistant',Helvetica,Arial,sans-serif; font-size: 14px;font-family:'Assistant',Helvetica,Arial,sans-serif; color: #000000; background-color: #ffffff;border: 1px solid #c1c1c1; padding: 2px;">
                            {{ $kabupaten->name }}</td>
                        <td
                            style="font-family:'Assistant',Helvetica,Arial,sans-serif; font-size: 14px;font-family:'Assistant',Helvetica,Arial,sans-serif; color: #000000; background-color: #ffffff;border: 1px solid #c1c1c1; padding: 2px;">
                            {{ $kecamatan->name }}</td>
                        <td
                            style="font-family:'Assistant',Helvetica,Arial,sans-serif; font-size: 14px;font-family:'Assistant',Helvetica,Arial,sans-serif; color: #000000; background-color: #ffffff;border: 1px solid #c1c1c1; padding: 2px;">
                            {{ $kelurahan->name }}</td>
                    </tr>
                </table>
            </td>
        </tr> --}}
        <tr>
            <td
                style="font-family:'Assistant',Helvetica,Arial,sans-serif; padding-left: 5px;text-align: left;font-size: 14px;color: #525252;font-weight: bold;width: 150px;vertical-align: middle;padding: 2px;width: 180px;">
                <strong>Cooment Assesment</strong>
            </td>
        </tr>
        <tr>
            <td colspan="2"
                style="font-size: 14px;font-family:'Assistant',Helvetica,Arial,sans-serif;vertical-align: middle;padding: 2px; width:500px">
                <table width="100%">
                    <tr>
                        <td
                            style="font-family:'Assistant',Helvetica,Arial,sans-serif; font-size: 14px;font-family:'Assistant',Helvetica,Arial,sans-serif; color: #000000; background-color: #ffffff;border: 1px solid #c1c1c1; padding: 8px;">
                            {!! $data['ass_proposal'] !!}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        {{-- @if ($sts_approval == 'Return')
            <tr style="background-color: #84cc16;margin-top:8px;">
                <td style="width: 100%;text-align: left;font-family:'Assistant',Helvetica,Arial,sans-serif;font-size:15px;font-weight: bold;height: 25px;padding-left: 2px;"
                    colspan="2">
                    Rejected Reason
                </td>
            </tr>
            <tr>
                <td
                    style="font-family:'Assistant',Helvetica,Arial,sans-serif; padding-left: 5px;text-align: left;font-size: 14px;color: #525252;font-weight: bold;width: 150px;vertical-align: middle;padding: 2px;width: 180px;">
                    <strong>Noted</strong>
                </td>
            </tr>
            <tr>
                <td colspan="2"
                    style="font-size: 14px;font-family:'Assistant',Helvetica,Arial,sans-serif;vertical-align: middle;padding: 2px; width:500px">
                    <table width="100%">
                        <tr>
                            <td
                                style="font-family:'Assistant',Helvetica,Arial,sans-serif; font-size: 14px;font-family:'Assistant',Helvetica,Arial,sans-serif; color: #000000; background-color: #ffffff;border: 1px solid #c1c1c1; padding: 8px;">
                                {!! $data['note'] !!} </td>
                        </tr>
                    </table>
                </td>
            </tr>
        @endif --}}
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr style="background-color: #84cc16">
            <td style="width: 100%;text-align: left;font-family:'Assistant',Helvetica,Arial,sans-serif;font-size:15px;font-weight: bold;height: 25px;padding-left: 2px;"
                colspan="2">
                APPROVAL
            </td>
        </tr>
        <tr
            style="font-family:'Assistant',Helvetica,Arial,sans-serif;padding-left: 5px;text-align: left;font-size: 14px;color: #525252;font-weight: bold;width: 150px;vertical-align: middle;padding: 2px;width: 180px">
            <td colspan="2">
                <table style="width:100%">
                    <tr>
                        <td style="font-size:13px;font-weight:bold;">No</td>
                        <td style="font-size:13px;font-weight:bold;">Approval Level</td>
                        <td style="font-size:13px;font-weight:bold;">Approval</td>
                        <td style="font-size:13px;font-weight:bold;">Status</td>
                        <td style="font-size:13px;font-weight:bold;">Status Date</td>
                    </tr>
                    <tr>
                        <td style="font-size:13px">1</td>
                        <td>
                            <table width="100%">
                                <tr>
                                    <td
                                        style="font-family:'Assistant',Helvetica,Arial,sans-serif;font-size: 13px;color: #000000;background-color: #ffffff;border: 1px solid #c1c1c1;padding: 2px;">
                                        {{ $approval_level }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table width="100%">
                                <tr>
                                    <td
                                        style="font-family:'Assistant',Helvetica,Arial,sans-serif;font-size: 13px;color: #000000;background-color: #ffffff;border: 1px solid #c1c1c1;padding: 2px;">
                                        {{ $nama_approval }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table width="100%">
                                <tr>
                                    <td
                                        style="font-family:'Assistant',Helvetica,Arial,sans-serif;font-size: 13px;color: #000000;background-color: #ffffff;border: 1px solid #c1c1c1;padding: 2px;">
                                        {{ $sts_approval }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table width="100%">
                                <tr>
                                    <td
                                        style="font-family:'Assistant',Helvetica,Arial,sans-serif;font-size: 13px;color: #000000;background-color: #ffffff;border: 1px solid #c1c1c1;padding: 2px;">
                                        {{ $tgl_approval }}

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        {{-- <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">
                <div>
                    <span style="color: #0070c0">Please reply email with </span><b><span>y</span></b><span
                        style="color: #0070c0"> to Approve or </span><b><span>n</span></b><span style="color: #0070c0"> to
                        Reject</span>
                </div>
            </td>
        </tr> --}}
    </table>

</body>

</html>
