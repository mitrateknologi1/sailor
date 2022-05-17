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
                Deteksi Dini
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
                width="10">
                Nomor
            </th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #C8C8C8"
                width="40">
                Nama {{ $judulWilayah }}</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #C8C8C8"
                width="20">
                Total Data
            </th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #54ff05"
                width="40">
                Kehamilan KRR (Beresiko Rendah)
            </th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #ffff11"
                width="40">
                Kehamilan KRT (Beresiko TINGGI)
            </th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #ff1111"
                width="40">
                Kehamilan KRST (Beresiko SANGAT TINGGI)
            </th>
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
                    {{ $dataArray[$i]['totalData'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArray[$i]['totalResikoSangatTinggi'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArray[$i]['totalResikoTinggi'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArray[$i]['totalResikoRendah'] }}</td>
            </tr>
        @endfor
    </tbody>
</table>
