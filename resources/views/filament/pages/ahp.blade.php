<x-filament-panels::page>
    <div x-data="{
        inputValues: @entangle('inputValues'),
        normalizedValues: @entangle('normalizedValues'),
        priorityWeights: @entangle('priorityWeights'),
        consistencyMeasures: @entangle('consistencyMeasures'),
        lambdaMax: @entangle('lambdaMax'),
        consistencyIndex: @entangle('consistencyIndex'),
        consistencyRatio: @entangle('consistencyRatio'),
        ratioIndex: @entangle('ratioIndex'),
        selectedBobot: @entangle('selectedBobot'),
        totals: @entangle('totals'),
        consistencyStatus: '',
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
        updatePriorityWeights() {
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
                this.priorityWeights[kiriId] = (total / count).toFixed(4);
            }
        },
        updateConsistencyMeasures() {
            for (let kiriId in this.inputValues) {
                let total = 0;
                for (let atasId in this.inputValues[kiriId]) {
                    let nilai = parseFloat(this.inputValues[kiriId][atasId]);
                    let priorityWeight = parseFloat(this.priorityWeights[atasId]);
                    if (!isNaN(nilai) && !isNaN(priorityWeight)) {
                        total += nilai * priorityWeight;
                    }
                }
                this.consistencyMeasures[kiriId] = (total / this.priorityWeights[kiriId]).toFixed(4);
            }
        },
        updateLambdaMax() {
            let total = 0;
            let count = 0;
            for (let id in this.consistencyMeasures) {
                let nilai = parseFloat(this.consistencyMeasures[id]);
                if (!isNaN(nilai)) {
                    total += nilai;
                    count++;
                }
            }
            this.lambdaMax = (total / count).toFixed(4);
        },
        updateConsistencyIndex() {
            let n = Object.keys(this.inputValues).length;
            this.consistencyIndex = ((this.lambdaMax - n) / (n - 1)).toFixed(4);
        },
        updateConsistencyRatio() {
            let n = Object.keys(this.inputValues).length;
            this.consistencyRatio = (this.consistencyIndex / this.ratioIndex).toFixed(4);
        },
        updateConsistencyStatus() {
            this.consistencyStatus = this.consistencyRatio < 0.1 ? 'Konsisten' : 'Tidak Konsisten';
        },
        updateAll() {
            this.updateTotals();
            this.updateNormalizedValues();
            this.updatePriorityWeights();
            this.updateConsistencyMeasures();
            this.updateLambdaMax();
            this.updateConsistencyIndex();
            this.updateConsistencyRatio();
            this.updateConsistencyStatus();
        }
    }" x-init="updateAll">
    <div class="mb-4">
        <label for="bobot" class="block text-md font-medium mb-4">Pilih Bobot:</label>
        <div class="w-1/5">
            <x-filament::input.wrapper>
                <x-filament::input.select wire:model="selectedBobot">
                    @foreach (App\Enums\BobotEnum::cases() as $bobot)
                        <option value="{{ $bobot->value }}">{{ $bobot->getLabel() }}</option>
                    @endforeach
                </x-filament::input.select>
            </x-filament::input.wrapper>
        </div>
    </div>
        <table class="border-collapse w-full">
            <thead>
                <tr>
                    <th class="border border-gray-500 px-4 py-2 text-center">Kriteria</th>
                    @foreach($listJenisEvaluasi as $jenisEvaluasi)
                        <th class="border border-gray-500 px-4 py-2 text-center">
                            {{ $jenisEvaluasi->nama_jenis }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($listJenisEvaluasi as $jenisEvaluasiKiri)
                    <tr>
                        <td class="border border-gray-500 px-4 py-2 text-center">{{ $jenisEvaluasiKiri->nama_jenis }}</td>
                        @foreach($listJenisEvaluasi as $jenisEvaluasiAtas)
                            <td class="border border-gray-500 px-4 py-2 text-center">
                                @if($jenisEvaluasiKiri->id === $jenisEvaluasiAtas->id)
                                    <x-filament::input.wrapper>
                                        <x-filament::input
                                            type="text"
                                            x-model="inputValues['{{ $jenisEvaluasiKiri->id }}']['{{ $jenisEvaluasiAtas->id }}']"
                                            readonly
                                            class="text-center"
                                        />
                                    </x-filament::input.wrapper>
                                @else
                                    <x-filament::input.wrapper>
                                        <x-filament::input
                                            type="text"
                                            x-model="inputValues['{{ $jenisEvaluasiKiri->id }}']['{{ $jenisEvaluasiAtas->id }}']"
                                            @input="updateInverseValue('{{ $jenisEvaluasiKiri->id }}', '{{ $jenisEvaluasiAtas->id }}')"
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
                    @foreach($listJenisEvaluasi as $jenisEvaluasiAtas)
                        <td class="border border-gray-500 px-4 py-2 text-center font-bold" x-text="totals['{{ $jenisEvaluasiAtas->id }}'] || 0"></td>
                    @endforeach
                </tr>
            </tbody>
        </table>

        <h2 class="mt-8 text-lg font-bold">Tabel Normalisasi</h2>
        <table class="border-collapse w-full mt-4">
            <thead>
                <tr>
                    <th class="border border-gray-500 px-4 py-2 text-center">Kriteria</th>
                    @foreach($listJenisEvaluasi as $jenisEvaluasi)
                        <th class="border border-gray-500 px-4 py-2 text-center">
                            {{ $jenisEvaluasi->nama_jenis }}
                        </th>
                    @endforeach
                    <th class="border border-gray-500 px-4 py-2 text-center">Bobot Prioritas</th>
                    <th class="border border-gray-500 px-4 py-2 text-center">CM</th>
                </tr>
            </thead>
            <tbody>
                @foreach($listJenisEvaluasi as $jenisEvaluasiKiri)
                    <tr>
                        <td class="border border-gray-500 px-4 py-2 text-center">{{ $jenisEvaluasiKiri->nama_jenis }}</td>
                        @foreach($listJenisEvaluasi as $jenisEvaluasiAtas)
                            <td class="border border-gray-500 px-4 py-2 text-center" x-text="normalizedValues['{{ $jenisEvaluasiKiri->id }}']['{{ $jenisEvaluasiAtas->id }}'] || 0"></td>
                        @endforeach
                        <td class="border border-gray-500 px-4 py-2 text-center font-bold" x-text="priorityWeights['{{ $jenisEvaluasiKiri->id }}'] || 0"></td>
                        <td class="border border-gray-500 px-4 py-2 text-center font-bold" x-text="consistencyMeasures['{{ $jenisEvaluasiKiri->id }}'] || 0"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-8 mb-4">
            <table class="border-collapse">
                <tbody>
                    <tr>
                        <td class="py-2 px-4 border border-gray-500">Lambda Max</td>
                        <td class="py-2 px-4 border border-gray-500 text-center"><span x-text="lambdaMax"></span></td>
                    </tr>
                    <tr>
                        <td class="py-2 px-4 border border-gray-500">Ratio Index (RI)</td>
                        <td class="py-2 px-4 border border-gray-500 text-center">
                            <span x-text="ratioIndex"></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="py-2 px-4 border border-gray-500">Consistency Index (CI)</td>
                        <td class="py-2 px-4 border border-gray-500 text-center"><span x-text="consistencyIndex"></span></td>
                    </tr>
                    <tr>
                        <td class="py-2 px-4 border border-gray-500">Consistency Ratio (CR)</td>
                        <td class="py-2 px-4 border border-gray-500 text-center"><span x-text="consistencyRatio"></span></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="flex justify-start items-center space-x-2 mb-4">
            <span>Status Konsistensi: </span>
            <span :class="{
                'text-green-500': consistencyRatio < 0.1,
                'text-red-500': consistencyRatio >= 0.1
            }" x-text="consistencyStatus"></span>
        </div>
        <div class="mt-4">
            <button type="button" @click="$wire.call('save')" class="px-3 py-2 bg-blue-600 hover:bg-[#60A5FA] text-white rounded-lg">
                Simpan
            </button>
        </div>
    </div>
</x-filament-panels::page>
