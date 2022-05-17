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
                ANC
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
                width="40" rowspan="2">
                Total Data</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #C8C8C8"
                width="20" colspan="2">
                Kategori Badan
            </th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #C8C8C8"
                width="20" colspan="4">
                Kategori Tekanan Darah
            </th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #C8C8C8"
                width="20" colspan="2">
                Kategori Lingkar Lengan Atas
            </th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #C8C8C8"
                width="20" colspan="2">
                Kategori Denyut Jantung
            </th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #C8C8C8"
                width="20" colspan="2">
                Kategori Hemoglobin
            </th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #C8C8C8"
                width="20" colspan="2">
                Vaksin Tetanus Sebelum Hamil
            </th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #C8C8C8"
                width="20" colspan="2">
                Vaksin Tetanus Sesudah Hamil
            </th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #C8C8C8"
                width="20" colspan="2">
                Posisi Janin
            </th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #C8C8C8"
                width="20" colspan="2">
                Minum 90 Tablet Tambah Darah
            </th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #C8C8C8"
                width="20" colspan="2">
                Konseling
            </th>
        </tr>
        <tr style="border: 1px solid black">
            <th></th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #66ff00"
                width="20">
                Normal</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #fa6565"
                width="20">
                Resiko Tinggi</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #0099ff"
                width="20">
                Hipotensi</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #66ff00"
                width="20">
                Normal</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #c3ff00"
                width="20">
                Prahipertensi</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #ed1919"
                width="20">
                Hipertensi</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #05fe0d"
                width="20">
                Normal</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #ff1515"
                width="20">
                Kurang Gizi (BBLR)</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #05fe0d"
                width="20">
                Normal</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #ff1515"
                width="20">
                Tidak Normal</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #05fe0d"
                width="20">
                Normal</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #ff1515"
                width="20">
                Anemia</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #05fe0d"
                width="20">
                Sudah</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #ff1515"
                width="20">
                Belum</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #05fe0d"
                width="20">
                Sudah</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #ff1515"
                width="20">
                Belum</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #05fe0d"
                width="20">
                Normal</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #ff1515"
                width="20">
                Sungsang</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #05fe0d"
                width="20">
                Sudah</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #ff1515"
                width="20">
                Belum</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #05fe0d"
                width="20">
                Sudah</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #ff1515"
                width="20">
                Belum</th>
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
                    {{ $dataArray[$i]['totalBadanNormal'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArray[$i]['totalBadanResikoTinggi'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArray[$i]['totalTekananDarahHipotensi'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArray[$i]['totalTekananDarahNormal'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArray[$i]['totalTekananDarahPrahipertensi'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArray[$i]['totalTekananDarahHipertensi'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArray[$i]['totalLenganAtasNormal'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArray[$i]['totalLenganAtasKurangGizi'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArray[$i]['totalDenyutJantungNormal'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArray[$i]['totalDenyutJantungTidakNormal'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArray[$i]['totalHemoglobinDarahNormal'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArray[$i]['totalHemoglobinDarahAnemia'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArray[$i]['totalVaksinSebelumHamilSudah'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArray[$i]['totalVaksinSebelumHamilBelum'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArray[$i]['totalVaksinSesudahHamilSudah'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArray[$i]['totalVaksinSesudahHamilBelum'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArray[$i]['totalPosisiJaninNormal'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArray[$i]['totalPosisiJaninSungsang'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArray[$i]['totalMinum90TabletSudah'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArray[$i]['totalMinum90TabletBelum'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArray[$i]['totalKonselingSudah'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArray[$i]['totalKonselingBelum'] }}</td>
            </tr>
        @endfor
    </tbody>
</table>
