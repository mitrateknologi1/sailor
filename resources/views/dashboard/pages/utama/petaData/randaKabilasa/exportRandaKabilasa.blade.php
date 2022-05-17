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
                Randa Kabilasa
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
                width="10" rowspan="3">
                Nomor
            </th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #C8C8C8"
                width="40" rowspan="3">
                Nama {{ $judulWilayah }}</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #C8C8C8"
                width="20" colspan="2" rowspan="2">
                Total Data
            </th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #C8C8C8"
                width="20" colspan="6">
                Kategori Hemoglobin (HB)
            </th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #C8C8C8"
                width="20" colspan="4">
                Kategori Lingkar Lengan Atas
            </th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #C8C8C8"
                width="20" colspan="10">
                Kategori Indeks Masa Tubuh
            </th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #C8C8C8"
                width="20" colspan="4">
                Asesmen Mencegah Malnutrisi
            </th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #C8C8C8"
                width="20" colspan="4">
                Asesmen Meningkatkan Life Skill
            </th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #C8C8C8"
                width="20" colspan="4">
                Asesmen Mencegah Pernikahan Dini
            </th>
        </tr>
        <tr style="border: 1px solid black">
            <th></th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #37ff00"
                width="20" colspan="2">
                Normal</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #f2ff00"
                width="20" colspan="2">
                Terindikasi Anemia</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #ff0000"
                width="20" colspan="2">
                Anemia</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #37ff00"
                width="20" colspan="2">
                Normal</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #ff0000"
                width="20" colspan="2">
                Kurang Gizi</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #ff0000"
                width="20" colspan="2">
                Sangat Kurus</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #f2ff00"
                width="20" colspan="2">
                Kurus</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #06c90d"
                width="20" colspan="2">
                Normal</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #f2ff00"
                width="20" colspan="2">
                Gemuk</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #ff0000"
                width="20" colspan="2">
                Sangat Gemuk</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #06c90d"
                width="30" colspan="2">
                Berpartisipasi Mencegah Stunting</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #ff0000"
                width="30" colspan="2">
                Tidak Berpartisipasi Mencegah Stunting</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #06c90d"
                width="30" colspan="2">
                Berpartisipasi Mencegah Stunting</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #ff0000"
                width="30" colspan="2">
                Tidak Berpartisipasi Mencegah Stunting</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #06c90d"
                width="30" colspan="2">
                Berpartisipasi Mencegah Stunting</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #ff0000"
                width="30" colspan="2">
                Tidak Berpartisipasi Mencegah Stunting</th>
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
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #37ff00"
                width="20">
                Laki - Laki</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #37ff00"
                width="20">
                Perempuan</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #f2ff00"
                width="20">
                Laki - Laki</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #f2ff00"
                width="20">
                Perempuan</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #ff0000"
                width="20">
                Laki - Laki</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #ff0000"
                width="20">
                Perempuan</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #37ff00"
                width="20">
                Laki - Laki</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #37ff00"
                width="20">
                Perempuan</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #ff0000"
                width="20">
                Laki - Laki</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #ff0000"
                width="20">
                Perempuan</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #ff0000"
                width="20">
                Laki - Laki</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #ff0000"
                width="20">
                Perempuan</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #f2ff00"
                width="20">
                Laki - Laki</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #f2ff00"
                width="20">
                Perempuan</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #37ff00"
                width="20">
                Laki - Laki</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #37ff00"
                width="20">
                Perempuan</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #f2ff00"
                width="20">
                Laki - Laki</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #f2ff00"
                width="20">
                Perempuan</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #ff0000"
                width="20">
                Laki - Laki</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #ff0000"
                width="20">
                Perempuan</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #37ff00"
                width="20">
                Laki - Laki</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #37ff00"
                width="20">
                Perempuan</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #ff0000"
                width="20">
                Laki - Laki</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #ff0000"
                width="20">
                Perempuan</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #37ff00"
                width="20">
                Laki - Laki</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #37ff00"
                width="20">
                Perempuan</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #ff0000"
                width="20">
                Laki - Laki</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #ff0000"
                width="20">
                Perempuan</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #37ff00"
                width="20">
                Laki - Laki</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #37ff00"
                width="20">
                Perempuan</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #ff0000"
                width="20">
                Laki - Laki</th>
            <th align="center"
                style="vertical-align: center;border: 1px solid black;font-weight : bold;background-color : #ff0000"
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
                    {{ $dataArrayPria[$i]['totalHbNormal'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayWanita[$i]['totalHbNormal'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayPria[$i]['totalHbTerindikasiAnemia'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayWanita[$i]['totalHbTerindikasiAnemia'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayPria[$i]['totalHbAnemia'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayWanita[$i]['totalHbAnemia'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayPria[$i]['totalLingkarNormal'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayWanita[$i]['totalLingkarNormal'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayPria[$i]['totalLingkarKurangGizi'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayWanita[$i]['totalLingkarKurangGizi'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayPria[$i]['totalImtSangatKurus'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayWanita[$i]['totalImtSangatKurus'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayPria[$i]['totalImtKurus'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayWanita[$i]['totalImtKurus'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayPria[$i]['totalImtNormal'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayWanita[$i]['totalImtNormal'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayPria[$i]['totalImtGemuk'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayWanita[$i]['totalImtGemuk'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayPria[$i]['totalImtSangatGemuk'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayWanita[$i]['totalImtSangatGemuk'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayPria[$i]['totalMencegahMalnutrisi'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayWanita[$i]['totalMencegahMalnutrisi'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayPria[$i]['totalTidakMencegahMalnutrisi'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayWanita[$i]['totalTidakMencegahMalnutrisi'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayPria[$i]['totalMeningkatkanLifeSkill'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayWanita[$i]['totalMeningkatkanLifeSkill'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayPria[$i]['totalTidakMeningkatkanLifeSkill'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayWanita[$i]['totalTidakMeningkatkanLifeSkill'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayPria[$i]['totalMencegahPernikahanDini'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayWanita[$i]['totalMencegahPernikahanDini'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayPria[$i]['totalTidakMencegahPernikahanDini'] }}</td>
                <td align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                    {{ $dataArrayWanita[$i]['totalTidakMencegahPernikahanDini'] }}</td>

            </tr>
        @endfor
    </tbody>
</table>
