<table>
    <thead>
        <tr>
            <th></th>
        </tr>
        <tr>
            <th></th>
            <th colspan="2" style="vertical-align: center;font-weight : bold">
                Export :</th>
            <th colspan="2" style="vertical-align: center;font-weight : bold">
                {{ $tab == 'stunting_anak' ? 'Stunting Anak' : 'Deteksi Ibu Melahirkan Stunting' }}
            </th>
        </tr>
        <tr>
            <th></th>
            <th colspan="2" style="vertical-align: center;font-weight : bold">
                Tanggal Export : </th>
            <th colspan="2" style="vertical-align: center;font-weight : bold">
                {{ $hariIni }}
            </th>
        </tr>
        <tr>
            <th></th>
            <th colspan="2" style="vertical-align: center;font-weight : bold">
                Provinsi : </th>
            <th colspan="2" style="vertical-align: center;font-weight : bold">
                {{ $namaProvinsi }}
            </th>
        </tr>
        <tr>
            <th></th>
            <th colspan="2" style="vertical-align: center;font-weight : bold">
                Kabupaten : </th>
            <th colspan="2" style="vertical-align: center;font-weight : bold">
                {{ $namaKabupaten }}
            </th>
        </tr>
    </thead>
</table>

<table style="border: 1px solid black;background-color : #C8C8C8">
    <thead align="center">
        <tr style="border: 1px solid black">
            <th width="5"></th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #C8C8C8"
                width="10" rowspan="2">
                Nomor
            </th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #C8C8C8"
                width="40" rowspan="2">
                Nama {{ $judulWilayah }}</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #C8C8C8"
                width="20" colspan="2">
                Total Data
            </th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #fa6565"
                width="20" colspan="2">
                Sangat Pendek (Resiko Stunting Tinggi)
            </th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #e5ff1e"
                width="20" colspan="2">
                Pendek (Resiko Stunting Sedang)
            </th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #06c90d"
                width="20" colspan="2">
                Normal
            </th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #155bff"
                width="20" colspan="2">
                Tinggi
            </th>
        </tr>
        <tr style="border: 1px solid black">
            <th></th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #C8C8C8"
                width="20">
                Laki - Laki</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #C8C8C8"
                width="20">
                Perempuan</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #fa6565"
                width="20">
                Laki - Laki</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #fa6565"
                width="20">
                Perempuan</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #e5ff1e"
                width="20">
                Laki - Laki</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #e5ff1e"
                width="20">
                Perempuan</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #06c90d"
                width="20">
                Laki - Laki</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #06c90d"
                width="20">
                Perempuan</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #155bff"
                width="20">
                Laki - Laki</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #155bff"
                width="20">
                Perempuan</th>
        </tr>
    </thead>
    <tbody>
        @for ($i = 0; $i < count($mapDataWilayah); $i++)
            <tr style="border: 1px solid black">
                <th></th>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $i + 1 }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black">
                    {{ $mapDataWilayah[$i]['nama'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayPria[$i]['totalData'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayWanita[$i]['totalData'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayPria[$i]['totalStuntingAnakSangatPendek'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayWanita[$i]['totalStuntingAnakSangatPendek'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayPria[$i]['totalStuntingAnakPendek'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayWanita[$i]['totalStuntingAnakPendek'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayPria[$i]['totalStuntingAnakNormal'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayWanita[$i]['totalStuntingAnakNormal'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayPria[$i]['totalStuntingAnakTinggi'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayWanita[$i]['totalStuntingAnakTinggi'] }}</td>
            </tr>
        @endfor
    </tbody>
</table>
