<x-filament-panels::page>
    <div x-data="{
        inputValues: @entangle('inputValues'),
        normalizedValues: @entangle('normalizedValues'),
        bobot: @entangle('bobot'),
        totals: @entangle('totals'),
        updateInverseValue(kiriId, atasId) {
            let nilai = parseFloat(this.inputValues[kiriId][atasId]);
            if (nilai && nilai !== 0) {
                this.inputValues[atasId][kiriId] = (1 / nilai).toFixed(4);
            } else {
                this.inputValues[atasId][kiriId] = 0;
            }
            this.updateAll();
        },
        updateTotals() {
            this.totals = {};
            for (let kiriId in this.inputValues) {
                for (let atasId in this.inputValues[kiriId]) {
                    if (!this.totals[atasId]) {
                        this.totals[atasId] = 0;
                    }
                    let nilai = parseFloat(this.inputValues[kiriId][atasId]);
                    if (!isNaN(nilai)) {
                        this.totals[atasId] += nilai;
                    }
                }
            }
        },
        updateNormalizedValues() {
            for (let kiriId in this.inputValues) {
                for (let atasId in this.inputValues[kiriId]) {
                    let nilai = parseFloat(this.inputValues[kiriId][atasId]);
                    if (!isNaN(nilai) && this.totals[atasId] !== 0) {
                        this.normalizedValues[kiriId][atasId] = (nilai / this.totals[atasId]).toFixed(4);
                    } else {
                        this.normalizedValues[kiriId][atasId] = 0;
                    }
                }
            }
        },
        updateBobot() {
            for (let kiriId in this.normalizedValues) {
                let total = 0;
                let count = 0;
                for (let atasId in this.normalizedValues[kiriId]) {
                    let nilai = parseFloat(this.normalizedValues[kiriId][atasId]);
                    if (!isNaN(nilai)) {
                        total += nilai;
                        count++;
                    }
                }
                this.bobot[kiriId] = (total / count).toFixed(4);
            }
        },
        updateAll() {
            this.updateTotals();
            this.updateNormalizedValues();
            this.updateBobot();
        }
    }" x-init="updateAll">
        <table class=" border-collapse w-full">
            <thead>
                <tr>
                    <th class="border border-gray-500 px-4 py-2 text-center">Alternatif</th>
                    @foreach($listPerusahaan as $perusahaan)
                        <th class="border border-gray-500 px-4 py-2 text-center">
                            {{ $perusahaan->nama_perusahaan }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($listPerusahaan as $perusahaanKiri)
                    <tr>
                        <td class="border border-gray-500 px-4 py-2 text-center">{{ $perusahaanKiri->nama_perusahaan }}</td>
                        @foreach($listPerusahaan as $perusahaanAtas)
                            <td class="border border-gray-500 px-4 py-2 text-center">
                                @if($perusahaanKiri->id === $perusahaanAtas->id)
                                    <x-filament::input.wrapper>
                                        <x-filament::input
                                            type="text"
                                            x-model="inputValues['{{ $perusahaanKiri->id }}']['{{ $perusahaanAtas->id }}']"
                                            readonly
                                            class="text-center"
                                        />
                                    </x-filament::input.wrapper>
                                @else
                                    <x-filament::input.wrapper>
                                        <x-filament::input
                                            type="text"
                                            x-model="inputValues['{{ $perusahaanKiri->id }}']['{{ $perusahaanAtas->id }}']"
                                            @input="updateInverseValue('{{ $perusahaanKiri->id }}', '{{ $perusahaanAtas->id }}')"
                                            class="text-center"
                                        />
                                    </x-filament::input.wrapper>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
                <tr>
                    <td class="border border-gray-500 px-4 py-2 text-center font-bold">Total</td>
                    @foreach($listPerusahaan as $perusahaanAtas)
                        <td class="border border-gray-500 px-4 py-2 text-center font-bold" x-text="totals['{{ $perusahaanAtas->id }}'] || 0"></td>
                    @endforeach
                </tr>
            </tbody>
        </table>

        <h2 class="mt-8 text-lg font-bold">Tabel Normalisasi</h2>
        <table class="border-collapse w-full mt-4">
            <thead>
                <tr>
                    <th class="border border-gray-500 px-4 py-2 text-center">Alternatif</th>
                    @foreach($listPerusahaan as $perusahaan)
                        <th class="border border-gray-500 px-4 py-2 text-center">
                            {{ $perusahaan->nama_perusahaan }}
                        </th>
                    @endforeach
                    <th class="border border-gray-500 px-4 py-2 text-center">Bobot</th>
                </tr>
            </thead>
            <tbody>
                @foreach($listperusahaan as $perusahaanKiri)
                    <tr>
                        <td class="border border-gray-500 px-4 py-2 text-center">{{ $perusahaanKiri->nama_perusahaan }}</td>
                        @foreach($listPerusahaan as $perusahaanAtas)
                            <td class="border border-gray-500 px-4 py-2 text-center" x-text="normalizedValues['{{ $perusahaanKiri->id }}']['{{ $perusahaanAtas->id }}'] || 0"></td>
                        @endforeach
                        <td class="border border-gray-500 px-4 py-2 text-center font-bold" x-text="bobot['{{ $perusahaanKiri->id }}'] || 0"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            <button type="button" @click="$wire.call('save')" class="px-3 py-2 bg-blue-600 hover:bg-[#60A5FA] text-white rounded-lg">
                Simpan
            </button>
        </div>
    </div>
</x-filament-panels::page>
